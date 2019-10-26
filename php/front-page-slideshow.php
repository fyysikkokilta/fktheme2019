<?php
/**
 * Function for showing slideshow on frontpage. It looks uploads/frontpage/ folder
 * and creates js and html that loops over them and cross fades between each transition.
 */

function fk_front_page_slideshow()
{
  $dir = wp_upload_dir()['basedir'] . '/frontpage';
  $url = wp_upload_dir()['baseurl'] . '/frontpage';
  $folder_contents = glob(($dir . '/*'));

  $out = '<div class="front-page-image-container">';
  foreach ($folder_contents as $image) {
    $out .= '<img class="front-page-image hide" src="' . $url . '/' . end(explode('/', $image)) . '">';
  }
  $out .= '</div>
            <script>
              // Script for changing the main image.
              var slideIndex =' . rand(1, count($folder_contents)) . ';
              showSlides();

              function showSlides() {
                var i;
                var slides = document.getElementsByClassName("front-page-image");
                slides[slideIndex-1].classList.remove("show");
                slideIndex++;
                if (slideIndex > slides.length) {slideIndex = 1}    
                slides[slideIndex-1].classList.add("show");
                setTimeout(showSlides, 8000);
              }
            </script>';
  echo $out;
}
