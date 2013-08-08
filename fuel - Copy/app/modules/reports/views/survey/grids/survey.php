<table class="datatable"   >
	<thead>
		<tr>
			<th>NUMBER</th>
			<th>CONTACT</th>
			<th width="30%">ORGANISATION</th>
			<th>SURVERY VER.</th>
			<th>SENT</th>
                        <th>RETURNED</th>
                        <th>CONTACT NOTIFIED</th>
                        <th>OUCOME</th>
                        <th>OUTCOME DATE</th>
                        <th></th>
		</tr>
	</thead>

</table>

<div style="display:none;">
	<div id="advance_search_modal" style="width:950px; background-color: #E9B47A">
		
		<div id="searchforreports">
    	
        <div class="content">
        	
            <h1>SEARCH FOR REPORT(S)</h1>
            
            <div class="box-1">
            	<div class="c1">
                    <table class="advance_search" width="100%" id="job_advanced_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>FEILD CRITERIA 1:</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select class="filter_field check1 select-1 select" data-label="Search Field" name="field_crieteria_01">
									<option value="N/A">N/A</option>
									<option selected="selected" value="AND">AND</option>
									<option value="OR">OR</option>
								</select>
							</td>
                            <td valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="center"><p>FEILD:</p></td>
                            <td width="30%" valign="top" align="center"><p>EQUALITY</p></td>
                            <td valign="top" align="center"><p>CRITERIA</p></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select class="filter_field field1 select-1" data-label="Search Field" name="field" id="">
									<option value="">Select</option>
									<option value="Artefact Description">Artefact Description</option>
									<option value="Artefact Make">Artefact Make</option>
									<option value="Artefact Model">Artefact Model</option>
									<option value="Artefact Owner">Artefact Owner</option>
									<option value="Artefact Serial number">Artefact Serial number</option>
									<option value="Certificate offered">Certificate offered</option>
									<option value="Purchase order number">Purchase order number</option>
									<option value="Internal delivery instructions">Internal delivery instructions</option>
									<option value="Job number">Job number</option>
									<option value="Services offered">Services offered</option>
									<option value="Special requirements">Special requirements</option>
								</select>
							</td>
                            <td valign="top" align="center">
								<?php echo \Helper_Form::seach_criteria('equality', '', array('class' => 'field1 filter_field', 'data-label' => 'Search Equality')); ?>
							</td>
                            <td valign="top" align="center">
								<input class="field1 filter_field" type="text" data-label="Search Criteria" name="criteria" />
							</td>
                        </tr>
                    </table>
                </div>
                <div class="c1">
                    <table class="advance_search" width="100%" id="job_advanced_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>FEILD CRITERIA 2:</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select class="filter_field check2 select-1 select" data-label="Search Field" name="field_crieteria_02" id="">
									<option value="N/A">N/A</option>
									<option value="AND">AND</option>
									<option value="OR">OR</option>
								</select>
							</td>
                            <td valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="center"><p>FEILD:</p></td>
                            <td width="30%" valign="top" align="center"><p>EQUALITY</p></td>
                            <td valign="top" align="center"><p>CRITERIA</p></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select class="filter_field field2 select-1" data-label="Search Field" name="advance[field]" id="">
									<option value="">Select</option>
									<option value="Artefact Description">Artefact Description</option>
									<option value="Artefact Make">Artefact Make</option>
									<option value="Artefact Model">Artefact Model</option>
									<option value="Artefact Owner">Artefact Owner</option>
									<option value="Artefact Serial number">Artefact Serial number</option>
									<option value="Certificate offered">Certificate offered</option>
									<option value="Purchase order number">Purchase order number</option>
									<option value="Internal delivery instructions">Internal delivery instructions</option>
									<option value="Job number">Job number</option>
									<option value="Services offered">Services offered</option>
									<option value="Special requirements">Special requirements</option>
								</select>
							</td>
                            <td valign="top" align="center">
								<?php echo \Helper_Form::seach_criteria('advance[equality]', '', array('class' => 'field2 filter_field', 'data-label' => 'Search Equality')); ?>
							</td>
                            <td valign="top" align="center">
								<input class="filter_field field2" type="" data-label="Search Criteria" name="advance[criteria]" />
							</td>
                        </tr>
                    </table>
                </div>
                <div class="c1">
                    <table class="advance_search" width="100%" id="job_advanced_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>DATE CRITERIA 1:</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select class="filter_field check3 select-1 select" data-label="Search Field" name="date_crieteria" id="">
										<option value="N/A">N/A</option>
										<option value="AND">AND</option>
										<option value="OR">OR</option>
								</select>
							</td>
                            <td valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="center"><p>DATE FEILD:</p></td>
                            <td width="30%" valign="top" align="center"><p>FROM</p></td>
                            <td valign="top" align="center"><p>TO</p></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select class="filter_field field3 select-1" data-label="Search Field" name="date[field]" id="">
									<option value="">Select</option>
									<option value="Actual Start Date">Actual Start Date</option>
									<option value="Date returned to store">Date returned to store</option>
									<option value="Outcome Date">Outcome Date</option>
									<option value="Planned Start Date">Planned Start Date</option>
								</select>
							</td>
                            <td valign="top" align="center">
								<input type="text" class="field3 textbox-1 filter_field advanced_search datepicker" name="date[from]" />
							</td>
                            <td valign="top" align="center">
								<input type="text" class="field3 textbox-1 filter_field advanced_search datepicker" name="date[to]"/>
							</td>
                        </tr>
                    </table>
                </div>
                
                
            </div>
            
            <div class="box-2">
            	<div class="leftside">
                	<p>'Intelligent' search on S/N</p>
                    <input type="checkbox" class="checkbox" />
                    <p id="switch"><strong>OFF</strong></p>
                </div>
            	<div class="rightside">
                	<div class="blk"><input type="button" class="button1" value="SEARCH" /></div>
                    <div class="blk"><input type="button" class="button2 cb iframe close" value="close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>
		
	</div>
</div>

<script>


$(document).ready(function() {
         


         dt =$('.datatable').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "bFilter" : true,
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0, 3, 4 ] } ],
                "sAjaxSource": "<?php echo \Uri::create('reports/surveys/listing'); ?>",
                "fnServerParams": function ( aoData ) {
                             var df = $('.grid_filter .filter_field');
                            var ds = $('.advance_search .filter_field');

                            var filter = {};

                            $.each(df, function(index, val){
                                    if($(this).val() !== null) {
                                            aoData.push( {"name": "extra_search_"+$(this).attr('name'), "value": $(this).val()} );
                                            filter['extra_search_'+$(this).attr('name')] = $(this).val();
                                    }
                            });

                            $.each(ds, function(index, val){
                                    if($(this).val() !== null) {
                                            aoData.push( {"name": "advance_search_"+$(this).attr('name'), "value": $(this).val()} );
                                    }
                            }); 

                            $.ajax({
                                    url: "<?php echo \Uri::create('reports/surveys/dropdown_data'); ?>",
                                    type: "GET",
                                    dataType: 'json',
                                    data: filter,
                                    success: function(data){
                                            $('#csr_returned_by, #csr_survey_version, #csr_organsiation, #csr_get_branches, #csr_sections, #csr_projects,#csr_get_areas').html('<option value="">Select</option>');

                                            $.each(data, function(index, value){
                                                    $.each(data[index], function(key, val){
                                                            $('*[name='+index+']').append('<option value="'+key+'">'+val+'</option>');
                                                    });
                                                    $('*[name='+index+']').val(filter['extra_search_'+$('*[name='+index+']').attr('name')]);
                                            });
                                    }
                            });
                }

        } );

           
               var parameter = '<?php echo @\Input::get('n'); ?>';  
               alert('Your current Owner is '+parameter);
               
               $("#form_csr_organsiation").val( parameter ).attr('selected',true);
               dt.fnDraw();
                
              $('#search_clear').click(function(){
                      $('.advance_search .filter_field').val('');
                      $('#search_clear, #search').toggle();
                      dt.fnDraw();
              });


              $('.grid_filter .filter_field').bind('keyup change', function(){
                      dt.fnDraw('sel_change');
              });

              $('#advance_search').click(function(){
                      var ds = $('#advance_search .filter_field');
                      var do_run = 0;

                      $.each(ds, function(index, value){
                              if($(this).val().length === 0) {
                                      alert('Please fill in '+$(this).data('label'));
                                      do_run++;
                                      return false;
                              }
                      });
                      if(do_run == 0)
                          dt.fnDraw(); 
                         // $('#search_clear, #search').toggle();
                          $.colorbox.close();
              });

              $('table.advance_search .select').each(function(){
                      $(this).change(function(){
                              if(this.value == 'N/A'){
                                      $(this).parent().parent().siblings().find('.filter_field').each(function(){
                                              $(this).attr('disabled', 'disabled');
                                      });
                              }else{
                                      $(this).parent().parent().siblings().find('.filter_field').each(function(){
                                              $(this).removeAttr('disabled');
                                      });
                              }
                      });
              });

              $('table.advance_search .select').each(function(){
                      if(this.value == 'N/A'){
                              $(this).parent().parent().siblings().find('.filter_field').each(function(){
                                      $(this).attr('disabled', 'disabled');
                              });
                      }
              });


      $('#search').colorbox({inline:true});

              $('.leftside .checkbox').change(function(){
                      if(this.checked){
                              $('#search_for_quote .content .box-2 .leftside').css('background-color', '#FD8181');
                              $('#search_for_quote .content .box-2 .leftside #switch').text('ON');

                      }else{
                              $('#search_for_quote .content .box-2 .leftside').css('background-color', '#FEE69C');
                              $('#search_for_quote .content .box-2 .leftside #switch').text('OFF');
                      }
              });

              
         
 

} );

          function call_to_edit(url){
             var clorbox_open = $.colorbox({href:url});  
         }              


 </script>   