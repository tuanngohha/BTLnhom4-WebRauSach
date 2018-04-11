<?php
/**
 * Template Name: Page with Left Sidebar
 *
 */
?>
<?php get_header(); ?>
<div class="col-md-8 layoutleftsidebar" >
	<?php
	while( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

	endwhile;
	?>
</div>
<?php get_sidebar( 'page' ); ?>
<?php get_footer(); ?>
