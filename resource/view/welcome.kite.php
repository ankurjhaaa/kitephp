<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KitePHP' }}</title>
    
    <!-- Load KiteJS SPA Engine -->
    <script src="{{ asset('kite.js') }}"></script>
    
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; margin: 0; padding: 2rem; background: #f9fafb; color: #111827; }
        .container { max-width: 1000px; margin: 0 auto; }
        
        /* Documentation Page Specific Styles */
        .docs-hero { text-align: center; padding: 4rem 1rem; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; border-radius: 8px; margin-bottom: 3rem; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.5); }
        .docs-hero h1 { font-size: 3rem; margin: 0 0 1rem 0; font-weight: 800; letter-spacing: -0.05em; }
        .docs-hero p { font-size: 1.25rem; opacity: 0.9; margin: 0; max-width: 600px; margin: 0 auto; line-height: 1.6; }
        
        .docs-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem; }
        .docs-card { background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; transition: transform 0.2s, box-shadow 0.2s; }
        .docs-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border-color: #bfdbfe; }
        .docs-card h3 { color: #1e3a8a; font-size: 1.25rem; margin-top: 0; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; }
        .docs-card p { color: #4b5563; line-height: 1.6; margin: 0; }
        
        .docs-section { margin-bottom: 3rem; }
        .docs-section h2 { font-size: 1.875rem; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; margin-bottom: 1.5rem; color: #111827; }
        .code-block { background: #1e1e1e; color: #d4d4d4; padding: 1.25rem; border-radius: 8px; font-family: ui-monospace, monospace; font-size: 0.9rem; overflow-x: auto; margin: 1rem 0; box-shadow: inset 0 2px 4px rgba(0,0,0,0.2); }
        .code-block .keyword { color: #569cd6; }
        .code-block .string { color: #ce9178; }
        .code-block .comment { color: #6a9955; }
    </style>
</head>
<body>
    <div class="container">
        <div class="docs-hero">
            <h1>{{ $title }}</h1>
            <p>A fast, lightweight, and modern PHP framework equipped with SPA-like navigation and Django-style models.</p>
        </div>

        <div class="docs-section">
            <h2>🚀 Getting Started</h2>
            <p>Welcome to your new KitePHP application. KitePHP is designed to be simple yet incredibly powerful. Below are the key concepts you need to know to start building.</p>
            
            <div class="docs-grid">
                <div class="docs-card">
                    <h3>⚡ SPA Engine (KiteJS)</h3>
                    <p>Every link and form submission is automatically intercepted. Pages load instantly without full browser reloads, giving you a React-like experience with pure PHP.</p>
                </div>
                <div class="docs-card">
                    <h3>🗄️ Django-Style Models</h3>
                    <p>Define your schema directly in your PHP models. KitePHP's smart migrator will auto-detect changes and sync your database automatically.</p>
                </div>
                <div class="docs-card">
                    <h3>🎨 Blade-like Templates</h3>
                    <p>Use <code>@extends</code>, <code>@section</code>, and double curly braces for beautiful, clean, and secure view files.</p>
                </div>
            </div>
        </div>

        <div class="docs-section">
            <h2>🛣️ Routing & Controllers</h2>
            <p>Routes are defined in <code>route/url.php</code>. You can map URLs to Controller methods or Closures.</p>
            <div class="code-block">
        <span class="comment">// route/url.php</span>
        <span class="keyword">get</span>(<span class="string">'/'</span>, <span class="string">'HomeController@index'</span>)-&gt;name(<span class="string">'home'</span>);
            </div>
        </div>

        <div class="docs-section">
            <h2>🪄 Auto Migrations</h2>
            <p>To create a table, just define the schema in your Model. No migration files needed!</p>
            <div class="code-block">
        <span class="keyword">class</span> Product <span class="keyword">extends</span> Model {
            <span class="keyword">public static function</span> schema(): <span class="keyword">array</span> {
                <span class="keyword">return</span> [
                    <span class="string">'id'</span> =&gt; Field::id(),
                    <span class="string">'title'</span> =&gt; Field::string()-&gt;unique(),
                    <span class="string">'price'</span> =&gt; Field::integer()-&gt;default(<span class="string">'0'</span>),
                ];
            }
        }
            </div>
            <p>Then just run <code>php kite migrate</code> and the database will sync magically.</p>
        </div>

        <div class="docs-section">
            <h2>✨ Next Steps</h2>
            <p>Edit this documentation page in <code>resource/view/welcome.kite.php</code> to build out your own project's documentation!</p>
        </div>
    </div>
</body>
</html>
