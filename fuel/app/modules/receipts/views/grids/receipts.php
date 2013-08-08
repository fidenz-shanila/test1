<table class="datatable">
	<thead>
		<tr>
			<th width="3%"></th>
			<th width="10%" id="col2"></th>
                        <th width="3%"></th>
			<th width="28%" id="col4"></th>
			<th width="28%" id="col5"></th>
			<th width="28%" id="col6"></th>
		</tr>
	</thead>
</table>
<div id="dialog-form" style="display:none;">
	<div id="advance_search_modal" >
		
	<div id="search_receipt" class="" style="height:100%; width:100%;background-color:#abd6d4;">
    	
        <div class="content">
        	
            <h1>SEARCH RECEIPT AND DESPATCH</h1>
            
            <div class="box-1">
            	<div class="c1">
                    <table class="table-1 advance_search" width="100%" id="job_advanced_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>FIELD CRITERIA 1</p></td>
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
                            <td width="30%" valign="top" align="center"><p>FIELD</p></td>
                            <td width="30%" valign="top" align="center"><p>EQUALITY</p></td>
                            <td valign="top" align="center"><p>CRITERIA</p></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select class="filter_field field1 select-1" data-label="Search Field" name="field" id="selectField">
									
									<option value="Artefact Description">Artefact Description</option>
									<option value="Artefact Make">Artefact Make</option>
									<option value="Artefact Model">Artefact Model</option>
									<option value="Artefact Serial number">Artefact Serial number</option>
									<option value="Carrier">Carrier</option>
									<option value="Carrier acc. no.">Carrier acc. no.</option>
									<option value="Carrier contact">Carrier contact</option>
									<option value="CB file number">CB file number</option>
									<option value="Delivery con note no.">Delivery con note no.</option>
									<option value="Delivered by">Delivered by</option>
                                                                        <option value="Insurance instructions">Insurance instructions</option>
									<option value="Internal delivery instructions">Internal delivery instructions</option>
									<option value="Picked up by">Picked up by</option>
									<option value="Purchase order number">Purchase order number</option>
                                                                        <option value="Carrier">Carrier</option>
									<option value="Quote number">Quote number</option>
									<option value="Return contact">Return contact</option>
									<option value="Return organisation">Return organisation</option>
									<option value="Shipping mode">Shipping mode</option>
									<option value="Shipping urgency">Shipping urgency</option>
                                                                        
								</select>
							</td>
                            <td valign="top" align="center">
								<?php echo \Helper_Form::seach_criteria('equality', '', array('class' => 'field1 filter_field', 'data-label' => 'Search Equality','id'=>'advanceEquality_field_crieteria_01')); ?>
							</td>
                            <td valign="top" align="center">
								<input id="criteriaTxt" class="field1 filter_field" type="text" data-label="Search Criteria" name="criteria" style="text-align:center"/>
							</td>
                        </tr>
                    </table>
                </div>
                <div class="c1">
                    <table class="table-1 advance_search" width="100%" id="job_advanced_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>FIELD CRITERIA 2</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select id="SelectFieldCriteria_2" class="filter_field check2 select-1 select" data-label="Search Field" name="field_crieteria_02" id="">
									<option value="N/A">N/A</option>
									<option value="AND">AND</option>
									<option value="OR">OR</option>
								</select>
							</td>
                            <td valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="center"><label id="FieldCri2F" style="color:#B8B8B8;"><u>FIELD:</u></label></td>
                            <td width="30%" valign="top" align="center"><label id="FieldCri2E" style="color:#B8B8B8;"><u>EQUALITY</u></label></td>
                            <td valign="top" align="center"><label id="FieldCri2C" style="color:#B8B8B8;"><u>CRITERIA</u></label></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select id="advanceField" class="filter_field field2 select-1" data-label="Search Field" name="advance[field]" id="">
									<option value=""></option>
									<option value="Artefact Description">Artefact Description</option>
									<option value="Artefact Make">Artefact Make</option>
									<option value="Artefact Model">Artefact Model</option>
									<option value="Artefact Serial number">Artefact Serial number</option>
									<option value="Carrier">Carrier</option>
									<option value="Carrier acc. no.">Carrier acc. no.</option>
									<option value="Carrier contact">Carrier contact</option>
									<option value="CB file number">CB file number</option>
									<option value="Delivery con note no.">Delivery con note no.</option>
									<option value="Delivered by">Delivered by</option>
                                                                        <option value="Insurance instructions">Insurance instructions</option>
									<option value="Internal delivery instructions">Internal delivery instructions</option>
									<option value="Picked up by">Picked up by</option>
									<option value="Purchase order number">Purchase order number</option>
                                                                        <option value="Carrier">Carrier</option>
									<option value="Quote number">Quote number</option>
									<option value="Return contact">Return contact</option>
									<option value="Return organisation">Return organisation</option>
									<option value="Shipping mode">Shipping mode</option>
									<option value="Shipping urgency">Shipping urgency</option>
								</select>
							</td>
                            <td valign="top" align="center">
								<?php echo \Helper_Form::seach_criteria2('advance[equality]', '', array('class' => 'field2 filter_field' ,'id'=>'advanceEquality', 'data-label' => 'Search Equality')); ?>
							</td>
                            <td valign="top" align="center">
								<input id="ASCriteriaJ_2" class="filter_field field2" type="text" data-label="Search Criteria" name="advance[criteria]" style="text-align:center"/>
							</td>
                        </tr>
                    </table>
                </div>
                <div class="c1">
                    <table class="table-1 advance_search" width="100%" id="job_advanced_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>DATE CRITERIA 1</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select id="SelectFieldCriteria_3" class="filter_field check3 select-1 select" data-label="Search Field" name="date_crieteria" id="">
										<option value="N/A">N/A</option>
										<option value="AND">AND</option>
										<option value="OR">OR</option>
								</select>
							</td>
                            <td valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="center"><label id="FieldCri3F" style="color:#B8B8B8;"><u>DATE FIELDS:</u></label></td>
                            <td width="30%" valign="top" align="center"><label id="FieldCri3E" style="color:#B8B8B8;"><u>FROM</u></label></td>
                            <td valign="top" align="center"><label id="FieldCri3C" style="color:#B8B8B8;"><u>TO</u></label></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select id="dateEquality" class="filter_field field3 select-1" data-label="Search Field" name="date[field]" id="">
									<option value=""></option>
									<option value="Date despatched">Date despatched</option>
									<option value="Date received">Date received</option>
									<option value="Date sent to store">Date sent to store</option>
									
								</select>
							</td>
                            <td valign="top" align="center">
								<input type="text" id="dateFrom" class="field3 textbox-1 filter_field advanced_search datepicker" name="date[from]" />
							</td>
                            <td valign="top" align="center">
								<input type="text" id="dateTo" class="field3 textbox-1 filter_field advanced_search datepicker" name="date[to]"/>
							</td>
                        </tr>
                    </table>
                </div>
                
                
            </div>
            
            <div class="box-2" width="10%" >
                <table cellpadding="0" width="50%" cellspacing="0" border="0" class="advance_search"><tr><td>
            	<div class="leftside" id="checkBoxDiv" style="background-color:#FD8181" >
                	<p>'Intelligent' search on S/N:</p>
                   <input type="checkbox" class="checkbox filter_field advanced_search checkBoxStl" name="Intelligent" value="yes" checked/>
                    <p id="switch"><strong>ON</strong></p>
                </div>
                 </td></tr></table>
            	<div class="rightside">
                	<div class="blk"><input type="button" id="advance_search12" class="button1" value="SEARCH" /></div>
                    <div class="blk"><input type="button" id="closeWendow" class="button2 " value="CANCEL/CLOSE" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

	</div>
</div>
<script type="text/javascript">
    
    
    
     $('input[type="checkbox"]').click(function(){
            if($(this).is(':checked')){
                $(this).attr('value','yes');
            }else{
                $(this).attr('value','no');
            }
        });
</script>
<script>
  $(function() {
    $( "input[type=button],button" )
      .button()
      .click(function( event ) {
        event.preventDefault();
      });
  });
  </script>
