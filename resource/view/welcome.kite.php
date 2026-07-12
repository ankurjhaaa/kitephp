<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KitePHP Documentation' }}</title>
    <script src="{{ asset('tailwind.js') }}"></script>
    <script src="{{ asset('kite.js') }}"></script>
    <style>
        /* Custom scrollbar for dark mode */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #0f111a; }
        ::-webkit-scrollbar-thumb { background: #2d3748; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #4a5568; }
    </style>
</head>
<body class="bg-[#0f111a] text-gray-300 antialiased font-sans flex flex-col md:flex-row min-h-screen selection:bg-blue-500/30 selection:text-blue-200">

    <!-- Mobile Header -->
    <div class="md:hidden bg-[#161b22] border-b border-gray-800 p-3 sticky top-0 z-20 flex justify-between items-center">
        <div class="text-lg font-black text-blue-400 tracking-tighter flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            KitePHP
        </div>
        <button onclick="document.getElementById('sidebar').classList.toggle('hidden')" class="p-1.5 bg-gray-800 rounded text-gray-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="hidden md:flex flex-col w-full md:w-56 bg-[#161b22] border-r border-gray-800 h-screen sticky top-0 overflow-y-auto shrink-0 z-10">
        <div class="p-5">
            <div class="text-xl font-black text-blue-400 tracking-tighter flex items-center gap-2 mb-6 hidden md:flex">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                KitePHP
            </div>
            
            <nav class="space-y-0.5 text-sm font-medium">
                <a href="#intro" class="block px-2.5 py-1.5 rounded hover:bg-gray-800 hover:text-white text-gray-400 transition-colors">Introduction</a>
                <a href="#structure" class="block px-2.5 py-1.5 rounded hover:bg-gray-800 hover:text-white text-gray-400 transition-colors">Directory Structure</a>
                <a href="#routing" class="block px-2.5 py-1.5 rounded hover:bg-gray-800 hover:text-white text-gray-400 transition-colors">Routing</a>
                <a href="#controllers" class="block px-2.5 py-1.5 rounded hover:bg-gray-800 hover:text-white text-gray-400 transition-colors">Controllers</a>
                <a href="#views" class="block px-2.5 py-1.5 rounded hover:bg-gray-800 hover:text-white text-gray-400 transition-colors">Views (Kite Engine)</a>
                <a href="#models" class="block px-2.5 py-1.5 rounded hover:bg-gray-800 hover:text-white text-gray-400 transition-colors">Models & Migrations</a>
                <a href="#querybuilder" class="block px-2.5 py-1.5 rounded hover:bg-gray-800 hover:text-white text-gray-400 transition-colors">Query Builder</a>
                <a href="#kitejs" class="block px-2.5 py-1.5 rounded hover:bg-gray-800 hover:text-white text-gray-400 transition-colors">SPA Engine</a>
                <a href="#helpers" class="block px-2.5 py-1.5 rounded hover:bg-gray-800 hover:text-white text-gray-400 transition-colors">Helpers</a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden">
        <div class="max-w-4xl mx-auto p-5 md:p-8 xl:p-10">
            
            <!-- Hero -->
            <div id="intro" class="mb-10 pt-2">
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white mb-3">The Full Stack PHP Micro-Framework</h1>
                <p class="text-sm text-gray-400 leading-relaxed mb-5 max-w-2xl">KitePHP gives you the developer experience of Laravel and the speed of a React SPA, without the heavy setup. It comes with built-in TailwindCSS, smart migrations, and a zero-config SPA engine.</p>
                <div class="flex gap-3">
                    <a href="#models" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded transition-colors">Explore Models</a>
                    <a href="#kitejs" class="px-4 py-2 bg-gray-800 border border-gray-700 hover:bg-gray-700 text-gray-300 text-sm font-semibold rounded transition-colors">Learn KiteJS</a>
                </div>
            </div>

            <hr class="border-gray-800 mb-10">

            <!-- Directory Structure -->
            <section id="structure" class="mb-10 scroll-mt-20">
                <h2 class="text-xl font-bold text-gray-100 mb-3 flex items-center gap-2">📁 Directory Structure</h2>
<pre class="bg-[#0d1117] border border-gray-800 rounded-lg p-4 text-xs font-mono overflow-x-auto text-gray-300 leading-normal mb-4"><code><span class="text-blue-400 font-bold">kitephp/</span>
├── <span class="text-yellow-300">app/</span>          <span class="text-gray-500"># Application Logic</span>
│   └── <span class="text-blue-300">controller/</span> <span class="text-gray-500"># HTTP Controllers</span>
├── <span class="text-yellow-300">core/</span>         <span class="text-gray-500"># The Framework Engine</span>
├── <span class="text-yellow-300">database/</span>     <span class="text-gray-500"># SQLite DB & Config</span>
│   └── <span class="text-green-400">models.php</span>  <span class="text-gray-500"># Models & Schemas</span>
├── <span class="text-yellow-300">helper/</span>       <span class="text-gray-500"># Global functions</span>
├── <span class="text-yellow-300">public/</span>       <span class="text-gray-500"># Web Root (index.php)</span>
├── <span class="text-yellow-300">resource/</span>     <span class="text-gray-500"># Frontend Resources</span>
│   └── <span class="text-blue-300">view/</span>       <span class="text-gray-500"># Kite Templates (*.kite.php)</span>
├── <span class="text-yellow-300">route/</span>        <span class="text-gray-500"># Web Routes</span>
│   └── <span class="text-green-400">url.php</span>     <span class="text-gray-500"># Map URLs to Controllers</span>
└── <span class="text-green-400">kite</span>          <span class="text-gray-500"># CLI Tool</span></code></pre>
            </section>

            <!-- Routing -->
            <section id="routing" class="mb-10 scroll-mt-20">
                <h2 class="text-xl font-bold text-gray-100 mb-3 flex items-center gap-2">🛣️ Routing</h2>
                <p class="text-gray-400 text-sm mb-3">Routes are registered in <code class="bg-gray-800 text-pink-400 px-1 py-0.5 rounded font-mono text-xs">route/url.php</code>.</p>
<pre class="bg-[#0d1117] border border-gray-800 rounded-lg p-4 text-xs font-mono overflow-x-auto text-gray-300 leading-normal mb-4"><code><span class="text-gray-500">// Basic GET and POST routes</span>
<span class="text-purple-400">get</span>(<span class="text-green-400">'/'</span>, <span class="text-green-400">'HomeController@index'</span>)-&gt;name(<span class="text-green-400">'home'</span>);
<span class="text-purple-400">post</span>(<span class="text-green-400">'/login'</span>, <span class="text-green-400">'AuthController@login'</span>)-&gt;name(<span class="text-green-400">'login.post'</span>);

<span class="text-gray-500">// Route parameters</span>
<span class="text-purple-400">get</span>(<span class="text-green-400">'/user/{id}'</span>, <span class="text-blue-400">function</span>(<span class="text-yellow-300">$id</span>) {
    <span class="text-blue-400">return</span> <span class="text-green-400">"User ID: "</span> . <span class="text-yellow-300">$id</span>;
});</code></pre>
            </section>

            <!-- Controllers -->
            <section id="controllers" class="mb-10 scroll-mt-20">
                <h2 class="text-xl font-bold text-gray-100 mb-3 flex items-center gap-2">⚙️ Controllers & Request</h2>
                <p class="text-gray-400 text-sm mb-3">The <code class="bg-gray-800 text-pink-400 px-1 py-0.5 rounded font-mono text-xs">Request</code> object is automatically injected.</p>
<pre class="bg-[#0d1117] border border-gray-800 rounded-lg p-4 text-xs font-mono overflow-x-auto text-gray-300 leading-normal mb-4"><code><span class="text-blue-400">namespace</span> <span class="text-yellow-200">App\Controller</span>;
<span class="text-blue-400">use</span> <span class="text-yellow-200">Kite\Core\Request</span>;

<span class="text-blue-400">class</span> <span class="text-yellow-300">UserController</span> {
    <span class="text-blue-400">public function</span> <span class="text-purple-400">store</span>(Request <span class="text-yellow-300">$request</span>) {
        <span class="text-yellow-300">$name</span> = <span class="text-yellow-300">$request</span>-&gt;<span class="text-purple-400">input</span>(<span class="text-green-400">'name'</span>, <span class="text-green-400">'Default'</span>);
        <span class="text-purple-400">session</span>()-&gt;<span class="text-purple-400">flash</span>(<span class="text-green-400">'success'</span>, <span class="text-green-400">'Created!'</span>);
        <span class="text-blue-400">return</span> <span class="text-purple-400">redirect</span>(<span class="text-purple-400">route</span>(<span class="text-green-400">'home'</span>));
    }
}</code></pre>
            </section>

            <!-- Views -->
            <section id="views" class="mb-10 scroll-mt-20">
                <h2 class="text-xl font-bold text-gray-100 mb-3 flex items-center gap-2">🎨 Views (Kite Engine)</h2>
                <p class="text-gray-400 text-sm mb-3">Similar to Laravel Blade. Use <code class="bg-gray-800 text-pink-400 px-1 py-0.5 rounded font-mono text-xs">.kite.php</code> extension.</p>
<pre class="bg-[#0d1117] border border-gray-800 rounded-lg p-4 text-xs font-mono overflow-x-auto text-gray-300 leading-normal mb-4"><code><span class="text-blue-400">&#64;extends</span>(<span class="text-green-400">'layout'</span>)

<span class="text-blue-400">&#64;section</span>(<span class="text-green-400">'content'</span>)
    &lt;<span class="text-pink-400">h1</span>&gt;Hello <span class="text-yellow-300">&#123;&#123; $user-&gt;name &#125;&#125;</span>&lt;/<span class="text-pink-400">h1</span>&gt;
    
    <span class="text-blue-400">&#64;if</span>(<span class="text-yellow-300">$user</span>-&gt;isAdmin)
        &lt;<span class="text-pink-400">p</span>&gt;Admin access&lt;/<span class="text-pink-400">p</span>&gt;
    <span class="text-blue-400">&#64;endif</span>
    
    &lt;<span class="text-pink-400">ul</span>&gt;
    <span class="text-blue-400">&#64;foreach</span>(<span class="text-yellow-300">$items</span> <span class="text-blue-400">as</span> <span class="text-yellow-300">$item</span>)
        &lt;<span class="text-pink-400">li</span>&gt;<span class="text-yellow-300">&#123;&#123; $item &#125;&#125;</span>&lt;/<span class="text-pink-400">li</span>&gt;
    <span class="text-blue-400">&#64;endforeach</span>
    &lt;/<span class="text-pink-400">ul</span>&gt;
<span class="text-blue-400">&#64;endsection</span></code></pre>
            </section>

            <!-- Models & Migrations -->
            <section id="models" class="mb-10 scroll-mt-20">
                <h2 class="text-xl font-bold text-gray-100 mb-3 flex items-center gap-2">🪄 Models & Migrations</h2>
                <p class="text-gray-400 text-sm mb-3">Define schemas in <code class="bg-gray-800 text-pink-400 px-1 py-0.5 rounded font-mono text-xs">database/models.php</code>. Run <code class="bg-blue-900/50 text-blue-300 px-1.5 py-0.5 rounded font-mono text-xs border border-blue-800">php kite migrate</code> to sync.</p>
<pre class="bg-[#0d1117] border border-gray-800 rounded-lg p-4 text-xs font-mono overflow-x-auto text-gray-300 leading-normal mb-4"><code><span class="text-blue-400">class</span> <span class="text-yellow-300">Product</span> <span class="text-blue-400">extends</span> Model {
    <span class="text-blue-400">public static function</span> <span class="text-purple-400">schema</span>(): <span class="text-blue-400">array</span> {
        <span class="text-blue-400">return</span> [
            <span class="text-green-400">'id'</span>    =&gt; Field::<span class="text-purple-400">id</span>(),
            <span class="text-green-400">'name'</span>  =&gt; Field::<span class="text-purple-400">string</span>()-&gt;<span class="text-purple-400">nullable</span>(),
            <span class="text-green-400">'slug'</span>  =&gt; Field::<span class="text-purple-400">string</span>()-&gt;<span class="text-purple-400">unique</span>(),
            <span class="text-green-400">'price'</span> =&gt; Field::<span class="text-purple-400">integer</span>()-&gt;<span class="text-purple-400">default</span>(<span class="text-green-400">'0'</span>),
        ];
    }
}</code></pre>
            </section>

            <!-- Query Builder -->
            <section id="querybuilder" class="mb-10 scroll-mt-20">
                <h2 class="text-xl font-bold text-gray-100 mb-3 flex items-center gap-2">🔍 Query Builder</h2>
<pre class="bg-[#0d1117] border border-gray-800 rounded-lg p-4 text-xs font-mono overflow-x-auto text-gray-300 leading-normal mb-4"><code><span class="text-yellow-300">$users</span> = <span class="text-purple-400">db</span>()-&gt;<span class="text-purple-400">table</span>(<span class="text-green-400">'users'</span>)-&gt;<span class="text-purple-400">where</span>(<span class="text-green-400">'status'</span>, <span class="text-green-400">'active'</span>)-&gt;<span class="text-purple-400">get</span>();
<span class="text-yellow-300">$user</span> = <span class="text-purple-400">db</span>()-&gt;<span class="text-purple-400">table</span>(<span class="text-green-400">'users'</span>)-&gt;<span class="text-purple-400">find</span>(<span class="text-purple-400">1</span>);

<span class="text-purple-400">db</span>()-&gt;<span class="text-purple-400">table</span>(<span class="text-green-400">'users'</span>)-&gt;<span class="text-purple-400">insert</span>([<span class="text-green-400">'name'</span> =&gt; <span class="text-green-400">'John'</span>]);
<span class="text-purple-400">db</span>()-&gt;<span class="text-purple-400">table</span>(<span class="text-green-400">'users'</span>)-&gt;<span class="text-purple-400">where</span>(<span class="text-green-400">'id'</span>, <span class="text-purple-400">1</span>)-&gt;<span class="text-purple-400">update</span>([<span class="text-green-400">'name'</span> =&gt; <span class="text-green-400">'Jane'</span>]);
<span class="text-purple-400">db</span>()-&gt;<span class="text-purple-400">table</span>(<span class="text-green-400">'users'</span>)-&gt;<span class="text-purple-400">where</span>(<span class="text-green-400">'id'</span>, <span class="text-purple-400">1</span>)-&gt;<span class="text-purple-400">delete</span>();</code></pre>
            </section>

            <!-- KiteJS -->
            <section id="kitejs" class="mb-10 scroll-mt-20">
                <h2 class="text-xl font-bold text-gray-100 mb-3 flex items-center gap-2">⚡ SPA Engine (KiteJS)</h2>
                <p class="text-gray-400 text-sm mb-3">Fetches HTML via AJAX and updates DOM without reload.</p>
<pre class="bg-[#0d1117] border border-gray-800 rounded-lg p-4 text-xs font-mono overflow-x-auto text-gray-300 leading-normal mb-4"><code><span class="text-gray-500">&lt;!-- Instant Navigation --&gt;</span>
&lt;<span class="text-pink-400">a</span> <span class="text-blue-300">href</span>=<span class="text-green-400">"/about"</span> <span class="text-blue-300">kite:navigate</span>=<span class="text-green-400">"about"</span>&gt;About Us&lt;/<span class="text-pink-400">a</span>&gt;

<span class="text-gray-500">&lt;!-- AJAX Form Submission --&gt;</span>
&lt;<span class="text-pink-400">form</span> <span class="text-blue-300">action</span>=<span class="text-green-400">"/login"</span> <span class="text-blue-300">method</span>=<span class="text-green-400">"POST"</span> <span class="text-blue-300">kite:submit</span>=<span class="text-green-400">"login"</span>&gt;
    <span class="text-blue-400">&#64;csrf</span>
    &lt;<span class="text-pink-400">input</span> <span class="text-blue-300">type</span>=<span class="text-green-400">"email"</span> <span class="text-blue-300">name</span>=<span class="text-green-400">"email"</span>&gt;
    &lt;<span class="text-pink-400">button</span> <span class="text-blue-300">type</span>=<span class="text-green-400">"submit"</span>&gt;Login&lt;/<span class="text-pink-400">button</span>&gt;
&lt;/<span class="text-pink-400">form</span>&gt;</code></pre>
            </section>

            <!-- Helpers -->
            <section id="helpers" class="mb-10 scroll-mt-20">
                <h2 class="text-xl font-bold text-gray-100 mb-3 flex items-center gap-2">🛠️ Helper Functions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="bg-[#161b22] border border-gray-800 p-3 rounded-lg flex items-center gap-3">
                        <code class="text-pink-400 font-bold text-xs bg-gray-900 px-2 py-1 rounded">view()</code>
                        <p class="text-xs text-gray-400">Renders a template</p>
                    </div>
                    <div class="bg-[#161b22] border border-gray-800 p-3 rounded-lg flex items-center gap-3">
                        <code class="text-pink-400 font-bold text-xs bg-gray-900 px-2 py-1 rounded">route()</code>
                        <p class="text-xs text-gray-400">Gets named URL</p>
                    </div>
                    <div class="bg-[#161b22] border border-gray-800 p-3 rounded-lg flex items-center gap-3">
                        <code class="text-pink-400 font-bold text-xs bg-gray-900 px-2 py-1 rounded">redirect()</code>
                        <p class="text-xs text-gray-400">Redirect user</p>
                    </div>
                    <div class="bg-[#161b22] border border-gray-800 p-3 rounded-lg flex items-center gap-3">
                        <code class="text-pink-400 font-bold text-xs bg-gray-900 px-2 py-1 rounded">db()</code>
                        <p class="text-xs text-gray-400">Query builder</p>
                    </div>
                    <div class="bg-[#161b22] border border-gray-800 p-3 rounded-lg flex items-center gap-3">
                        <code class="text-pink-400 font-bold text-xs bg-gray-900 px-2 py-1 rounded">session()</code>
                        <p class="text-xs text-gray-400">Session manager</p>
                    </div>
                    <div class="bg-[#161b22] border border-gray-800 p-3 rounded-lg flex items-center gap-3">
                        <code class="text-pink-400 font-bold text-xs bg-gray-900 px-2 py-1 rounded">abort(404)</code>
                        <p class="text-xs text-gray-400">Throw HTTP error</p>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
                if (window.innerWidth < 768) {
                    document.getElementById('sidebar').classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>