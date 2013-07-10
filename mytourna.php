<?php 
/*
Plugin Name: Mytourna
Plugin URI: http://bhattigurjot.wordpress.com
Description: A plugin to display tournament sign-up form in any page.
Author: Gurjot Singh
Version: 1.0
Author URI: http://bhattigurjot.wordpress.com
*/

include_once ( "table.php" );
include ( "myoptions.php" );
register_activation_hook( __FILE__, 'mytourna_install' ); //On activating plugin, 'mytourna_install' function from table.php file is called 

//Checks if admin side or front-end is enabled
if ( !is_admin() ) {
	add_shortcode("my_ajax_form", "my_form");
}

function my_style() {  
    // Register the style  
    wp_register_style( 'custom-style', plugin_dir_url(__FILE__ ) . 'css/mystyle.css', array(), '1.0', 'all' );  
    
    // Enqueue the style  
    wp_enqueue_style( 'custom-style' );  
}  

	add_action( 'wp_enqueue_scripts', 'my_style' );

	 //Enqueue and localise scripts
	 wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'js/ajax.js', array( 'jquery' ) );
	 wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 
	 // The AJAX add actions
	 add_action( 'wp_ajax_the_ajax_hook', 'the_action_function' );
	 add_action( 'wp_ajax_the_ajax_hook_1', 'display_buttons' );
	 add_action( 'wp_ajax_the_ajax_hook_2', 'display_data_table' );
	 add_action( 'wp_ajax_the_ajax_hook_3', 'display_data_table_1' );

	 //add_action( 'wp_ajax_nopriv_the_ajax_hook', 'the_action_function' ); // need this to serve non logged in users

// Function that contains form structure
function my_form(){
	$the_form = '
	<form class="theform">
	 <input class="rad" type="radio" required = "required"  name="game" value="Badminton">Badminton
	 <input class="rad" type="radio" required = "required"  name="game" value="Basketball">Basketball
	 <input class="rad" type="radio" required = "required"  name="game" value="Football">Football
	 <br>
	 Tournament: 
	 <br>
	 <select name="tourn">
	 <option value="Inter-Year" >Inter-Year</option>
	 <option value="Inter-Department" >Inter-Department</option>
	 </select>
	 
	 <br>
	 Name: 
	 <br>
	 <input type="text" required = "required" name="name" />
	 <br>
	 
	 <div class="select_yr">
	   Year: 
	   <br>
	   <select name="year">
	   <option value="D1">D1</option>
	   <option value="D2">D2</option>
	   <option value="D3">D3</option>
	   <option value="D4">D4</option>
	   </select>
	 </div>
	
	 <div class="select_br">
	   Branch: 
	   <br>
	   <select name="branch">
	   <option value="CSE">CSE</option>
	   <option value="CE">CE</option>
	   <option value="ECE">ECE</option>
	   <option value="EE">EE</option>
	   <option value="IT">IT</option>
	   <option value="ME">ME</option>
	   <option value="PE">PE</option>
	   <option value="PG">PG</option>
	   </select>
	 </div>
	 
	 <br><br><br>

	 <div class="clg">
	   College Roll No.: 
	   <br>
	   <input type="number" required = "required" name="c_roll" />
	 </div>
	 
	 University Roll No.: 
	 <br>
	 <input type="number" required = "required" name="u_roll" />
	 <br>	
		 
 	 <input name="action" type="hidden" value="the_ajax_hook" /> &nbsp; <!-- this puts the action the_ajax_hook into the serialized form -->
	 <input class="submit_button" value = "Submit" type="button" onClick="submit_me();" />
	 <input class="reset_button" type="reset" value="Reset Fields">
	 <div class="response_area"></div>	
	</form>
	 <br>
  
	 <div class="second">
	   <form class="form_tourn"> 
	   Submitted Entries For
	   <input name="action" type="hidden" value="the_ajax_hook_1" />
	   <select name="tourn" class="tourn" onchange="display_form();" >
	   <option id="inter_year" value="Inter-Year">Inter-Year</option>	
	   <option id="inter_department" value="Inter-Department">Inter-Department</option>
	   </select>
	   </form>
	   <div class="disp_form"></div>
	   <div class="table_disp"></div>
	 </div>';
	 return $the_form;
}
 
?>
