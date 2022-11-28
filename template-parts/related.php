<?php if (has_category()) {
    $post_cats = get_the_category();
    $cat_ids = array();
    foreach ($post_cats as $cat) {
        $cat_ids[] = $cat->term_id;
    }
}
$myposts = get_posts(array(
    'post_type' => 'post',
    'posts_per_page' => '8',
    'post__not_in' => array($post->ID),
    'category__in' => $cat_ids,
    'orderby' => 'rand',
));
if ($myposts) :
?>
    <div class="related-items">
        <?php foreach ($myposts as $post) : setup_postdata($post); ?>
            <a class="related-item" href=" <?php the_permalink(); ?> ">
                <div class="related-item-img">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('medium');
                    } else {
                        echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/noimg.png" alt="">';
                    }
                    ?>
                </div><!-- /related-item-img -->
                <div class="related-item-title"><?php the_title(); ?></div><!-- /related-item-title -->
            </a><!-- /related-item -->
        <?php endforeach;
        wp_reset_postdata(); ?>
    </div><!-- /related-items -->
<?php endif; ?>