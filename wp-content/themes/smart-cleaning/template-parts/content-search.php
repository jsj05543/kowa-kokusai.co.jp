<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Smart Cleaning
 */
?>

<div class="col-lg-6 col-md-6 col-sm-6">
	<article id="post-<?php the_ID(); ?>" <?php post_class('article-box'); ?>>
		<header class="entry-header">
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		</header>

		<?php smart_cleaning_post_thumbnail(); ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>
		<footer class="entry-footer">
			<?php smart_cleaning_entry_footer(); ?>
		</footer>
	</article>
</div>