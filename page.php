<?php get_header(); ?>
<!-- content -->
<div id="content" class="m_one">
<div class="inner">

<!-- primary -->
<main id="primary">
    <?php if(function_exists('bcn_display')): ?>
<!-- breadcrumb -->
<div class="breadcrumb">
	<?php bcn_display(); ?>
</div><!-- /breadcrumb -->
    <?php endif;?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<!-- entry -->
<article <?php post_class(array('entry')); ?>>

<!-- entry-header -->
<div class="entry-header">
	<h1 class="entry-title"><?php the_title(); ?></h1><!-- /entry-title -->
	<div class="entry-img">
        <img src="<?php echo get_template_directory_uri() ?>/img/entry10.png" alt="">
    </div><!-- /entry-img -->
</div><!-- /entry-header -->

<!-- entry-body -->
<div class="entry-body">
	<?php the_content();?>
    <?php 
    wp_link_pages(
        array(
            'before' => '<nav class="entry-links">',
            'after' => '</nav>',
            'link_before' => '',
            'link_after' => '',
            'next_or_number' => 'number',
            'separator' => '',
        )
    );
    ?>
</div><!-- /entry-body -->
</article><!-- /entry -->
</main><!-- /primary -->


<?php endwhile;endif;?>

</div><!-- /inner -->
</div><!-- /content -->

<?php get_footer();?>