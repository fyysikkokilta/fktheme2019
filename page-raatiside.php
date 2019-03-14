<?php
/**
 * Template Name: Raatilais-sidebar
 * 
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container   = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper-hero" id="page-wrapper">
	<?php if(has_post_thumbnail($post->ID)): ?>
	
	<div class="container-fluid" id="fk-featured-image">
		<div class="row">
			<div class="col-12 px-0" id="fk-featured-container">
				<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
				<div class="fk-overlay"></div>

				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row">
						<div class="md-col-9 offset-md-3 ">
							<header class="entry-header header-overlay">

							<h1><?php echo get_the_title($post->ID); ?></h1>

							</header><!-- .entry-header -->

						</div>
					</div>
				</div> <!-- Close title container  -->

			</div>
		</div>
	</div> <!-- close featured image container -->
	<?php else: ?> <!-- If there is no  -->

	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="row">
			<div class="md-col-8 offset-md-3">
				<header class="entry-header header-alone">

				<h1><?php echo get_the_title($post->ID); ?></h1>

				</header><!-- .entry-header -->

			</div>
		</div>
	</div> <!-- Close title container  -->

	<?php endif ?>

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- <main class="site-main" id="main"> -->

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content', 'fk-page-raatiside' ); ?>


				<?php endwhile; // end of the loop. ?>

			<!-- </main>#main -->

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
