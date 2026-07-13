/**
 * KiteJS - Lightweight SPA Engine for KitePHP
 */
document.addEventListener('DOMContentLoaded', () => {
    Kite.init();
});

const Kite = {
    init() {
        this.bindEvents(document.body);
        window.addEventListener('popstate', (e) => {
            if (e.state && e.state.url) {
                this.navigate(e.state.url, false);
            } else {
                this.navigate(window.location.href, false);
            }
        });
    },

    bindEvents(root) {
        // 1. Handle Forms with kite:submit FIRST
        // We do forms first because cloning a form destroys event listeners on its children.
        // If we clone forms first, the links inside them will be cloned. Then step 2 will bind the links.
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

        // 2. Handle Links with kite:navigate
        const links = root.querySelectorAll('a[kite\\:navigate]');
        links.forEach(link => {
            // Remove old listener to prevent duplicates if re-binding
            link.replaceWith(link.cloneNode(true));
        });
        
        // Re-query after cloning
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
            window.location.href = url; // fallback to normal navigation
        }
        this.hideLoading();
    },

    async submitForm(form) {
        this.showLoading(form);
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
            this.replaceContent(html);
        } catch (error) {
            console.error('KiteJS Form Submit Error:', error);
            form.submit(); // fallback
        }
        this.hideLoading(form);
    },

    replaceContent(html, url = null, pushState = true) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // Update Title
        if (doc.title) {
            document.title = doc.title;
        }

        // Update Body Attributes (like CSS classes)
        Array.from(document.body.attributes).forEach(attr => document.body.removeAttribute(attr.name));
        Array.from(doc.body.attributes).forEach(attr => document.body.setAttribute(attr.name, attr.value));

        // Update Body Content
        document.body.innerHTML = doc.body.innerHTML;

        // Re-bind events to new DOM
        this.bindEvents(document.body);

        // Update History
        if (pushState && url) {
            window.history.pushState({ url: url }, '', url);
        }

        // Scroll to top
        window.scrollTo(0, 0);
    },

    showLoading(element = null) {
        document.body.style.cursor = 'wait';
        document.body.style.pointerEvents = 'none'; // Prevent double clicks
    },

    hideLoading(element = null) {
        document.body.style.cursor = 'default';
        document.body.style.pointerEvents = 'auto';
    }
};
