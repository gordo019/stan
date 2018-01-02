<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package StanleyWP
 */
get_header(); ?>

	
			<div id="primary" class="content-area-full">
				<main id="main" class="site-main" role="main">

				<?php
				if ( have_posts() ) :
					if ( is_home() && ! is_front_page() ) : ?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>

					<?php
					endif;
					/* Start the Loop */
					while ( have_posts() ) : the_post();
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile; ?>
					
					<div class="container">
						<div class="row justify-content-center mt-4 text-center">
							<div class="col-md-8">
<!-- 								<?php the_posts_navigation(); ?> -->
								<?php fellowtuts_wpbs4_pagination(); ?>
							</div><!--  .col-md-8 -->
						</div><!--  .row -->
					</div><!--  .container -->
					

				<?php  
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->
		

<?php
get_footer();