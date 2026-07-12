<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error: <?= htmlspecialchars($class) ?></title>
</head>
<body>
    <style>
        body { margin: 0 !important; padding: 0 !important; background-color: #f3f4f6 !important; }
        .kite-error-page { font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: #f3f4f6; color: #1f2937; min-height: 100vh; margin: 0; padding-bottom: 3rem; box-sizing: border-box; }
        .kite-error-page * { box-sizing: inherit; }
        .kite-error-header { background-color: #ef4444; color: white; padding: 2.5rem 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); margin: 0; }
        .kite-error-header h1 { margin: 0 0 0.5rem 0; font-size: 1.75rem; font-weight: 600; opacity: 0.9; line-height: 1.2; }
        .kite-error-header h2 { margin: 0; font-size: 1.25rem; font-weight: 400; line-height: 1.5; word-break: break-word; }
        .kite-error-container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; background: transparent; box-shadow: none; border-radius: 0; }
        .kite-error-card { background: white; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; margin-top: -2rem; margin-bottom: 2rem; position: relative; z-index: 10; padding: 0; }
        .kite-error-card-header { background: #f9fafb; padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #374151; display: flex; justify-content: space-between; align-items: center; font-size: 0.875rem; margin: 0; }
        .kite-error-card-body { padding: 1.5rem; overflow-x: auto; background: #1e1e1e; margin: 0; }
        .kite-error-snippet { background: transparent; color: #d4d4d4; padding: 1rem 0; border-radius: 0.375rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; font-size: 0.875rem; line-height: 1.6; overflow-x: auto; margin: 0; }
        .kite-error-line { display: flex; padding: 0 1rem; margin: 0; }
        .kite-error-line-number { color: #6b7280; user-select: none; padding-right: 1rem; text-align: right; min-width: 3.5rem; border-right: 1px solid #374151; margin-right: 1rem; display: block; }
        .kite-error-line-content { white-space: pre; color: #e5e7eb; margin: 0; display: block; }
        .kite-error-highlight { background-color: rgba(239, 68, 68, 0.2); border-left: 3px solid #ef4444; padding-left: calc(1rem - 3px); }
        .kite-error-highlight .kite-error-line-number { color: #fca5a5; border-color: #ef4444; }
        .kite-error-highlight .kite-error-line-content { color: #fca5a5; font-weight: bold; }
        .kite-error-trace { font-family: ui-monospace, monospace; font-size: 0.875rem; background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); margin-bottom: 3rem; padding: 0; }
        .kite-error-trace-item { padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; flex-direction: column; margin: 0; }
        .kite-error-trace-item:last-child { border-bottom: none; }
        .kite-error-trace-file { color: #4b5563; word-break: break-all; margin: 0; }
        .kite-error-trace-call { color: #2563eb; font-weight: 500; margin-top: 0.375rem; font-size: 0.95rem; margin-bottom: 0; }
        .kite-error-badge { background: #e5e7eb; padding: 0.2rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; color: #374151; margin: 0; }
    </style>
    <div class="kite-error-page">
        <div class="kite-error-header">
        <div class="kite-error-container">
            <h1><?= htmlspecialchars($class) ?></h1>
            <h2><?= htmlspecialchars($message) ?></h2>
        </div>
    </div>

    <div class="kite-error-container">
        <div class="kite-error-card">
            <div class="kite-error-card-header">
                <span style="font-family: monospace; font-size: 1rem;"><?= htmlspecialchars($file) ?></span>
                <span class="kite-error-badge">Line <?= $line ?></span>
            </div>
            <div class="kite-error-card-body">
                <div class="kite-error-snippet">
                    <?php foreach ($codeSnippet as $num => $codeLine): ?>
                        <div class="kite-error-line <?= $num === $line ? 'kite-error-highlight' : '' ?>">
                            <div class="kite-error-line-number"><?= $num ?></div>
                            <div class="kite-error-line-content"><?= htmlspecialchars($codeLine) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #374151; font-weight: 600; font-size: 1.125rem;">Stack Trace</h3>
        <div class="kite-error-trace">
            <?php foreach ($traceArray as $index => $t): ?>
                <div class="kite-error-trace-item">
                    <div class="kite-error-trace-call">
                        <?= isset($t['class']) ? htmlspecialchars($t['class'] . $t['type']) : '' ?><?= htmlspecialchars($t['function']) ?>()
                    </div>
                    <div class="kite-error-trace-file">
                        <?= isset($t['file']) ? htmlspecialchars($t['file']) : '[internal function]' ?>
                        <?= isset($t['line']) ? ' &mdash; line <strong style="color: #111827;">' . $t['line'] . '</strong>' : '' ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
</body>
</html>
