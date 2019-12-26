<?php
    add_shortcode( 'fk_toimarit', 'fk_display_toimarit' );
    // NOTE: test with actual data and add &shy to appropriate places in the
    // json files to get correct hyphenation.
    // https://en.wikipedia.org/wiki/Soft_hyphen

    function fk_display_toimarit( $atts ){
        $a = shortcode_atts( array(
            'folder' => '2019',
        ), $atts );

        $dir = wp_upload_dir()['basedir'].'/toimihenkilot';
        $url = wp_upload_dir()['baseurl'].'/toimihenkilot';
        $folder = $a['folder'];

        $out = '<div class="row">';
        $jaokset = json_decode(file_get_contents($dir."/".$folder."/jaokset.json"), true);
        $toimarit = json_decode(file_get_contents($dir."/".$folder."/toimarit.json"), true);
        $kuvat = json_decode(file_get_contents($dir."/".$folder."/kuvat.json"), true);

        $class_index = 0;
        $color_classes = array("jaos-color-1","jaos-color-2","jaos-color-3","jaos-color-4","jaos-color-5");
        
        // Description of the algorihm:
        //
        // Same person has picture only once inside the division. He/she can be his/her picture in many divisions.
        // People in the division are organized by their task. Order of tasks in division is configured in the file 'jaokset.json'.
        // People who have same task are organized by their order in the file 'toimarit.json'.
        // If one has many tasks in one division, his/her picture is shown at first possible occurrence based on the
        // division's task order and the order of people. Rest of his/her tasks are listed below the picture.
        // This is carried out for each division. Order of divisions is configured in 'jaokset.json'.
        foreach ($jaokset as $jaos => $jaoksen_toimarivirat) {
          $out .= '<div class="col-lg-2 col-md-3 col-sm-4 col-6 jaos-header '.$color_classes[$class_index % count($color_classes)].'">
                  <h3>'.$jaos.'</h3>
                  </div>'; 
          $henkilöt_jaoksessa = [];

          foreach ($jaoksen_toimarivirat as $toimarivirka) {
            foreach ($toimarit as $henkilö => $henkilön_toimarivirat) {
              if(in_array($toimarivirka, $henkilön_toimarivirat)) {
                // Associative arrays have unique keys, so adding same person
                // multiple times doesn't lead to duplicates.
                $henkilöt_jaoksessa[$henkilö] = array_intersect($jaoksen_toimarivirat,$henkilön_toimarivirat);
              }
            }
          }

          foreach ($henkilöt_jaoksessa as $henkilö => $henkilön_toimarivirat_jaoksessa) {
            $out .= '<div class="col-lg-2 col-md-3 col-sm-4 col-6 jaos '.$color_classes[$class_index % count($color_classes)].'">
                      <img src='.$url.'/'.$folder.'/kuvat/'.$kuvat[$henkilö].'>
                      <h5>'.$henkilö.'</h5>
                      <p>'.implode(", ", $henkilön_toimarivirat_jaoksessa).'</p>
                      </div>';
          }
          $class_index += 1;
        }
        $out .= '</div>';

        return ( $out );
    }