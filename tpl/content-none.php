<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sakurairo
 */
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php _e( 'There is nothing here！', 'sakurairo' ); /*没有找到任何东西*/?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

            <p><?php printf(
                wp_kses(
                    __( 'Ready to post your first article? <a href="%1$s">Click here to start</a>.', 'sakurairo' ), /*准备好发布你的第一篇文章了么？ <a href="%1$s">点击这里开始</a>.*/
                    array( 'a' => array( 'href' => array() ) )
                ),
                esc_url( admin_url( 'post-new.php' ) )
            ); ?></p>

        <?php elseif ( is_search() ) : ?>
            <div class="sorry">
                <p><?php _e( 'Didn\'t find what you want, look at the other ones.', 'sakurairo' ); /*没有找到你想要的，看看其他的吧。*/?></p>
                <div class="sorry-inner">
                    <ul class="search-no-reasults">
                        <?php
                        global $wpdb;
                        // 修改查询以排除加密文章
                        $recent_posts_query = "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_status='publish' AND post_type='post' AND post_password = '' ORDER BY ID DESC LIMIT 0, 20";
                        $recent_posts = $wpdb->get_results($recent_posts_query);

                        if (!empty($recent_posts)) {
                            foreach ($recent_posts as $post) {
                                setup_postdata($post);
                                $postid = $post->ID;
                                $title = $post->post_title;
                                ?>
                                <li><a href="<?php echo get_permalink($postid); ?>" title="<?php echo esc_attr($title); ?>"><?php echo esc_html($title); ?></a> </li>
                                <?php
                            }
                            wp_reset_postdata();
                        }
                        ?>
                    </ul>
                </div>
            </div>

        <?php else : ?>

            <p><?php _e( 'We didn\'t seem to find what you want. Maybe you can search for it.', 'sakurairo' ); /*我们似乎没有找到你想要的东西. 或许你可以搜索一下试试.*/?></p>
            <?php get_search_form(); ?>

        <?php endif; ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->
