<?php
/**
 * Template Name: Visual Builder Template
 */

get_header();
while ( have_posts() ) :
	the_post(); ?>

    <?php if ( post_password_required() ) : ?>
        <section class="bt-main-row password-protected-section" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
            <div class="container">
                <div class="frow">
                    <div class="bt-content-area">
                        <div class="bt-inner">
                            <article id="page-<?php the_ID(); ?>" class="post post-details" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
                                <div class="inner">
                                    <header class="entry-header">
                                        <?php alone_single_post_title( $post->ID, 'page' ); ?>
                                    </header>
                                    <div class="entry-content" itemprop="text">
                                        <?php the_content(); ?>
                                    </div>
                                </div><!-- /.inner-->
                            </article>
                        </div><!-- /.bt-inner-->
                    </div><!-- /.bt-content-area-->
                </div><!-- /.row-->
            </div><!-- /.container-->
        </section>
    <?php else: ?>
			<?php echo apply_filters( 'bearsthemes_visual_builder_temp_before_content', '' ); ?>
	    <?php the_content(); ?>
			<?php echo apply_filters( 'bearsthemes_visual_builder_temp_after_content', '' ); ?>
    <?php endif; ?>
<?php endwhile;

get_footer();
?>
