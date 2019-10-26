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
  
	<section class="container-fluid" id="fk-front-image" tabindex="-1">
      
    <div class="row" id="fk-image">
      
      <?php 
        include_once 'php/front-page-slideshow.php';
        fk_front_page_slideshow();
      ?>
    
    </div>

	</section><!-- fk-head-image container end -->

  <section>

      <?php if( is_active_sidebar( 'fk-notification-widgets' ) ) { ?> 
      
        <div class="container fk-notification-widget">

	    	  <div class="row">
      
	    		  <?php dynamic_sidebar( 'fk-notification-widgets' ); ?>
      
          </div>
          
	    	</div>
      
	  	<?php }; ?>

  </section>

	<section class="<?php echo esc_attr( $container ); ?>"  id="fk-calendar">

		<div class="row">

			<?php 
				include_once 'php/gcal-puller.php';
				fk_cal_printEvents(8);
			?>

		</div>  <!-- row end -->

	</section> <!-- fk-calendar end -->

	<section class="container-fluid" id="fk-main">

		<div class="<?php echo esc_attr( $container ); ?>">
				<div class="row"> 

					<main class="site-main" id="main">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'loop-templates/content', 'fk-frontpage' ); ?>

						<?php endwhile; // end of the loop. ?>

					</main><!-- #main -->

				</div><!-- .row -->
		</div> <!-- inner container -->

	</section> <!-- fk-main container end -->

	<section class="container" id="fk-ig-feed" tabindex="-1">
		<div class="row" id="fk-ig">

		<?php
			include_once 'php/ig-puller.php';
			fk_ig_printEvents(8);
		?>
		</div>
	</section><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
