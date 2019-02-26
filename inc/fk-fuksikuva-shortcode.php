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

        $folder_contents = glob(($dir . '/' . $folder . '/*') , GLOB_ONLYDIR);

        $out = '';
        foreach ($folder_contents as $idx=>$fuksir) {
            $files = array_diff(scandir($fuksir), array('..', '.'));

            foreach($files as $fuksikuva) {
                $out .= '<img src="' . $url . '/' . ' ' . '/' . $fuksikuva . '" class="">';
                //$out .= $fuksikuva . ' ';
            }
            
        }

        return implode($folder_contents);

    }