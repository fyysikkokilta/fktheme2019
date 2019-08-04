<?php
    add_shortcode( 'fk_fuksit_navigation', 'fk_display_fuksit_navigation' );

    // Creates navigation bar to fuksikuvat page. See also fk-fuksikuva-shortcode.php
    function fk_display_fuksit_navigation( $atts ) {
      $a = shortcode_atts( array(
        'year' => '2018',
      ), $atts );

    // TODO chage link before commit

      $dir = wp_upload_dir()['basedir'] . '/fuksikuvat';
      $folder_contents = glob(($dir . '/*') , GLOB_ONLYDIR);
      $folder_contents = array_reverse($folder_contents);  //Sort years to right order
      $pagination_index = 1;
      $base_navigation_url = 'https://www.fyysikkokilta.fi/fuksikuvat/';

      $out = '<div class="row fuksikuva-navigation">';
      
      foreach ($folder_contents as $idx=>$path_to_class) {
        
        $path_splitted = explode("/", $path_to_class);
        $class = end($path_splitted);
        $year = substr($class, 6);
        $out .= '<a href=' . $base_navigation_url . '/' . $pagination_index . '>';
        if ( $a['year'] == $year ) {
          $out .= '<div class="year-button selected-year-button">';
        } else {
          $out .= '<div class="year-button">';
        }
        $out .= '<h2 class="year-button-text">' . $year . '</h2>';
        $out .= '</div>';
        $out .= '</a>';

        $pagination_index += 1;
      }

      $out .= '</div>';

      return($out);
    }