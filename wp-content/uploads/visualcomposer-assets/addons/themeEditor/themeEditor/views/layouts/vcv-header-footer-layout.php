<?php

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="vcv-layout-wrapper">
    <?php if (apply_filters('vcv:themeEditor:header:enabled', true)) : ?>
        <header class="vcv-header" data-vcv-layout-zone="header">
            <?php do_action('vcv:themeEditor:header'); ?>
        </header>
    <?php endif; ?>
    <section class="vcv-content">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php
        endwhile;
        ?>
    </section>
    <?php if (apply_filters('vcv:themeEditor:footer:enabled', true)) : ?>
        <footer class="vcv-footer" data-vcv-layout-zone="footer">
            <?php do_action('vcv:themeEditor:footer'); ?>
        </footer>
    <?php endif; ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
