<?php
    add_shortcode( 'fk_haryt', 'fk_display_haryt' );

    function fk_display_haryt(){
        $args = array(
            'post_type' => 'raatilaiset',
            'post_status' => 'publish',
            'posts_per_page' => '20',
            'order' => 'ASC',
            'orderby' => 'menu_order',
        );

        $string = '';
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            $string .= '<div class ="row fk-raatilista">';
            while( $query->have_posts() ){
                $query->the_post();
                if(get_field('raati_yesno') == False ) {
                    $string .= '<div class="col-5 col-md-3 col-lg-2 fk-raatilainen">';
                    $string .= '<img src="' . get_field("raati_kuva") . '" class="rounded-circle" style="display: block; margin-left: auto; margin-right: auto;" alt="' . get_field("raati_virka") . '">';
                    $string .= '<p class="text-center">' . (get_field("raati_nimi") ? ('<span class="fk-raati-nimi">' . get_field("raati_nimi") . '</span><br>') : '');
			        $string .= (get_field("raati_tg") ? ('<a href="https://t.me/' . substr(get_field("raati_tg"), 1) . '" target="_blank"> <span class="fk-raati-tg">' . get_field("raati_tg") . '</span></a><br>') : '');    
                    $string .= (get_field("raati_mail") ? ('<a href="mailto:' . get_field("raati_mail") . '" target="_top"> <span class="fk-raati-mail">' . get_field("raati_mail") . '</span></a><br>') : '');              
                    $string .= (get_field("raati_puhelin") ? ('<span class="fk-raati-puhelin"> ' . get_field("raati_puhelin") . '</span>') : '') . '</p>';
                    $string .= '</div>';
                }   
            }
            $string .= '</div>';
        }
        wp_reset_postdata();
        return $string;
    }