<?php
/**
 * The template for displaying Search Results pages
 */

 $alone_sidebar_position = function_exists( 'fw_ext_sidebars_get_current_position' ) ? fw_ext_sidebars_get_current_position() : 'right';
 $alone_general_posts_options = alone_general_posts_options();
 get_header();
 alone_title_bar();
 ?>
 <section class="bt-main-row bt-section-space <?php alone_get_content_class('main', $alone_sidebar_position); ?>" role="main" itemprop="mainEntity" itemscope="itemscope" itemtype="http://schema.org/Blog">
 	<div class="container">
 		<div class="row">
 			<div class="bt-content-area <?php alone_get_content_class( 'content', $alone_sidebar_position ); ?>">
 				<div class="bt-col-inner">
 					<?php // if( function_exists('fw_ext_breadcrumbs') && bearsthemes_check_is_bbpress() == '' ) fw_ext_breadcrumbs(); ?>
 					<div class="postlist">
 						<?php if ( have_posts() ) :
 							while ( have_posts() ) : the_post();
 								get_template_part( 'templates/search/content', get_post_format() );
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
