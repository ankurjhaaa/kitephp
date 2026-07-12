<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo seo(['title' => $title ?? 'KitePHP App']); ?>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; margin: 0; padding: 2rem; background: #f9fafb; color: #111827; transition: opacity 0.2s; }
        nav { margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb; }
        nav a { margin-right: 1rem; color: #2563eb; text-decoration: none; font-weight: 500; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .alert { padding: 1rem; background: #dcfce7; color: #166534; border-radius: 4px; margin-bottom: 1rem; }
        form { display: flex; flex-direction: column; gap: 1rem; max-width: 400px; }
        input { padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; }
        button { padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { background: #1d4ed8; }
    </style>
    <script src="<?php echo asset('kite.js'); ?>"></script>
</head>
<body>
    <div class="container">
        <nav>
            <a href="<?php echo route('home'); ?>" kite:navigate="home">Home</a>
            <a href="<?php echo route('about'); ?>" kite:navigate="about">About</a>
        </nav>

        <?php if ($msg = session('_flash')['message'] ?? null): ?>
            <div class="alert"><?php echo e($msg); ?></div>
            <?php session()->put('_flash', []); // Clear flash ?>
        <?php endif; ?>

        <main>
            <?php \Kite\Core\View::yieldSection('content'); ?>
        </main>
    </div>
</body>
</html>
