<?php

if( is_admin() ){
	add_action( 'admin_menu', 'tsp_options' );
	add_action( 'wp_ajax_the_ajax_hook_4', 'mytourna_empty' );
	add_action( 'wp_ajax_the_ajax_hook_5', 'mytourna_delete' );
	add_action( 'admin_enqueue_scripts', 'add_stylesheet' );
}    

function add_stylesheet( $page ) {        
        wp_enqueue_style( 'custom-style', plugins_url('css/myoptions.css', __FILE__) );
}

function tsp_options() {
	add_menu_page( 'tourn_options', 'tourn_options', 'administrator', 'tsp_options', 'tsp_display_form' );
}

function tsp_display_form() {
	$html=
	'<h2>Tournament Sign-up Plugin Options</h2>
	<form class="myoptions1">
	To delete the content from the table, click the Empty button.<br>
	<input name="action" type="hidden" value="the_ajax_hook_4" />
	<input type="button" value="Empty" onClick="empty_table();" >
	</form>
	
	<form class="myoptions2">
	To delete the table from database, click the delete button.<br>	
	<input name="action" type="hidden" value="the_ajax_hook_5" />
	<input type="button" value="Delete" onClick="delete_table();" >	
	<br><b>Note</b>: To create the table you need to re-activate the plugin.
	</form>
       <div class="option_response"></div>';
	echo $html;
}

?>
