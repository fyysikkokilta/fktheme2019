<?php
/**
 * Partial template for content in page-raatiside.php
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>


<article class="col-md-8 order-md-2" <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Sivut:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

<aside class="col-md-3 col-sm-6 order-md-1 text-center">
	<?php
		$raati_ID = get_field("fk_raatilainen");
		$raati_ID2 = get_field("fk_raatilainen2");
		$raati_ID3 = get_field("fk_raatilainen3");
		$raati_ID4 = get_field("fk_raatilainen4");
	?>

	<div class="fk-raati-side">
		<img src="<?php the_field("raati_kuva", $raati_ID) ?>" class="rounded-circle" alt="<?php the_field("raati_virka", $raati_ID); ?>">
		<?php echo (get_field("raati_virka", $raati_ID)  ? ('<h5 class="fk-raati-virka text-center">' . get_field("raati_virka", $raati_ID) . '</h5>') : ''); ?>
		<p>
			<?php echo (get_field("raati_nimi", $raati_ID) ? ('<span class="fk-raati-nimi">' . get_field("raati_nimi", $raati_ID) . '</span><br>') : ''); ?>
			<?php echo (get_field("raati_mail", $raati_ID) ? ('<a href="mailto:' . get_field("raati_mail", $raati_ID) . '" target="_blank"> <span class="fk-raati-mail">' . get_field("raati_mail", $raati_ID) . '</span></a><br>') : ''); ?>
			<?php echo (get_field("raati_tg", $raati_ID) ? ('<a href="https://t.me/' . substr(get_field("raati_tg", $raati_ID), 1) . '" target="_blank"> <span class="fk-raati-tg">' . get_field("raati_tg", $raati_ID) . '</span></a> &vert;') : ''); ?>
			<?php echo (get_field("raati_puhelin", $raati_ID) ? ('<span class="fk-raati-puhelin">' . get_field("raati_puhelin", $raati_ID) . '</span><br>') : ''); ?>
		</p>
		
		<img src="<?php the_field("raati_kuva", $raati_ID2) ?>" class="rounded-circle" alt="<?php the_field("raati_virka", $raati_ID2); ?>">
		<?php echo (get_field("raati_virka", $raati_ID2)  ? ('<h5 class="fk-raati-virka text-center">' . get_field("raati_virka", $raati_ID2) . '</h5>') : ''); ?>
		<p>
			<?php echo (get_field("raati_nimi", $raati_ID2) ? ('<span class="fk-raati-nimi">' . get_field("raati_nimi", $raati_ID2) . '</span><br>') : ''); ?>
			<?php echo (get_field("raati_mail", $raati_ID2) ? ('<a href="mailto:' . get_field("raati_mail", $raati_ID2) . '" target="_blank"> <span class="fk-raati-mail">' . get_field("raati_mail", $raati_ID2) . '</span></a><br>') : ''); ?>
			<?php echo (get_field("raati_tg", $raati_ID2) ? ('<a href="https://t.me/' . substr(get_field("raati_tg", $raati_ID2), 1) . '" target="_blank"> <span class="fk-raati-tg">' . get_field("raati_tg", $raati_ID2) . '</span></a> &vert;') : ''); ?>
			<?php echo (get_field("raati_puhelin", $raati_ID2) ? ('<span class="fk-raati-puhelin">' . get_field("raati_puhelin", $raati_ID2) . '</span><br>') : ''); ?>
		</p>
		
		<img src="<?php the_field("raati_kuva", $raati_ID3) ?>" class="rounded-circle" alt="<?php the_field("raati_virka", $raati_ID3); ?>">
		<?php echo (get_field("raati_virka", $raati_ID3)  ? ('<h5 class="fk-raati-virka text-center">' . get_field("raati_virka", $raati_ID3) . '</h5>') : ''); ?>
		<p>
			<?php echo (get_field("raati_nimi", $raati_ID3) ? ('<span class="fk-raati-nimi">' . get_field("raati_nimi", $raati_ID3) . '</span><br>') : ''); ?>
			<?php echo (get_field("raati_mail", $raati_ID3) ? ('<a href="mailto:' . get_field("raati_mail", $raati_ID3) . '" target="_blank"> <span class="fk-raati-mail">' . get_field("raati_mail", $raati_ID3) . '</span></a><br>') : ''); ?>
			<?php echo (get_field("raati_tg", $raati_ID3) ? ('<a href="https://t.me/' . substr(get_field("raati_tg", $raati_ID3), 1) . '" target="_blank"> <span class="fk-raati-tg">' . get_field("raati_tg", $raati_ID3) . '</span></a> &vert;') : ''); ?>
			<?php echo (get_field("raati_puhelin", $raati_ID3) ? ('<span class="fk-raati-puhelin">' . get_field("raati_puhelin", $raati_ID3) . '</span><br>') : ''); ?>
		</p>
		
		<img src="<?php the_field("raati_kuva", $raati_ID4) ?>" class="rounded-circle" alt="<?php the_field("raati_virka", $raati_ID4); ?>">
		<?php echo (get_field("raati_virka", $raati_ID4)  ? ('<h5 class="fk-raati-virka text-center">' . get_field("raati_virka", $raati_ID4) . '</h5>') : ''); ?>
		<p>
			<?php echo (get_field("raati_nimi", $raati_ID4) ? ('<span class="fk-raati-nimi">' . get_field("raati_nimi", $raati_ID4) . '</span><br>') : ''); ?>
			<?php echo (get_field("raati_mail", $raati_ID4) ? ('<a href="mailto:' . get_field("raati_mail", $raati_ID4) . '" target="_blank"> <span class="fk-raati-mail">' . get_field("raati_mail", $raati_ID4) . '</span></a><br>') : ''); ?>
			<?php echo (get_field("raati_tg", $raati_ID4) ? ('<a href="https://t.me/' . substr(get_field("raati_tg", $raati_ID4), 1) . '" target="_blank"> <span class="fk-raati-tg">' . get_field("raati_tg", $raati_ID4) . '</span></a> &vert;') : ''); ?>
			<?php echo (get_field("raati_puhelin", $raati_ID4) ? ('<span class="fk-raati-puhelin">' . get_field("raati_puhelin", $raati_ID4) . '</span><br>') : ''); ?>
		</p>
	</div>
</aside>
