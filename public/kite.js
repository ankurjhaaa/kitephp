/**
 * KiteJS - Lightweight SPA Engine & Reactive Engine for KitePHP
 */
document.addEventListener('DOMContentLoaded', () => {
    Kite.init();
});

const Kite = {
    state: {}, // Global Reactive State
    
    init() {
        this.bindEvents(document.body);
        this.initReactive(document.body); // Initialize Reactive Engine
        
        window.addEventListener('popstate', (e) => {
            if (e.state && e.state.url) {
                this.navigate(e.state.url, false);
            } else {
                this.navigate(window.location.href, false);
            }
        });
    },

    // --- REACTIVE ENGINE ---

    initReactive(root) {
        // 1. Find kite:data and initialize state
        const dataElements = Array.from(root.querySelectorAll('[kite\\:data]'));
        if (root.hasAttribute && root.hasAttribute('kite:data')) {
            dataElements.push(root);
        }
        let initialState = {};
        
        dataElements.forEach(el => {
            try {
                // Parse the JSON-like string (e.g. { count: 0, name: 'Ankur' })
                let dataStr = el.getAttribute('kite:data');
                // Use Function to safely evaluate JS object syntax
                let parsed = new Function('return ' + dataStr)();
                Object.assign(initialState, parsed);
            } catch (e) {
                console.error("KiteJS: Invalid kite:data syntax", e);
            }
        });

        // 2. Create Reactive Proxy
        this.state = new Proxy(initialState, {
            set: (target, key, value) => {
                target[key] = value;
                this.updateDOM(key, value, document.body);
                return true;
            }
        });

        // 3. Bind Actions (kite:click, kite:function)
        const actions = root.querySelectorAll('[kite\\:click], [kite\\:function]');
        actions.forEach(el => {
            let actionStr = el.getAttribute('kite:click') || el.getAttribute('kite:function');
            if (actionStr) {
                el.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.executeFunction(actionStr);
                });
            }
        });

        // 4. Auto-Bind Inputs based on name attribute
        const inputs = root.querySelectorAll('input[name], textarea[name], select[name]');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (this.state.hasOwnProperty(name)) {
                // Sync initial DOM state to Reactive State
                if (input.value !== this.state[name] && this.state[name] !== '') {
                    input.value = this.state[name];
                } else if (input.value !== '') {
                    this.state[name] = input.value;
                }
                
                // Listen to changes (two-way binding)
                input.addEventListener('input', (e) => {
                    this.state[name] = e.target.value;
                });
            }
        });
        
        // Initial DOM update for all variables
        Object.keys(this.state).forEach(key => this.updateDOM(key, this.state[key], document.body));
    },

    executeFunction(funcStr) {
        try {
            // "with" statement is the easiest way to bind scope dynamically
            const func = new Function('state', `
                with (state) {
                    ${funcStr}
                }
            `);
            func(this.state);
        } catch (e) {
            console.error("KiteJS: Error executing function", funcStr, e);
        }
    },

    updateDOM(key, value, root) {
        // Update Auto-Wrapped variables (compiled by View.php)
        const vars = root.querySelectorAll(`kite-var[data-key="${key}"]`);
        vars.forEach(el => {
            el.innerHTML = value;
        });

        // Update bound inputs
        const inputs = root.querySelectorAll(`input[name="${key}"], textarea[name="${key}"], select[name="${key}"]`);
        inputs.forEach(input => {
            if (input.value !== String(value)) {
                input.value = value;
            }
        });

        // Update kite:show visibility
        const shows = root.querySelectorAll(`[kite\\:show]`);
        shows.forEach(el => {
            const expr = el.getAttribute('kite:show');
            try {
                const func = new Function('state', `with(state) { return !!(${expr}); }`);
                const isVisible = func(this.state);
                el.style.display = isVisible ? '' : 'none';
            } catch (e) {
                console.error("KiteJS: Error in kite:show", expr, e);
            }
        });
    },

    // --- SPA NAVIGATION ENGINE ---

    bindEvents(root) {
        const forms = root.querySelectorAll('form[kite\\:submit]');
        forms.forEach(form => {
            form.replaceWith(form.cloneNode(true));
        });

        root.querySelectorAll('form[kite\\:submit]').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitForm(form);
            });
        });
        
        // --- kite:live (Debounced Live Form Submission) ---
        const liveForms = Array.from(root.querySelectorAll('form')).filter(form => {
            return Array.from(form.attributes).some(attr => attr.name.startsWith('kite:live'));
        });

        liveForms.forEach(form => {
            let debounceTime = 300; // default
            
            // Extract debounce time from attribute (e.g. kite:live.debounce.500ms)
            const liveAttr = Array.from(form.attributes).find(attr => attr.name.startsWith('kite:live'));
            if (liveAttr) {
                const parts = liveAttr.name.split('.');
                const debounceIndex = parts.indexOf('debounce');
                if (debounceIndex !== -1 && parts[debounceIndex + 1]) {
                    debounceTime = parseInt(parts[debounceIndex + 1]) || 300;
                }
            }
            
            let timeout = null;
            form.addEventListener('input', (e) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    this.submitForm(form, true);
                }, debounceTime);
            });
        });

        const links = root.querySelectorAll('a[kite\\:navigate]');
        links.forEach(link => {
            link.replaceWith(link.cloneNode(true));
        });

        root.querySelectorAll('a[kite\\:navigate]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                let url = link.getAttribute('href');
                if (url) {
                    this.navigate(url);
                }
            });
        });
    },

    async navigate(url, pushState = true) {
        this.showLoading();
        try {
            const response = await fetch(url, {
                headers: {
                    'X-Kite-Request': 'true',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.headers.has('X-Kite-Redirect')) {
                let redirectUrl = response.headers.get('X-Kite-Redirect');
                return this.navigate(redirectUrl, pushState);
            }

            const html = await response.text();
            this.replaceContent(html, url, pushState);
        } catch (error) {
            console.error('KiteJS Navigation Error:', error);
            window.location.href = url; // fallback
        }
        this.hideLoading();
    },

    async submitForm(form, isLive = false) {
        if (!isLive) this.showLoading(form);
        let url = form.getAttribute('action') || window.location.href;
        const method = (form.getAttribute('method') || 'GET').toUpperCase();

        const formData = new FormData(form);
        const fetchOptions = {
            method: method,
            headers: {
                'X-Kite-Request': 'true',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        if (method !== 'GET') {
            fetchOptions.body = formData;
        } else {
            const params = new URLSearchParams(formData);
            url += (url.includes('?') ? '&' : '?') + params.toString();
        }

        try {
            const response = await fetch(url, fetchOptions);

            if (response.headers.has('X-Kite-Redirect')) {
                let redirectUrl = response.headers.get('X-Kite-Redirect');
                return this.navigate(redirectUrl);
            }

            const html = await response.text();
            this.replaceContent(html, null, true, isLive);
        } catch (error) {
            console.error('KiteJS Form Submit Error:', error);
            if (!isLive) form.submit();
        }
        if (!isLive) this.hideLoading(form);
    },

    replaceContent(html, url = null, pushState = true, isLive = false) {
        // Save focus state for Live Forms
        const activeElement = document.activeElement;
        const activeId = activeElement ? activeElement.id : null;
        const activeName = activeElement ? activeElement.getAttribute('name') : null;
        const selectionStart = activeElement ? activeElement.selectionStart : null;
        const selectionEnd = activeElement ? activeElement.selectionEnd : null;

        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        if (doc.title) {
            document.title = doc.title;
        }

        Array.from(document.body.attributes).forEach(attr => document.body.removeAttribute(attr.name));
        Array.from(doc.body.attributes).forEach(attr => document.body.setAttribute(attr.name, attr.value));

        document.body.innerHTML = doc.body.innerHTML;

        this.bindEvents(document.body);
        this.initReactive(document.body); // Re-initialize reactivity on new DOM

        if (pushState && url) {
            window.history.pushState({ url: url }, '', url);
        }

        // Restore focus state for Live Forms
        if (isLive) {
            let newActiveElement = null;
            if (activeId) {
                newActiveElement = document.getElementById(activeId);
            } else if (activeName) {
                newActiveElement = document.querySelector(`[name="${activeName}"]`);
            }

            if (newActiveElement) {
                newActiveElement.focus();
                try {
                    // Only text inputs support selection ranges
                    if (selectionStart !== null && (newActiveElement.type === 'text' || newActiveElement.type === 'search' || newActiveElement.tagName === 'TEXTAREA')) {
                        newActiveElement.setSelectionRange(selectionStart, selectionEnd);
                    }
                } catch (e) {}
            }
        } else {
            // Only scroll to top on hard navigation
            window.scrollTo(0, 0);
        }
    },

    showLoading() {
        document.body.style.cursor = 'wait';
        document.body.style.pointerEvents = 'none';
    },

    hideLoading() {
        document.body.style.cursor = 'default';
        document.body.style.pointerEvents = 'auto';
    }
};
