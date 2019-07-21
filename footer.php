<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );
?>

<footer class="wrapper" id="wrapper-footer">
	
	<div class="<?php echo esc_attr( $container ); ?>">

		<?php if( is_active_sidebar( 'fk-partner-widgets' ) && (is_front_page() || get_the_title()=="For enterprises" || get_the_title()=="Yritykset") ) { ?> <!-- Show partners only on frontpage -->
		
		<div class="row">
			<div class="col text-center fk-partner-title">
				<h2>
				Partners
				</h2>
			</div>
		</div>

		<div class="row">

			<?php dynamic_sidebar( 'fk-partner-widgets' ); ?>

		</div>

		<hr class="col-xs-12">
		<?php }; ?>

		<div class="row">

			<?php dynamic_sidebar( 'fk-footer-widgets' ); ?>

		</div>

	</div><!-- container end -->

</footer><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

