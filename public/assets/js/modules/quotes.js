$(document).ready(function(){
	//confrimation popup on batch create
	$('body.create_batch form').submit(function(e){

		var quotes = $('input[name=QuotesToBatch]').val();

		if(quotes == ''){
			alert('You need to enter a number for quote amount');
			e.preventDefault();
			return false;
		} else
			if(confirm('Are you sure you wish to batch '+quotes+' quote(s)')) {
				return true;
			}
			else {
				e.preventDefault();
				return false;
			}

	});

	$('#insert_workgroup, .delete_workgroup').colorbox({
		iframe:true,
		width:"80%",
		height:"80%",
		onClosed: function(){
			$( '.worklog_container iframe' ).attr( 'src', function ( i, val ) { return val; });
		}
	});


	/*
	 * Build Description @ New Quote
	 * @author Namal
	 */
	$('#build_desc').click(function(){
		
		var form_A_Type = $('#form_A_Type').val();
		var form_A_Make = $('#form_A_Make').val();
		var form_A_Model = $('#form_A_Model').val();
		var form_A_SerialNumber = $('#form_A_SerialNumber').val();
		var form_A_PerformanceRange = $('#form_A_PerformanceRange').val();
		
		if(form_A_Type == '') {
			alert('Please fill in the Instrumental Type');
			return false;
		
		}else{
			$.ajax({
				url: url('quotes/build_artifact_description'),
				type: "GET",
				dataType: 'json',
				data: {'form_A_Type':form_A_Type, 'form_A_Make':form_A_Make, 'form_A_Model':form_A_Model, 'form_A_SerialNumber':form_A_SerialNumber, 'form_A_PerformanceRange':form_A_PerformanceRange},
				success: function(data){
					$('#form_A_Description').val(data);
				}
			});
		}
		
	});


	/**
	 * EXTERNAL - Change owner logic in new quote, change owner
	 */
	$("#select_owner").click(function(){

		var url_data = url('quotes/select_owner_extrenal');
		
        if($("#owner_type").val() == "NMI"){
			url_data = url('quotes/select_owner_nmi');
		}

		$.ajax({
			type: "GET",
			url: url_data,
			success: function(data){
				$("#pop_up_data").hide().html(data).fadeIn('fast');
			}
		});
	});

	/**
	 * NMI - Change owner logic in new quote, change owner
	 */
	$("#select_ok").click(function(){

		if( $("#nmi_project").val() > 0 && $("#nmi_contact").val() ) {

			$("#new_organisation").val($("#nmi_project").find(":selected").text());
			$("#form_A_OR1_OrgID_fk").val($("#nmi_project").val());
			$("#new_contact").val($("#nmi_contact").find(":selected").text());
			$("#form_A_ContactID").val($("#nmi_contact").val());
			popup_close();
		
		} else {
			alert('Make sure that you\'ve selected both project and contact.');
		}

	});

	/**
	 * Work done by dropdowns in New Quote view.
	 */
	$('.wdb_data').on('change', function(){

	   var filter = new Array();

	   filter.push(this);

		$.ajax({
		    url: url('quotes/new_quote_listing'),
		    type: "GET",
		    dataType: 'json',
		    data: filter,
		    success: function(data){
			
			$.each(data, function(index, value){
			    
				if($(filter).attr('name') == index ){
				   return true;
				}
				
				$('*[name='+index+']').empty();

				$.each(data[index], function(key, val){
				    $('*[name='+index+']').append('<option value="'+key+'">'+val+'</option>');
				});
			});
		    }
		});
	});

	//new quote, choose no file exists
	$('.no_file_exists').live('click', function(){

		if ($(this).is(':checked')) {

			$.getJSON(url('files/no_file_exists'), function(data){

				$('.cb_file_id').val(data.CF_FileNumber_pk);
				$('.cb_file_title').val(data.CF_Title);

			});

		} else {

			$('.cb_file_id, .cb_file_title').val('');
		}

	});

});



function popup_close(){

	$("#pop_up_data").fadeOut('fast', function(){
		$(this).empty();
	});

}

function set_contact(t, CO_ContactID_pk, OR1_OrgID_pk){
    
	a = $(t).parent().parent();
	$("#new_organisation").val($(a).find("td:nth-child(3)").text());
	$("#form_A_OR1_OrgID_fk").val(OR1_OrgID_pk);
	$("#new_contact").val($(a).find("td:nth-child(2)").text());
	$("#form_A_ContactID").val(CO_ContactID_pk);
	popup_close();
}