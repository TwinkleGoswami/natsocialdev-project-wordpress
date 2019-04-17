<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 */
?>
	</div><!-- /.site-main -->

	<!-- Footer -->
	<footer id="colophon" class="site-footer bt-footer <?php alone_get_footer_class(); ?>">
		<?php alone_footer(); ?>
	</footer>
</div><!-- /#page -->
<?php wp_footer(); ?>
<div class="svg_bleeding_stock_wrap">
	<!-- SVG Filters -->
	<svg xmlns="http://www.w3.org/2000/svg" version="1.1">
	  <defs>
	    <!--   This is where the magic happens   -->
	    <filter id="svg_bleeding_stock">

	      <!--    Apply 10px blur    -->
	      <feGaussianBlur in="SourceGraphic" stdDeviation="12" result="blured" />
	      <!--   Increase the contrast of the alpha channel
	              Read this https://goo.gl/P152Jd     -->
	      <feColorMatrix in="blured" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="weirdNumbers" />
	      <!--    Adding the two effects,
	              Fix some bugs with "atop" -->
	      <feComposite in="SourceGraphic" in2="weirdNumbers" operator="atop"/>
	    </filter>
	  </defs>
	</svg>
</div>
</body>
</html>
