<!doctype html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">        
            <?php wp_head(); ?>
	<style>
		#success_message{ display: none;}
	</style>
</head>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
<div id="page" class="site">
	<?php alone_header_mobile_menu(); ?>
	<?php alone_header(); ?>
	<div id="main" class="site-main">
