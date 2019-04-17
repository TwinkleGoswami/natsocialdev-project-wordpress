<?php
/**
 * The Sidebar containing the main widget area
 */

$alone_sidebar_position = null;
if ( function_exists( 'fw_ext_sidebars_get_current_position' ) ) :
	$alone_sidebar_position = fw_ext_sidebars_get_current_position();
	if ( $alone_sidebar_position !== 'full' && $alone_sidebar_position !== null ) : ?>
		<div class="col-md-4 col-sm-12 bt-sidebar" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			<div class="bt-col-inner">
				<?php if ( $alone_sidebar_position === 'left' || $alone_sidebar_position === 'right' ) : ?>
					<?php echo fw_ext_sidebars_show( 'blue' ); ?>
				<?php endif; ?>
			</div><!-- /.inner -->
		</div><!-- /.sidebar -->
	<?php endif; ?>
<?php else : ?>
	<div class="col-md-4 col-sm-12 bt-sidebar" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
		<div class="bt-col-inner">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- /.inner -->
	</div><!-- /.sidebar -->
<?php endif; ?>
