<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Smart Cleaning
 */

if (!function_exists('smart_cleaning_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function smart_cleaning_posted_on(){
        $smart_cleaning_time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $smart_cleaning_time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        }

        $smart_cleaning_time_string = sprintf($smart_cleaning_time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date */
            __( '<span class="screen-reader-text">Posted on</span> %s', 'smart-cleaning' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $smart_cleaning_time_string . '</a>'
        );
        
        $byline = sprintf(
            /* translators: %s: post author */
            __( '<span class="screen-reader-text">Posted on</span> %s', 'smart-cleaning' ),
            '<span class="author vcard"><i class="far fa-user" aria-hidden="true"></i> <a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span> | <span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo ' | <span class="comments-link"><i class="far fa-comments" aria-hidden="true"></i> ';
            /* translators: %s: post title */
            comments_popup_link(sprintf(wp_kses(__('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'smart-cleaning'), array('span' => array('class' => array()))), esc_html( get_the_title())));
            echo '</span>';
        }
    }
endif;

if (!function_exists('smart_cleaning_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function smart_cleaning_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $smart_cleaning_categories_list = get_the_category_list(esc_html__(', ', 'smart-cleaning'));
            if ($smart_cleaning_categories_list && smart_cleaning_categorized_blog()) {
                /* translators: 1: number of Post */  printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'smart-cleaning') . '</span>', $smart_cleaning_categories_list );
            }

            /* translators: used between list items, there is a space after the comma */
            $smart_cleaning_tags_list = get_the_tag_list('', esc_html__(', ', 'smart-cleaning'));
            if ($smart_cleaning_tags_list) {
                /* translators: %s: Tagged */
               printf(' | <span class="tags-links">' . esc_html__('Tagged %1$s', 'smart-cleaning') . '</span>', $smart_cleaning_tags_list); // WPCS: XSS OK.
            }
        }

        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                esc_html__('Edit %s', 'smart-cleaning'),
                the_title('<span class="screen-reader-text">"', '"</span>', false)
            ),
            ' | <span class="edit-link">',
            '</span>'
        );
    }
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function smart_cleaning_categorized_blog(){
    if (false === ($smart_cleaning_all_the_cool_cats = get_transient('smart_cleaning_categories'))) {
        // Create an array of all the categories that are attached to posts.
        $smart_cleaning_all_the_cool_cats = get_categories(array(
            'fields' => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number' => 2,
        ));

        // Count the number of categories that are attached to the posts.
        $smart_cleaning_all_the_cool_cats = count($smart_cleaning_all_the_cool_cats);

        set_transient('smart_cleaning_categories', $smart_cleaning_all_the_cool_cats);
    }

    if ($smart_cleaning_all_the_cool_cats > 1) {
        // This blog has more than 1 category so smart_cleaning_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so smart_cleaning_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in smart_cleaning_categorized_blog.
 */
function smart_cleaning_category_transient_flusher(){
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('smart_cleaning_categories');
}
add_action('edit_category', 'smart_cleaning_category_transient_flusher');
add_action('save_post', 'smart_cleaning_category_transient_flusher');


if (!function_exists('smart_cleaning_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function smart_cleaning_post_thumbnail(){
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>

        <?php else : ?>

            <div class="post-thumbnail">
                <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                    <?php
                        the_post_thumbnail('post-thumbnail', array(
                            'alt' => the_title_attribute(array(
                                'echo' => false,
                            )),
                        ));
                    ?>
                </a>
            </div>

            <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('smart_cleaning_comment')) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function smart_cleaning_comment($comment, $smart_cleaning_args, $depth){

        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media'); ?>>
            <div class="comment-body">
                <?php esc_html_e('Pingback:', 'smart-cleaning'); 
                comment_author_link(); ?><?php edit_comment_link(__('Edit', 'smart-cleaning'), '<span class="edit-link">', '</span>'); ?>
            </div>

        <?php else : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($smart_cleaning_args['has_children']) ? '' : 'parent'); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
                <a class="pull-left" href="#">
                    <?php if (0 != $smart_cleaning_args['avatar_size']) echo get_avatar($comment, $smart_cleaning_args['avatar_size']); ?>
                </a>
                <div class="media-body">
                    <div class="media-body-wrap card">
                        <div class="card-header">
                            <h5 class="mt-0"><?php /* translators: %s: author */ printf('<cite class="fn">%s</cite>', get_comment_author_link() ); ?></h5>
                            <div class="comment-meta">
                                <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                    <time datetime="<?php comment_time('c'); ?>">
                                        <?php /* translators: %s: Date */ printf( esc_attr('%1$s at %2$s', '1: date, 2: time', 'smart-cleaning'), esc_attr( get_comment_date() ), esc_attr( get_comment_time() ) ); ?>
                                    </time>
                                </a>
                                <?php edit_comment_link( __( 'Edit', 'smart-cleaning' ), '<span class="edit-link">', '</span>' ); ?>
                            </div>
                        </div>

                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'smart-cleaning'); ?></p>
                        <?php endif; ?>

                        <div class="comment-content card-block">
                            <?php comment_text(); ?>
                        </div>

                        <?php comment_reply_link(
                            array_merge(
                                $smart_cleaning_args, array(
                                    'add_below' => 'div-comment',
                                    'depth' => $depth,
                                    'max_depth' => $smart_cleaning_args['max_depth'],
                                    'before' => '<footer class="reply comment-reply card-footer">',
                                    'after' => '</footer><!-- .reply -->'
                                )
                            )
                        ); ?>
                    </div>
                </div>
            </article>

            <?php
        endif;
    }
endif; // ends check for smart_cleaning_comment()