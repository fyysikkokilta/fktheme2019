<?php

/**
 * Hide certain menu items as they do no good.
 */
function remove_menus() {
	remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );