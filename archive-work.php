<?php

/**
 * Archive Work（制作実績一覧ページ）
 */
get_header(); ?>

<!-- mainvisual -->
<div class="mainvisual">
    <div class="inner">
        <div class="mainvisual-content">
            <div class="mainvisual-title">制作実績</div><!-- /.mainvisual-title -->
        </div><!-- /.mainvisual-content -->
    </div><!-- /.inner -->
</div><!-- /.mainvisual -->

<?php if (function_exists('bcn_display')) : ?>
    <div class="work-breadcrumb">
        <div class="inner">
            <div class="breadcrumb">
                <?php bcn_display(); ?>
            </div><!-- /.breadcrumb -->
        </div><!-- /.inner -->
    </div><!-- /.work-breadcrumb -->
<?php endif; ?>

<!-- ここにコンテンツが入ります。 -->
<div id="content" class="content-work">
    <div class="inner">
        <!-- primary -->
        <main id="primary">
            <div class="genre-nav">
                <div class="genre-nav-link"><a class="is-active" href=" <?php echo esc_url(get_post_type_archive_link('work')) ?> ">すべて</a></div><!-- /.genre-nav-link -->
                <?php $genre_terms = get_terms('genre', array('hide_empty', false));
                foreach ($genre_terms as $genre_term) : ?>
                    <div class="genre-nav-link"><a href="<?php echo esc_url( get_term_link( $genre_term, 'genre' ) ); ?>"><?php echo esc_html( $genre_term->name ); ?></a></div><!-- /.genre-nav-link -->
                <?php endforeach; ?>
            </div><!-- .genre-nav -->
            <?php if (have_posts()) : ?>
                <!-- entries -->
                <div class="entries entries-work">
                    <?php while (have_posts()) : the_post(); ?>
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
                            </div>
                            <!-- entry-item-body -->
                            <div class="entry-item-body">
                                <div class="entry-item-meta">
                                    <div class="entry-item-tag"><?php echo esc_html(get_the_terms(get_the_ID(), 'genre')[0]->name); ?></div><!-- /entry-item-tag -->
                                </div>
                                <div class="entry-item-excerpt"><?php echo esc_html(mb_substr(get_field('overview'),0,40,"UTF-8")).'....';?></div><!-- /.entry-item-excerpt -->
                            </div>
                            <!-- entry-item-body -->
                        </a><!-- entry-item -->
                    <?php endwhile; ?>
                </div><!-- /entries -->
                <?php if (paginate_links()) : ?>
                    <!-- pagenation -->
                    <div class="pagenation">
                        <?php
                        echo wp_kses_post(
                            paginate_links(
                                array(
                                    'end_size' => 0,
                                    'mid_size' => 1,
                                    'prev_next' => true,
                                    'prev_text' => '<i class="fas fa-angle-left"></i>',
                                    'next_text' => '<i class="fas fa-angle-right"></i>',
                                )
                            )
                        );
                        ?>
                    </div><!-- /pagenation -->
                <?php endif; ?>
            <?php endif; ?>
        </main><!-- /primary -->
    </div><!-- /.inner -->
</div><!-- /content -->

<?php get_footer(); ?>