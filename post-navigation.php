<?php
/**
 * The default template for displaying post navigation
 */

$alone_enable_post_navigation  = defined( 'FW' ) ? fw_get_db_customizer_option( 'posts_settings/posts_single/post_navigation', 'yes' ) : 'yes';
if( $alone_enable_post_navigation != 'yes') return;
?>

<div class="row">
  <div class="col-md-12">
    <div class="single-blog-post-navigation">
  		<?php previous_post_link( '%link', '<div class="bt-itable"><div class="bt-icell pv-left"><div class="btn" style="margin-bottom:10px;"><i class="fa fa-angle-left"></i><span>' . esc_html__( 'Previous Story', 'alone' ) . '</span></div><div><strong>%title</strong></div></div></div>' ); ?>
  		<?php next_post_link( '%link', '<div class="bt-itable"><div class="bt-icell pv-right"><div class="btn" style="margin-bottom:10px;"><span>' . esc_html__( 'Next Story', 'alone' ) . '</span><i class="fa fa-angle-right"></i></div><div><strong>%title</strong></div></div></div>' ); ?>
    </div><hr/>
  </div>
</div>
