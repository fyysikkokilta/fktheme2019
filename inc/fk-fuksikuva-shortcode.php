<?php
    add_shortcode( 'fk_fuksit', 'fk_display_fuksit' );

    function fk_display_fuksit( $atts ){
        $a = shortcode_atts( array(
            'folder' => 'fuksit2018',
            'title' => 'Fuksit 2018'
        ), $atts );

        $dir = wp_upload_dir()[basedir] . '/fuksikuvat' ;
        $url = wp_upload_dir()[baseurl] . '/fuksikuvat';
        $folder = $a['folder'];
        $title = $a['title'];

        $transient_name = $folder;
        
        $out = '';

        if( false === ($out = get_transient($transient_name))) {
            

            $folder_contents = glob(($dir . '/' . $folder . '/*') , GLOB_ONLYDIR);

            $out = '';
            $out .= '<div class="row"> <h2>' . $title . '</h3></div>'; 

            foreach ($folder_contents as $idx=>$fuksir) {
                $files = array_diff(scandir($fuksir), array('..', '.'));
                $ryhma = end(explode("/", $fuksir));
                
                $out .= '<div class="row"> <h3>' . str_replace("_", " ", $ryhma) . '</h3></div>'; 

                $out .= '<div class="row">';
                foreach($files as $fuksikuva) {
                    if(substr($fuksikuva, -3) === "jpg" || substr($fuksikuva, -4) === "jpeg" ) {
                        $adress = $url . '/' . $folder  . '/' . $ryhma . '/' . $fuksikuva . ' ';
                        $nimi = explode(".", $fuksikuva)[0];
                        $nimi = str_replace("_", " ", $nimi);
                        $out .= '<div class="col-md-2 col-sm-3 col-4">';
                        $out .= '<img src="' . $adress . '" class="">';
                        $out .= '<p>' . $nimi . '</p>';
                        $out .= '</div>';
                    }
                }
                $out .= '</div>';
            }
            
            set_transient( $transient_name, $out, 60*60*24*30);

        }
        return ($out);

    }