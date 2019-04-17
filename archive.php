<?php
/**
 * The template for displaying Archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
$_FW = defined( 'FW' );
$alone_sidebar_position = function_exists( 'fw_ext_sidebars_get_current_position' ) ? fw_ext_sidebars_get_current_position() : 'right';
$alone_general_posts_options = alone_general_posts_options();

/* START - custom size container variable */
$post_id = (int) get_queried_object_ID();
$content_class = 'content'; $sidebar_template = '';
//echo get_option( 'page_for_posts' );

get_header();
alone_title_bar();

if ( $_FW ) {
	$post_fw_options_custom_values_serialize = get_post_custom_values('fw_options', $post_id); //fw_get_db_post_option($post_id, 'container_size', '');
	$post_fw_options_custom_values = ! empty($post_fw_options_custom_values_serialize) ? unserialize(trim($post_fw_options_custom_values_serialize[0])) : array('container_size' => '');
	$page_container_size = isset($post_fw_options_custom_values['container_size']) ? $post_fw_options_custom_values['container_size'] : '';

	switch ($page_container_size) {
		case 'container-large': $content_class = 'fully'; $sidebar_template = 'fully-template'; break;
	}
}
/* END - custom size container variable */
?>
<section class="bt-main-row bt-section-space <?php alone_get_content_class('main', $alone_sidebar_position); ?>" role="main" itemprop="mainEntity" itemscope="itemscope" itemtype="http://schema.org/Blog">
	<div class="container <?php echo esc_attr( ($content_class == 'fully') ? 'container-fully' : '' ); ?>">
		<div class="row">
			<div class="bt-content-area <?php alone_get_content_class( $content_class, $alone_sidebar_position ); ?>">
				<div class="bt-col-inner">
					<?php // if( function_exists('fw_ext_breadcrumbs') && bearsthemes_check_is_bbpress() == '' ) fw_ext_breadcrumbs(); ?>
					<div class="postlist" data-bears-masonryhybrid='{"col": <?php echo esc_attr($alone_general_posts_options['number_post_in_row']); ?>, "space": 40}'>
						<div class="grid-sizer"></div>
						<div class="gutter-sizer"></div>
						<?php if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								get_template_part( 'templates/'.$alone_general_posts_options['blog_type'].'/content', get_post_format() );
							endwhile;
						else :
							// If no content, include the "No posts found" template.
							get_template_part( 'content', 'none' );
						endif; ?>
					</div><!-- /.postlist-->
					<?php alone_paging_navigation(); // archive pagination ?>
				</div>
			</div><!-- /.bt-content-area-->

			<?php get_sidebar($sidebar_template); ?>
		</div><!-- /.row-->
	</div><!-- /.container-->
</section>
<?php get_footer(); ?>
