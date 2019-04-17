<?php if ( !session_id() ) session_start(); ?>
<!doctype html>
<!--[if lt IE 8 ]><html <?php language_attributes(); ?> class="ie7"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="ie8"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<div id="main" class="site-main" role="main">
			<?php
			global $post;
			while ( have_posts() ) :
				the_post();
				$post->post_content; // echo manual the post_content, when page has many shortcodes
			endwhile;
			?>
		</div>
	</div><!-- /#page -->
	<?php wp_footer(); ?>
</body>
</html>
