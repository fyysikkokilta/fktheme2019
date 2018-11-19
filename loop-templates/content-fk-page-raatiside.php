<?php
/**
 * Partial template for content in front-page.php
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>




<article class="col-md-8 order-md-5" <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

<aside class="col-md-4 order-md-1 text-center">
	<?php 
		$raati_ID = get_field("fk_raatilainen"); 
	?>

	<div class="fk-board">
		<img src="<?php the_field("raati_kuva", $raati_ID) ?>" alt="">
		<p>
			<b><?php the_field("raati_virka", $raati_ID); ?></b> <br>
			<?php the_field("raati_nimi", $raati_ID); ?> <br>
			<?php the_field("raati_mail", $raati_ID); ?> <br>
			<?php the_field("raati_puhelin", $raati_ID); ?>
		</p>
	</div>
</aside>
