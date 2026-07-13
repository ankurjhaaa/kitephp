<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KitePHP - Micro-Framework' }}</title>
    <script src="{{ asset('tailwind.js') }}"></script>
    <script src="{{ asset('kite.js') }}"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #050505; color: #ededed; }
        .mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }
        
        .bg-grid-flat {
            background-size: 32px 32px;
            background-image: linear-gradient(to right, #111 1px, transparent 1px),
                              linear-gradient(to bottom, #111 1px, transparent 1px);
        }
        
        /* Custom Scrollbar for code blocks */
        ::-webkit-scrollbar { height: 6px; width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #333; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-grid-flat selection:bg-gray-700 selection:text-white">

    <!-- Navbar (Fixed) -->
    <header class="fixed top-0 w-full z-50 border-b border-[#222] bg-[#050505]/95 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="font-bold text-lg tracking-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                KitePHP
            </div>
            <nav class="flex gap-6 text-[13px] font-medium text-[#888]">
                <a href="#" class="hover:text-[#ededed] transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Docs
                </a>
                <a href="https://github.com/ankurjha/kitephp" class="hover:text-[#ededed] transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    GitHub
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Hero -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-6 pt-32 pb-16 flex flex-col xl:flex-row items-start gap-16">
        
        <!-- Left: Copy -->
        <div class="flex-1 text-left w-full xl:max-w-xl xl:sticky xl:top-32">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#111] border border-[#333] text-[11px] font-semibold tracking-widest uppercase mb-8 text-[#888]">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                v1.0 is Live
            </div>
            
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold tracking-tighter leading-[1.05] mb-6 text-white">
                PHP Framework<br>
                <span class="text-[#555]">Reimagined.</span>
            </h1>
            
            <p class="text-[16px] text-[#888] leading-relaxed mb-10">
                A flat, minimalist micro-framework. Get the backend power of Laravel with the instant interactivity of a React SPA—no build steps required.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-4">
                <a href="#" class="w-full sm:w-auto px-7 py-3 bg-white hover:bg-[#ccc] text-black text-[14px] font-bold transition-colors flex items-center justify-center gap-2">
                    Get Started
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <div class="w-full sm:w-auto px-5 py-3 bg-[#111] border border-[#333] text-[#888] text-[13px] mono flex items-center justify-center gap-3 select-all">
                    <span class="text-[#555]">$</span> composer create-project kitephp/core
                </div>
            </div>
        </div>

        <!-- Right: Code Snippets Grid -->
        <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-1 gap-6">
            
            <!-- Backend Code Snippet -->
            <div class="bg-[#0a0a0a] border border-[#222] text-[13px] mono leading-relaxed text-[#ccc] w-full shadow-2xl">
                <div class="flex items-center gap-2 px-4 py-2 border-b border-[#222] bg-[#111]">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                    <span class="text-[#888]">Backend: MVC & Routing</span>
                </div>
                <div class="p-5 overflow-x-auto">
                    <div class="text-[#555] mb-2">// 1. Database Model (No migrations needed)</div>
                    <span class="text-[#a5b4fc]">class</span> <span class="text-white">User</span> <span class="text-[#a5b4fc]">extends</span> <span class="text-white">Model</span> {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#a5b4fc]">public static function</span> <span class="text-white">fields</span>() {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#a5b4fc]">return</span> [<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#86efac]">'name'</span>  =&gt; Field::<span class="text-[#a5b4fc]">string</span>(),<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#86efac]">'email'</span> =&gt; Field::<span class="text-[#a5b4fc]">string</span>([<span class="text-[#86efac]">'unique'</span> =&gt; <span class="text-[#a5b4fc]">true</span>])<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;];<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                    }<br><br>
                    <div class="text-[#555] mb-2">// 2. Controller & Query Builder</div>
                    <span class="text-[#a5b4fc]">class</span> <span class="text-white">UserController</span> {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#a5b4fc]">public function</span> <span class="text-white">index</span>() {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-white">$users</span> = <span class="text-[#a5b4fc]">db</span>(<span class="text-[#86efac]">'users'</span>)-&gt;<span class="text-[#a5b4fc]">paginate</span>(<span class="text-white">10</span>);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#a5b4fc]">return</span> <span class="text-[#a5b4fc]">view</span>(<span class="text-[#86efac]">'users.index'</span>, [<span class="text-[#86efac]">'users'</span> =&gt; <span class="text-white">$users</span>]);<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                    }<br><br>
                    <div class="text-[#555] mb-2">// 3. Route Map</div>
                    <span class="text-[#a5b4fc]">get</span>(<span class="text-[#86efac]">'/users'</span>, <span class="text-[#86efac]">'UserController@index'</span>);
                </div>
            </div>

            <!-- Frontend Code Snippet -->
            <div class="bg-[#0a0a0a] border border-[#222] text-[13px] mono leading-relaxed text-[#ccc] w-full shadow-2xl">
                <div class="flex items-center gap-2 px-4 py-2 border-b border-[#222] bg-[#111]">
                    <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    <span class="text-[#888]">Frontend: Zero-Config SPA Reactivity</span>
                </div>
                <div class="p-5 overflow-x-auto">
                    <div class="text-[#555] mb-2">&lt;!-- Instant SPA Navigation (No full reload) --&gt;</div>
                    <span class="text-[#fca5a5]">&lt;a</span> <span class="text-[#93c5fd]">href</span>=<span class="text-[#86efac]">"/users"</span> <span class="text-[#93c5fd]">kite:navigate</span><span class="text-[#fca5a5]">&gt;</span>Load Users<span class="text-[#fca5a5]">&lt;/a&gt;</span><br><br>
                    
                    <div class="text-[#555] mb-2">&lt;!-- Client-side state without writing JS --&gt;</div>
                    <span class="text-[#fca5a5]">&lt;div</span> <span class="text-[#93c5fd]">kite:data</span>=<span class="text-[#86efac]">"{ tab: 'recent' }"</span><span class="text-[#fca5a5]">&gt;</span><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#fca5a5]">&lt;button</span> <span class="text-[#93c5fd]">kite:click</span>=<span class="text-[#86efac]">"tab = 'recent'"</span><span class="text-[#fca5a5]">&gt;</span>Recent<span class="text-[#fca5a5]">&lt;/button&gt;</span><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#fca5a5]">&lt;button</span> <span class="text-[#93c5fd]">kite:click</span>=<span class="text-[#86efac]">"tab = 'all'"</span><span class="text-[#fca5a5]">&gt;</span>All<span class="text-[#fca5a5]">&lt;/button&gt;</span><br>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#fca5a5]">&lt;div</span> <span class="text-[#93c5fd]">kite:show</span>=<span class="text-[#86efac]">"tab === 'recent'"</span><span class="text-[#fca5a5]">&gt;</span>...<span class="text-[#fca5a5]">&lt;/div&gt;</span><br>
                    <span class="text-[#fca5a5]">&lt;/div&gt;</span><br><br>

                    <div class="text-[#555] mb-2">&lt;!-- Debounced Live Search --&gt;</div>
                    <span class="text-[#fca5a5]">&lt;form</span> <span class="text-[#93c5fd]">kite:submit</span> <span class="text-[#93c5fd]">kite:live.debounce.300ms</span><span class="text-[#fca5a5]">&gt;</span><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-[#fca5a5]">&lt;input</span> <span class="text-[#93c5fd]">type</span>=<span class="text-[#86efac]">"text"</span> <span class="text-[#93c5fd]">name</span>=<span class="text-[#86efac]">"search"</span><span class="text-[#fca5a5]">&gt;</span><br>
                    <span class="text-[#fca5a5]">&lt;/form&gt;</span>
                </div>
            </div>
            
        </div>
        
    </main>

    <!-- Features Grid (Flat & Wider) -->
    <section class="w-full border-t border-[#222] bg-[#050505]">
        <div class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Feature 1 -->
            <div class="bg-[#0a0a0a] border border-[#222] p-8 hover:border-[#444] transition-colors">
                <svg class="w-7 h-7 text-white mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <h3 class="text-[16px] font-semibold text-white mb-3">SPA Navigation</h3>
                <p class="text-[14px] text-[#888] leading-relaxed">Links and forms submit via AJAX instantly. No full page reloads, just pure speed.</p>
            </div>
            <!-- Feature 2 -->
            <div class="bg-[#0a0a0a] border border-[#222] p-8 hover:border-[#444] transition-colors">
                <svg class="w-7 h-7 text-white mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                <h3 class="text-[16px] font-semibold text-white mb-3">Smart ORM</h3>
                <p class="text-[14px] text-[#888] leading-relaxed">Forget migration files. Schemas are defined in model classes. Run migrate and sync.</p>
            </div>
            <!-- Feature 3 -->
            <div class="bg-[#0a0a0a] border border-[#222] p-8 hover:border-[#444] transition-colors">
                <svg class="w-7 h-7 text-white mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                <h3 class="text-[16px] font-semibold text-white mb-3">Reactive State</h3>
                <p class="text-[14px] text-[#888] leading-relaxed">Define state directly in HTML. Logic and UI remain perfectly synchronized.</p>
            </div>
            <!-- Feature 4 -->
            <div class="bg-[#0a0a0a] border border-[#222] p-8 hover:border-[#444] transition-colors">
                <svg class="w-7 h-7 text-white mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <h3 class="text-[16px] font-semibold text-white mb-3">Secure Core</h3>
                <p class="text-[14px] text-[#888] leading-relaxed">PDO prepared statements, CSRF protection, and automatic XSS escaping built-in.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full border-t border-[#222] bg-[#050505] py-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4 text-[13px] text-[#666]">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-[#222] border border-[#333] flex items-center justify-center">
                    <div class="w-1.5 h-1.5 bg-white"></div>
                </div>
                &copy; 2026 KitePHP.
            </div>
            <div class="flex gap-8 font-medium">
                <a href="#" class="hover:text-white transition-colors">Twitter</a>
                <a href="#" class="hover:text-white transition-colors">Discord</a>
                <a href="#" class="hover:text-white transition-colors">GitHub</a>
            </div>
        </div>
    </footer>

</body>
</html>