function submit_me(){

	jQuery.post(the_ajax_script.ajaxurl, jQuery(".theform").serialize(),function(response_from_the_action_function){
				jQuery('.theform')[0].reset();
				jQuery(".response_area").html(response_from_the_action_function);
				setTimeout(function() {
				jQuery(".response_area").empty();
				}, 5000);
			});
	}


function display_table(){
	
	jQuery.post(the_ajax_script.ajaxurl, jQuery(".form_branch").serialize(),function(response_from_display_data_table){
				jQuery(".table_disp").html(response_from_display_data_table);
			});
}


function display_table_1(){
	
	jQuery.post(the_ajax_script.ajaxurl, jQuery(".form_year").serialize(),function(response_from_display_data_table_1){
				jQuery(".table_disp").html(response_from_display_data_table_1);
			});
}

function display_form(){
	
	jQuery.post(the_ajax_script.ajaxurl, jQuery(".form_tourn").serialize(),function(response_from_display_buttons){
				jQuery(".disp_form").html(response_from_display_buttons);
			});
}


function empty_table(){
	
	jQuery.post(the_ajax_script.ajaxurl, jQuery(".myoptions1").serialize(),function(response_from_mytourna_empty){
				jQuery(".option_response").html(response_from_mytourna_empty);
				setTimeout(function() {
				jQuery(".option_response").empty();
				}, 5000);
			});
}

function delete_table(){
	
	jQuery.post(the_ajax_script.ajaxurl, jQuery(".myoptions2").serialize(),function(response_from_mytourna_delete){
				jQuery(".option_response").html(response_from_mytourna_delete);
				setTimeout(function() {
				jQuery(".option_response").empty();
				}, 5000);			
			});
}

function pop_print(){
		w=window.open(null, 'Print_Page', 'scrollbars=yes');
		w.document.write(jQuery('.table_disp').html());
		w.document.write(jQuery('<link rel="stylesheet" href="mystyle.css" type="text/css" />').html());
		w.document.close();
		w.print();
	}
