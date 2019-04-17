<?php
/**
 * The Template for displaying all single Give Forms.
 *
 * Override this template by copying it to yourtheme/give/single-give-forms.php
 *
 * @package       Give/Templates
 * @version       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$_FW = defined( 'FW' );

get_header();
alone_title_bar();

$alone_sidebar_position = function_exists( 'fw_ext_sidebars_get_current_position' ) ? fw_ext_sidebars_get_current_position() : 'right';
// $alone_general_posts_options = alone_general_posts_options();
$give_single_general_opts = array(
	// 'number_form_per_page' => 9,
	'single_layout' => 'default',
);
if($_FW) { $give_single_general_opts = fw_get_db_customizer_option('give_settings/give_single'); }
// print_r($give_single_general_opts);
/**
 * Fires in single form template, before the main content.
 *
 * Allows you to add elements before the main content.
 *
 * @since 1.0
 */
?>
<section class="bt-main-row bt-section-space <?php alone_get_content_class( 'main', $alone_sidebar_position ); ?>" role="main" itemprop="mainEntity" itemscope="itemscope" itemtype="http://schema.org/Give">
	<div class="container">
		<div class="row">
			<div class="bt-content-area <?php alone_get_content_class( 'content', $alone_sidebar_position ); ?>">
				<div class="bt-col-inner give-single-layout-<?php echo esc_attr($give_single_general_opts['single_layout']); ?>">
          <?php
          do_action( 'give_before_main_content' );

          while ( have_posts() ) : the_post();
          	get_template_part( 'templates/single-give/content', $give_single_general_opts['single_layout'] );

						/* navigation prev - next template */
						get_template_part( 'templates/single-give/give-form', 'navigation' );
					endwhile; // end of the loop.

          /**
           * Fires in single form template, after the main content.
           *
           * Allows you to add elements after the main content.
           *
           * @since 1.0
           */
          do_action( 'give_after_main_content' );

          /**
           * Fires in single form template, on the sidebar.
           *
           * Allows you to add elements to the sidebar.
           *
           * @since 1.0
           */
          do_action( 'give_sidebar' );
          ?>
        </div><!-- /.bt-col-inner -->
      </div><!-- /.bt-content-area -->
      <?php get_sidebar(); ?>
    </div><!-- /.row -->
  </div><!-- /.container -->
</section>
<?php get_footer(); ?>
