<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error: <?= htmlspecialchars($class) ?></title>
    <style>
        body { font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: #f3f4f6; margin: 0; color: #1f2937; }
        .header { background-color: #ef4444; color: white; padding: 2.5rem 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header h1 { margin: 0 0 0.5rem 0; font-size: 1.75rem; font-weight: 600; opacity: 0.9; }
        .header h2 { margin: 0; font-size: 1.25rem; font-weight: 400; line-height: 1.5; word-break: break-word; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; }
        .card { background: white; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); overflow: hidden; margin-top: -2rem; margin-bottom: 2rem; position: relative; z-index: 10; }
        .card-header { background: #f9fafb; padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #374151; display: flex; justify-content: space-between; align-items: center; font-size: 0.875rem; }
        .card-body { padding: 1.5rem; overflow-x: auto; }
        .code-snippet { background: #1e1e1e; color: #d4d4d4; padding: 1rem 0; border-radius: 0.375rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; font-size: 0.875rem; line-height: 1.6; overflow-x: auto; }
        .code-line { display: flex; padding: 0 1rem; }
        .code-line-number { color: #6b7280; user-select: none; padding-right: 1rem; text-align: right; min-width: 2.5rem; border-right: 1px solid #374151; margin-right: 1rem; }
        .code-line-content { white-space: pre; }
        .highlight { background-color: rgba(239, 68, 68, 0.2); border-left: 3px solid #ef4444; padding-left: calc(1rem - 3px); }
        .highlight .code-line-number { color: #fca5a5; border-color: #ef4444; }
        .highlight .code-line-content { color: #fca5a5; font-weight: bold; }
        .trace { font-family: ui-monospace, monospace; font-size: 0.875rem; background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); margin-bottom: 3rem; }
        .trace-item { padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; flex-direction: column; }
        .trace-item:last-child { border-bottom: none; }
        .trace-file { color: #4b5563; word-break: break-all; }
        .trace-call { color: #2563eb; font-weight: 500; margin-top: 0.375rem; font-size: 0.95rem; }
        .badge { background: #e5e7eb; padding: 0.2rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; color: #374151; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1><?= htmlspecialchars($class) ?></h1>
            <h2><?= htmlspecialchars($message) ?></h2>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <span style="font-family: monospace; font-size: 1rem;"><?= htmlspecialchars($file) ?></span>
                <span class="badge">Line <?= $line ?></span>
            </div>
            <div class="card-body" style="padding: 0; background: #1e1e1e;">
                <div class="code-snippet">
                    <?php foreach ($codeSnippet as $num => $codeLine): ?>
                        <div class="code-line <?= $num === $line ? 'highlight' : '' ?>">
                            <div class="code-line-number"><?= $num ?></div>
                            <div class="code-line-content"><?= htmlspecialchars($codeLine) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #374151; font-weight: 600; font-size: 1.125rem;">Stack Trace</h3>
        <div class="trace">
            <?php foreach ($traceArray as $index => $t): ?>
                <div class="trace-item">
                    <div class="trace-call">
                        <?= isset($t['class']) ? htmlspecialchars($t['class'] . $t['type']) : '' ?><?= htmlspecialchars($t['function']) ?>()
                    </div>
                    <div class="trace-file">
                        <?= isset($t['file']) ? htmlspecialchars($t['file']) : '[internal function]' ?>
                        <?= isset($t['line']) ? ' &mdash; line <strong style="color: #111827;">' . $t['line'] . '</strong>' : '' ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
