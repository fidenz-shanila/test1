$(document).ready(function(){

	//send details back to parent page when files listing is opened for selection
	$('.select_file').live('click', function(){

		var ele = $(this);
		var parent = window.parent;

		var id  = ele.data('id');
		var title  = ele.data('title');
//parent.set_file_data_quote(id,title);

		parent.$('#cb_file_title').val(title);
		parent.$('#cb_file_id').val(id);
                parent.$('#OpenFile').dialog('close');
                
//		parent.$('.cb').colorbox.close();
		parent.$('#no_file_exists').removeAttr("checked");

	});

});