<?php
    add_shortcode( 'fk_fuksit', 'fk_display_fuksit' );

    function fk_display_fuksit( $atts ){
        $a = shortcode_atts( array(
            'folder' => 'fuksit2018',
            'title' => 'Fuksit 2018'
        ), $atts );

        $dir = wp_upload_dir()['basedir'] . '/fuksikuvat';
        $url = wp_upload_dir()['baseurl'] . '/fuksikuvat';
        $folder = $a['folder'];
        $title = $a['title'];

        $transient_name = $folder;

        delete_transient( $transient_name );

        if( false === ($out = get_transient($transient_name))) {
            
            // Array that contains paths to subdirectories: each of them depicts own freshman group
            $folder_contents = glob(($dir . '/' . $folder . '/*') , GLOB_ONLYDIR);

            $out .= '<div class="all-fuksikuvat">';
            $out .= '<div class="row"><h2>' . $title . '</h2></div>'; 

            // For every year files are not sorted Freshman groups. For those years use layout, where 
            // all images are smashed together
            if ( count($folder_contents) === 0 ) {

              $fuksit = $dir . '/' . $folder;
              
              $files = array_diff(scandir($fuksit), array('..', '.'));
              
              $out .= '<div class="row">';

              foreach($files as $fuksikuva) {

                  if( (substr($fuksikuva, -3) === "jpg" || substr($fuksikuva, -4) === "jpeg") && !(strpos($fuksikuva, '150') !== false) ) {

                      $adress = $url . '/' . $folder  . '/' . $fuksikuva . ' ';                      
                      $nimi = explode(".", $fuksikuva)[0];
                      $nimi = str_replace("_", " ", $nimi);
                      $out .= '<div class="col-lg-2 col-md-3 col-sm-4 col-6">';
                      $out .= '<img src="' . $adress . '" class="">';
                      $out .= '<p>' . $nimi . '</p>';
                      $out .= '</div>'; 
                  }
              }
              $out .= '</div>';

            } else {

              foreach ($folder_contents as $idx=>$fuksir) {

                  $files = array_diff(scandir($fuksir), array('..', '.'));

                  $rr = explode("/", $fuksir);

                  $ryhma = end($rr);
                  
                  $out .= '<div class="row"><h3>' . str_replace("_", " ", $ryhma) . '</h3></div>'; 
  
                  $out .= '<div class="row">';

                  foreach($files as $fuksikuva) {
                      if( (substr($fuksikuva, -3) === "jpg" || substr($fuksikuva, -4) === "jpeg") && !(strpos($fuksikuva, '150') !== false) ) {

                          $adress = $url . '/' . $folder . '/' . $ryhma . '/' . $fuksikuva . ' ';
                          $nimi = explode(".", $fuksikuva)[0];
                          $nimi = str_replace("_", " ", $nimi);
                          $out .= '<div class="col-lg-2 col-md-3 col-sm-4 col-6">';
                          $out .= '<img src="' . $adress . '" class="">';
                          $out .= '<p>' . $nimi . '</p>';
                          $out .= '</div>'; 
                      }
                  }
                  $out .= '</div>';
              }
            }
            $out .= '</div>';

            set_transient( $transient_name, $out, 60*60*24*30);
        }
        return ($out);

    }