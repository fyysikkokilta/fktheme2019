<?php
/**
 * The template for displaying frontpage.
 *
 * 
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
		<?php
			global $post;
		$featuredImg = get_theme_mod( 'fk_front_image' );
		if ($featuredImg):
		?>
	<section class="container-fluid" id="fk-front-image" tabindex="-1">

			<div class="row" id="fk-image">
			<div class="col-12 px-0">
					<img class="img-fluid" src="<?php echo $featuredImg; ?>">
			</div>
		</div>

	</section><!-- fk-head-image container end -->
	<?php 
		endif;
	?>

	<section class="<?php echo esc_attr( $container ); ?>"  id="fk-calendar">

			<div class="row fk-calendar">
				<div class="col"><div class="calendar-item tapahtumat"></div></div>
				<div class="col"><div class="calendar-item ura"></div></div>
				<div class="col"><div class="calendar-item kokoukset"></div></div>
				<div class="col"><div class="calendar-item kulttuuri"></div></div>
				<div class="w-100"></div>
				<div class="col"><div class="calendar-item liikunta"></div></div>
				<div class="col"><div class="calendar-item kokoukset"></div></div>
				<div class="col"><div class="calendar-item ura"></div></div>
				<div class="col"><div class="calendar-item tapahtumat"></div></div>
			</div>


			<div class="row">

				<main class="site-main" id="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'frontpage' ); ?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- .row -->

		</div> <!-- Container end -->

</div><!-- Container-fluid end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
