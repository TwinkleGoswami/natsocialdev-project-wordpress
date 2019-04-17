<?php
/**
 * The template for displaying Archive Recipe
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
$alone_sidebar_position = function_exists( 'fw_ext_sidebars_get_current_position' ) ? fw_ext_sidebars_get_current_position() : 'right';
$alone_general_recipes_options = alone_general_recipe_options(); // print_r($alone_general_recipes_options);
get_header();
alone_title_bar();

// print_r($alone_general_recipes_options);
?>
<section class="bt-main-row bt-section-space <?php alone_get_content_class('main', $alone_sidebar_position); ?>" role="main" itemprop="mainEntity" itemscope="itemscope" itemtype="http://schema.org/Blog">
	<div class="container">
		<div class="row">
			<div class="bt-content-area <?php alone_get_content_class( 'content', $alone_sidebar_position ); ?>">
				<div class="bt-col-inner">
					<?php // if( function_exists('fw_ext_breadcrumbs') && bearsthemes_check_is_bbpress() == '' ) fw_ext_breadcrumbs(); ?>
					<div class="post-recipe-list" data-bears-masonryhybrid='{"col": <?php echo esc_attr($alone_general_recipes_options['number_post_in_row']); ?>}' data-bears-lightgallery='{"selector": ".btn-play-video"}'>
						<div class="grid-sizer"></div>
						<div class="gutter-sizer"></div>
						<?php if ( have_posts() ) :
							while ( have_posts() ) : the_post();

								get_template_part( 'templates/recipe/content', $alone_general_recipes_options['recipe_type'] );
							endwhile;
						else :
							// If no content, include the "No posts found" template.
							get_template_part( 'content', 'none' );
						endif; ?>
					</div><!-- /.postlist-->
					<?php alone_paging_navigation(); // archive pagination ?>
				</div>
			</div><!-- /.bt-content-area-->

			<?php get_sidebar(); ?>
		</div><!-- /.row-->
	</div><!-- /.container-->
</section>
<?php get_footer(); ?>
