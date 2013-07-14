<?php

global $mytourna_db_version;
$mytourna_db_version = "1.0"; //Declared the current version of database

//Creates a table in the database
function mytourna_install() {
	global $wpdb; // $wpdb variable as a “global” letting WordPress know that we are going to work with the “$wpdb” class
	$table_name = $wpdb->prefix."mytourna"; //Describing table_name 
	$sql = "CREATE TABLE $table_name (
	id int NOT NULL AUTO_INCREMENT,
	game varchar(255) NOT NULL,
	tourn varchar(255) NOT NULL,
	name varchar(255) NOT NULL,
	year varchar(255) NOT NULL,
	branch varchar(255) NOT NULL,
	c_roll int NOT NULL,
	u_roll int NOT NULL,
	UNIQUE KEY id (id),
	PRIMARY KEY (c_roll)
	);";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' ); 
	dbDelta( $sql ); /*The dbDelta function examines the current table structure, compares it to the desired table structure, and either adds or modifies the table as necessary. Helpful in updates*/

	add_option( "mytourna_db_version", $mytourna_db_version );
}

//Dropping the table from the database
function mytourna_delete() {
	global $wpdb; 
	$table_name = $wpdb->prefix."mytourna"; 
	$wpdb->query("DROP TABLE IF EXISTS $table_name");
	echo "Table deleted from database.";
	die();
}

//Empty the table in a database
function mytourna_empty() {
	global $wpdb; 
	$table_name = $wpdb->prefix."mytourna"; 
	$wpdb->query("TRUNCATE TABLE $table_name");
	echo "The whole content in the table has been deleted.";
	die();
}

//Form Submit function 
function the_action_function(){
 	//Check if there's an empty field
	if ( !empty($_POST['game']) && !empty($_POST['tourn']) && !empty($_POST['name']) && !empty($_POST['year']) && !empty($_POST['branch']) && !empty($_POST['c_roll']) && !empty($_POST['u_roll']) ){
		
	global $wpdb;
	$table_name = $wpdb->prefix."mytourna";

	$vgame = $_POST['game'];
	$vtourn = $_POST['tourn'];
	$vname = $_POST['name'];
	$vyear = $_POST['year'];
	$vbranch = $_POST['branch'];
	$vc_roll = $_POST['c_roll'];
	$vu_roll = $_POST['u_roll'];

	$check_croll=$wpdb->get_var( "SELECT * FROM $table_name WHERE c_roll = '$vc_roll'" );
	$check_uroll=$wpdb->get_var( "SELECT * FROM $table_name WHERE u_roll = '$vu_roll'" );

		if( $check_croll!=0 ){

		echo "This College Roll No. has already been registered. Please ensure that you have entered correct Roll No.";

		} else if( $check_uroll!=0 ){

		echo "This University Roll No. has already been registered. Please ensure that you have entered correct Roll No.";

		} else{

		$wpdb->insert( $table_name, array( 'game'=>$vgame, 'tourn'=>$vtourn, 'name'=>$vname, 'year'=>$vyear, 'branch'=>$vbranch, 'c_roll'=>$vc_roll, 'u_roll'=>$vu_roll), array('%s', '%s', '%s', '%s', '%s', '%d', '%d'));

		echo "Thankyou! Your form has been submitted. ";

		}

	} else{

	echo "Some fields are empty! Kindly fill them.";

	}// this is passed back to the javascript function

 	die();// wordpress may print out a spurious zero without this - can be particularly bad if using json
}

//Display data for Inter-Department teams
function display_data_table(){
	global $wpdb;
	$table_name = $wpdb->prefix."mytourna";
	$mno=$_POST['branch'];
	$onm=$_POST['game'];
	$retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE branch = '$mno' AND game='$onm' AND tourn = 'Inter-Department'" );
	echo "Tournament: Inter-Department<br>";
	echo "Game: ".$onm;
	echo "<br>Team: ".$mno;
	echo "<table>";
	echo "<tr>";
	echo "<td>Name</td>";
	echo "<td>Year</td>";
	echo "<td>College Roll No.</td>";
	echo "<td>University Roll No.</td>";
	echo "</tr>";
		foreach($retrieve_data as $retrieved_data){
		echo "<tr>";
		echo "<td>".$retrieved_data->name."</td>";
		echo "<td>".$retrieved_data->year."</td>";
		echo "<td>".$retrieved_data->c_roll."</td>";
		echo "<td>".$retrieved_data->u_roll."</td>";
		echo "</tr>";
		}
	echo "</table>";
	echo "<br><br><input type='button' class='print' onClick='pop_print()' value='Print'/>";
	die();
}

//Display data for Inter-Year teams
function display_data_table_1(){
	global $wpdb;
	$table_name = $wpdb->prefix."mytourna";
	$lmn=$_POST['year'];
	$nml=$_POST['game'];
	$retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE year = '$lmn' AND game='$nml' AND tourn = 'Inter-Year'" );
	echo "Tournament: Inter-Year<br>";
	echo "Game: ".$nml;
	echo "<br>Team: ".$lmn;
	echo "<table>";
	echo "<tr>";
	echo "<td>Name</td>";
	echo "<td>Year</td>";
	echo "<td>College Roll No.</td>";
	echo "<td>University Roll No.</td>";
	echo "</tr>";
		foreach( $retrieve_data as $retrieved_data ){
		echo "<tr>";
		echo "<td>".$retrieved_data->name."</td>";
		echo "<td>".$retrieved_data->year."</td>";
		echo "<td>".$retrieved_data->branch."</td>";
		echo "<td>".$retrieved_data->c_roll."</td>";
		echo "<td>".$retrieved_data->u_roll."</td>";
		echo "</tr>";
		}
	echo "</table>";
	echo "<br><br><input type='button' class='print' onClick='pop_print()' value='Print'/>";
	die();
}

//Display select buttons according to the tournament selected
function display_buttons(){
	if( $_POST['tourn'] == 'Inter-Department' ){
	$html=
	'
	 <form class="form_branch" >
	 
	 <select name="game" id="game" >
	 <option value="Badminton" >Badminton</option>
	 <option value="Basketball" >Basketball</option>
	 <option value="Football" >Football</option>
	 </select>
	
	 <input name="action" type="hidden" value="the_ajax_hook_2" />
	 <select name="branch" id="branch" onchange="display_table();" >
	 <option value="CSE" >CSE</option>
	 <option value="CE" >CE</option>
	 <option value="ECE" >ECE</option>
	 <option value="EE" >EE</option>
	 <option value="IT" >IT</option>
	 <option value="ME" >ME</option>
	 <option value="PE" >PE</option>
	 <option value="PG" >PG</option>
	 </select>
	 </form>
	';
	echo $html;
	} else{
	$html=
	'
	 <form class="form_year">
	
	 <select name="game" id="game" >
	 <option value="Badminton" >Badminton</option>
	 <option value="Basketball" >Basketball</option>
	 <option value="Football" >Football</option>
	 </select>
	
	 <input name="action" type="hidden" value="the_ajax_hook_3" />
	 <select name="year" id="year" onchange="display_table_1();" >
	 <option value="D1" >D1</option>
	 <option value="D2" >D2</option>
	 <option value="D3" >D3</option>
	 <option value="D4" >D4</option>
	 </select>
	 </form>
	';
	echo $html;
	}
	die();
}
	
?>
