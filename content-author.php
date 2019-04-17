<?php
/**
 * The template for displaying content-author in the single.php template.
 * To override this template in a child theme, copy this file
 * to your child theme's folder.
 *
 */

$alone_enable_author_box  = defined( 'FW' ) ? fw_get_db_customizer_option( 'post_settings/posts_single/post_author_box', '' ) : '';

if ( $alone_enable_author_box == 'yes' ) : ?>
	<section class="author-description">
		<div class="author-image">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), '164' ); ?>
		</div>
		<div class="author-text">
			<!-- <h2 class="author-name"><?php esc_html_e( 'Article by', 'alone' ); ?> <span itemprop="name"><?php the_author(); ?></span></h2> -->
			<div class="author-name"><?php esc_html_e( 'Article by', 'alone' ); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><span itemprop="name"><?php the_author(); ?></span></a></div>
			<p><?php echo get_the_author_meta( 'description' ); ?></p>
		</div>
	</section>
	<div class="clearfix"></div>
<?php endif; ?>
