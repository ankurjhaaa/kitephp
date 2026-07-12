<?php \Kite\Core\View::layout('layout'); ?>
<?php \Kite\Core\View::section('content'); ?>

<h1><?php echo e($title); ?></h1>
<p>This page loaded via AJAX without a full reload using <code>kite:navigate</code>.</p>
<p>We are preserving the beautiful user experience of an SPA while delivering Server-Side Rendered HTML via PHP.</p>
<a href="<?php echo route('home'); ?>" kite:navigate="home">Go back Home</a>

<?php \Kite\Core\View::endSection(); ?>
