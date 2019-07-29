<?php
    add_shortcode( 'fk_raati', 'fk_display_raati_members' );

    function fk_display_raati_members(){
        $args = array(
            'post_type' => 'raatilaiset',
            'post_status' => 'publish',
            'posts_per_page' => '15',
            'order' => 'ASC',
            'orderby' => 'menu_order',
        );

        $string = '';
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            $string .= '<div class ="row fk-raatilista">';
            while( $query->have_posts() ){
                $query->the_post();
                if(get_field('raati_yesno') == True ) {
                    $string .= '<div class="col-6 col-md-4 col-lg-3 fk-raatilainen">';
                    $string .= '<img src="' . get_field("raati_kuva") . '" class="rounded-circle" alt="' . get_field("raati_virka") . '">';
                    $string .= (get_field("raati_virka")  ? ('<h5 class="fk-raati-virka text-center">' . get_field("raati_virka") . '</h5>') : '');
                    $string .= '<p class="text-center">' . (get_field("raati_nimi") ? ('<span class="fk-raati-nimi">' . get_field("raati_nimi") . '</span><br>') : '');
                    $string .= (get_field("raati_mail") ? ('<a href="mailto:' . get_field("raati_mail") . '" target="_top"> <span class="fk-raati-mail">' . get_field("raati_mail") . '</span></a><br>') : '');
			              $string .= (get_field("raati_tg") ? ('<a href="https://t.me/' . substr(get_field("raati_tg"), 1) . '" target="_blank"> <span class="fk-raati-tg">' . get_field("raati_tg") . '</span></a> &vert;') : '');                  
                    $string .= (get_field("raati_puhelin") ? ('<span class="fk-raati-puhelin"> ' . get_field("raati_puhelin") . '</span>') : '') . '</p>';
                    $string .= '</div>';
                }   
            }
            $string .= '</div>';
        }
        wp_reset_postdata();
        return $string;
    }