<?php
/**
Template Name: Recipe Fully Template
Template Post Type: recipe
*/

get_header();
alone_title_bar();
$alone_sidebar_position = function_exists( 'fw_ext_sidebars_get_current_position' ) ? fw_ext_sidebars_get_current_position() : 'right';
$alone_general_posts_options = alone_general_posts_options();
?>
<section class="bt-main-row bt-section-space <?php alone_get_content_class( 'main', $alone_sidebar_position ); ?>" role="main" itemprop="mainEntity" itemscope="itemscope" itemtype="http://schema.org/Blog">
	<div class="container container-fully">
		<div class="row">
			<div class="bt-content-area <?php alone_get_content_class( 'fully', $alone_sidebar_position ); ?>">
				<div class="bt-col-inner">
					<?php // if( function_exists('fw_ext_breadcrumbs') ) fw_ext_breadcrumbs(); ?>
					<?php while ( have_posts() ) : the_post();
						set_query_var( 'template', 'recipe_fully_template' );
						get_template_part( 'templates/single-recipe/content' );
						if ( comments_open() ) { ?>
							<div class="row">
								<div class="col-md-10 col-md-offset-1"><?php comments_template(); ?></div>
							</div>
						<?php }
						break;
					endwhile; ?>
				</div><!-- /.bt-col-inner -->
			</div><!-- /.bt-content-area -->
			<?php get_sidebar('fully-template'); ?>
		</div><!-- /.row -->
	</div><!-- /.container -->
</section>
<?php get_footer(); ?>
