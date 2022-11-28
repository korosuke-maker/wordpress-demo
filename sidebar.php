<!-- secondary -->
<aside id="secondary">
    <!-- widget_custom_html -->
    <div class="widget widget_text widget_custom_html">
        <div class="widget-title">プロフィール</div>

        <div class="wprofile">
            <div class="wprofile-img"><img src="<?php echo get_template_directory_uri(); ?>/img/profile.png" alt=""></div>
            <div class="wprofile-content">
                <p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</p>
            </div>
            <!-- /wprofile-content -->
            <nav class="wprofile-sns">
                <div class="wprofile-sns-item m_twitter"><a href="" rel="noopener noreferrer" target="_blank"><i class="fab fa-twitter"></i></a></div>
                <div class="wprofile-sns-item m_facebook"><a href="" rel="noopener noreferrer" target="_blank"><i class="fab fa-facebook-f"></i></a></div>
                <div class="wprofile-sns-item m_instagram"><a href="" rel="noopener noreferrer" target="_blank"><i class="fab fa-instagram"></i></a></div>
            </nav>
        </div><!-- /wprofile -->
    </div><!-- /widget_custom_html -->

    <!-- widget_search -->
    <div class="widget widget_search">
        <div class="widget-title">検索</div>
        <!-- search-form -->
        <?php get_search_form(); ?>
    </div><!-- /widget_search -->

    <!-- widget_popular -->
    <div class="widget widget_popular">
        <div class="widget-title">人気記事</div>
        <div class="wpost-items m_ranking">
            <?php
            // get_post_viewsで適宜アクセス数を確認
            
            
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 5,
                'meta_key' => 'view_counter',
                'orderby' => 'meta_value_num',
                'order' => 'DESC', //orderbyで指定したものを降順で指定
            );
            $popular_posts = get_posts($args);
            foreach ($popular_posts as $post) : setup_postdata($post);
            ?>
                <!-- wpost-item -->
                <a class="wpost-item" href="<?php the_permalink(); ?>">
                    <div class="wpost-item-img">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } else {
                            echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/noimg.png" alt="">';
                        }
                        ?>
                    </div>
                    <div class="wpost-item-body">
                        <div class="wpost-item-title"><?php the_title(); ?></div>
                        <?php $counter = get_post_views();
                        echo '閲覧:'.$counter.'回';
                        ?>
                    </div><!-- /wpost-item-body -->
                </a><!-- /wpost-item -->
            <?php endforeach;
            wp_reset_postdata(); ?>
        </div><!-- /wpost-items -->
    </div><!-- /widget_popular -->

    <!-- widget_recent -->
    <div class="widget widget_recent">
        <div class="widget-title">新着記事</div>
        <div class="wpost-items">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => '5',
                'orderby' => 'date',
                'order' => 'DESC',
            );
            $new_posts = get_posts($args);
            foreach ($new_posts as $post) : setup_postdata($post);
            ?>
                <!-- wpost-item -->
                <a class="wpost-item" href="<?php the_permalink(); ?>">
                    <div class="wpost-item-img">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('medium');
                        } else {
                            echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/noimg.png" alt="">';
                        }
                        ?>
                    </div>
                    <div class="wpost-item-body">
                        <div class="wpost-item-title"><?php the_title(); ?></div>
                    </div><!-- /wpost-item-body -->
                </a><!-- /wpost-item -->
            <?php endforeach;
            wp_reset_postdata(); ?>
        </div><!-- /wpost-items -->
    </div><!-- /widget_recent -->
<!-- widget_archive -->
    <div class="widget widget_archive">
        <div class="widget-title">アーカイブ</div>
        <ul>
            <?php 
            $args = array(
                'type'=>'monthly',
                'limit'=>'',
                'format'=>'html',
                'before'=>'',
                'after'=>'',
                'show_post_count'=>false,
                'echo'=>1,
                'order'=>'DESC',
                'post_type'=>'post',
            );
            wp_get_archives($args);
            ?>
        </ul>
    </div>
<!-- /widget_archive -->


</aside><!-- secondary -->