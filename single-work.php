<?php

/**
 * Single Work（制作実績詳細ページ）
 */
get_header();
?>
<!-- mainvisual -->
<div class="mainvisual">
    <div class="inner">
        <div class="mainvisual-content">
            <div class="mainvisual-title">制作実績</div><!-- /.mainvisual-title -->
        </div><!-- mainvisual-content -->
    </div><!-- inner -->
</div><!-- mainvisual -->

<?php if (function_exists('bcn_display')) : ?>
    <div class="work-breadcrumb">
        <div class="inner">
            <div class="breadcrumb">
                <?php bcn_display(); ?>
            </div><!-- breadcrumb -->
        </div>
        <!--inner -->
    </div><!-- work-breadcrumb -->
<?php endif; ?>

<!-- content -->
<div class="content-work" id="content">
    <div class="inner">
        <!-- primary -->
        <main id="primary">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <!-- entry -->
                    <article <?php post_class(array('entry', 'entry-work')); ?>>
                        <!-- entry-header -->
                        <div class="entry-header">
                            <div class="entry-label"><a href="<?php echo esc_url(get_term_link(get_the_terms(get_the_ID(), 'genre')[0])) ?>"><?php echo esc_html(get_the_terms(get_the_ID(), 'genre')[0]->name); ?></a></div> <!-- /entry-item-tag -->
                            <h1 class="entry-title"><?php the_title(); ?></h1><!-- /entry-title -->
                            <!-- entry-img -->
                            <div class="entry-img">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('full');
                                }
                                ?>
                            </div><!-- /entry-img -->
                        </div><!-- /entry-header -->
                        <div class="entry-work-body">
                            <div class="entry-work-content"><?php echo nl2br(esc_html(get_field('overview'))); ?></div><!-- /.entry-work-content -->
                            <div class="entry-work-table">
                                <table>
                                    <?php if (get_field('company')) : ?>
                                        <tr>
                                            <th>会社名</th>
                                            <td><?php the_field('company'); ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if (get_field('url')) : ?>
                                        <tr>
                                            <th>サイトURL</th>
                                            <td><?php the_field('url'); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if (get_field('position')) : ?>
                                        <tr>
                                            <th>担当範囲</th>
                                            <td><?php the_field('position'); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </table>
                            </div><!-- /.entry-work-table -->
                        </div>
                        <div class="entry-work-btn">
                            <a class="btn" href=" <?php echo esc_url(get_post_type_archive_link('work')) ?> ">一覧に戻る</a>
                        </div>
                        <?php
                        $term_var = get_the_terms($post->ID, 'genre');
                        $related_query = new WP_Query(
                            array(
                                'post_type' => 'work',
                                'posts_per_page' => '3',
                                'post__not_in' => array($post->ID),
                                'tax_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' => 'genre',
                                        'field' => 'slug',
                                        'terms' => $term_var[0]->slug,
                                    )
                                )
                            )
                        ); ?>
                        <?php if ($related_query->have_posts()) : ?>
                            <div class="entry-work-related">
                                <div class="entry-work-related-head">関連記事</div><!-- /.entry-work-related-head -->
                                <div class="entries entries-work entry-work-related-entries">
                                    <?php while ($related_query->have_posts()) : ?>
                                        <?php $related_query->the_post(); ?>
                                        <!-- entry-item -->
                                        <a href="<?php the_permalink(); ?>" <?php post_class(array('entry-item', 'entry-item-horizontal')); ?>>
                                            <!-- entry-item-img -->
                                            <div class="entry-item-img">
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail('my_thumbnail');
                                                } else {
                                                    echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/noimg.png" alt="">';
                                                }
                                                ?>
                                            </div><!-- /entry-item-img -->
                                            <!-- entry-item-body -->
                                            <div class="entry-item-body">
                                                <div class="entry-item-meta">
                                                    <div class="entry-item-tag"><?php echo esc_html(get_the_terms(get_the_ID(), 'genre')[0]->name); ?></div><!-- /entry-item-tag -->
                                                </div><!-- entry-item-meta -->
                                                <h2 class="entry-item-title"><?php the_title(); ?></h2><!-- /entry-item-title -->
                                            </div><!-- /entry-item-body -->
                                        </a><!-- /entry-item -->
                                    <?php endwhile; ?>
                                </div><!-- /entry-work-related-entries -->
                            </div><!-- entry-work-related -->
                        <?php endif; ?>
                        <?php wp_reset_postdata(); ?>
                    </article>
                    <!-- /entry -->
            <?php endwhile; endif; ?>
        </main><!-- /primary -->
    </div><!-- /inner -->
</div><!-- /content -->


<?php get_footer(); ?>