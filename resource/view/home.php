<?php \Kite\Core\View::layout('layout'); ?>
<?php \Kite\Core\View::section('content'); ?>

<h1><?php echo e($title); ?></h1>
<p>KitePHP is a lightweight development kit with SPA-like powers.</p>

<h2>Test Form (AJAX submission)</h2>
<form action="<?php echo route('sbmit'); ?>" method="POST" kite:submit="submit">
    <?php echo csrf(); ?>
    <label for="name">Your Name</label>
    <input type="text" name="name" id="name" required>
    <button type="submit">Submit</button>
</form>

<?php \Kite\Core\View::endSection(); ?>
