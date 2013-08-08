<table border="0"  class="datatable">
	<thead>
		<tr>
                    
                        <th width="2%" ></th>
                        <th width="6%" id="col3"></th>
                        <th width="1%"></th>
                        <th width="6%" id="col4"></th>
			<th width="35%" id="col5"></th>
			<th width="23%" id="col6"></th>
			<th width="23%" id="col7"></th>
			<th width="6%" id="col8"></th>
		</tr>
	</thead>
</table>

<div id="dialog-form"  style="display:none;">
	<div id="search_for_quote" class="clr_quotes" style="height:100%; width:100%;background-color:#FEE69C;">
		
		<div class="content">
	
            <h1>SEARCH FOR QUOTE(S)</h1>
            
            <div class="box-1">
            	<div class="c1">
                    <table cellpadding="0" border="0" cellspacing="0" border="0" class="table-1 advance_search" >
                        <tr>
                            <td width="30%" valign="top" align="center"><p>FIELD CRITERIA 1</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
                                <select id="SelectFieldCriteria_One" class="select-1 filter_field advance_search select" name="field_criteria_1">
                                    <option value="N/A">N/A</option>
                                    <option value="AND" selected="selected">AND</option>
                                    <option value="OR">OR</option>
                                </select></td>
                            <td valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="center" ><p>FIELD</p></td>
                            <td width="30%" valign="top" align="center"><p>EQUALITY</p></td>
                            <td valign="top" align="center"><p>CRITERIA</p></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
                                <select id="selectField"  class="select-1 filter_field advance_search" name="field">
                                    <option value="Artefact Description">Artefact Description</option>
                                    <option value="Artefact Make">Artefact Make</option>
                                    <option value="Artefact Model">Artefact Model</option>
                                    <option value="Artefact Owner">Artefact Owner</option>
                                    <option value="Artefact Serial number" selected>Artefact Serial number</option>
                                    <option value="Certificate offered">Certificate offered</option>
                                    <option value="Internal delivery instructions">Internal delivery instructions</option>
                                    <option value="Purchase order number">Purchase order number</option>
                                    <option value="Quote checked by">Quote checked by</option>
                                    <option value="Quote number">Quote number</option>
                                    <option value="Quote sent method">Quote sent method</option>
                                    <option value="Services offered">Services offered</option>
                                    <option value="Special requirements">Special requirements</option>
                                    <option value="CB File Number">CB File Number</option>
                                </select></td>
                            <td valign="top" align="center">
                                <?php echo \Helper_Form::seach_criteria('equality', '', array('class'=>'filter_field advance_search', 'data-label' => 'Search Equality')); ?>
                            </td>
                            <td valign="top" align="center"><input type="text" id="criteriaTxt" class="textbox-1  filter_field" name="criteria"/></td>
                        </tr>
                    </table>
                </div>
                <div class="c1">
                    <table border="0" cellpadding="0" cellspacing="0" border="0" class="table-1 advance_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>FIELD CRITERIA 2</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
							<select id="SelectFieldCriteria_2" class="select-1 filter_field hide select" name="field_criteria_2">
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
                            <select id="advanceField" class="select-1 filter_field advanced_search" name="advance[field]">
                                     <option ></option>
                                    <option value="Artefact Description">Artefact Description</option>
                                    <option value="Artefact Make">Artefact Make</option>
                                    <option value="Artefact Model">Artefact Model</option>
                                    <option value="Artefact Owner">Artefact Owner</option>
                                    <option value="Artefact Serial number">Artefact Serial number</option>
                                    <option value="Certificate offered">Certificate offered</option>
                                    <option value="Internal delivery instructions">Internal delivery instructions</option>
                                    <option value="Purchase order number">Purchase order number</option>
                                    <option value="Quote checked by">Quote checked by</option>
                                    <option value="Quote number">Quote number</option>
                                    <option value="Quote sent method">Quote sent method</option>
                                    <option value="Services offered">Services offered</option>
                                    <option value="Special requirements">Special requirements</option>
                                    <option value="CB File Number">CB File Number</option>
                                </select></td>
                            <td valign="top" align="center">
                                    <?php echo \Helper_Form::seach_criteria2('advance[equality]', '', array('class'=>'filter_field advance_search','id'=>'advanceEquality', 'data-label' => 'Search Equality')); ?>
                               </td>
                            <td valign="top" align="center"><input type="text" id="ASCriteriaQ_2" class="textbox-1 filter_field advanced_search" name="advance[criteria]" />
                                
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="c1">
                    <table cellpadding="0" cellspacing="0" border="0" class="table-1 advance_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>DATE CRITERIA 1</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center"><select id="SelectFieldCriteria_3" class="select select-1 filter_field hide" name="date_criteria">
                                    <option value="N/A">N/A</option>
                                    <option value="AND">AND</option>
                                    <option value="OR">OR</option>
                                </select></td>
                            <td valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="center"><label id="FieldCri3F" style="color:#B8B8B8;"><u>DATE FIELDS</u></label></td>
                            <td width="30%" valign="top" align="center"><label id="FieldCri3E" style="color:#B8B8B8;"><u>FROM</u></label></td>
                            <td valign="top" align="center"><label id="FieldCri3C" style="color:#B8B8B8;"><u>TO</u></label></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
                                <select id="dateEquality" class="select-1 filter_field advanced_search" name="date[equality]">
                                    <option ></option>
                                    <option value="Artefacts required">Artefacts required</option>
                                    <option value="Quotes expired">Quotes expired</option>
                                    <option value="Quotes offered">Quotes offered</option>
                                    <option value="Quotes sent">Quotes sent</option>
                                </select>
                                </td>
                            <td valign="top" align="center"><input type="text" id="dateFrom" class="textbox-1 filter_field advanced_search datepicker" name="date[from]" /></td>
                            <td valign="top" align="center"><input type="text" id="dateTo" class="textbox-1 filter_field advanced_search datepicker" name="date[to]"/></td>
                        </tr>
                    </table>
                </div>
            </div>
			
            <div class="box-2">
                 <table cellpadding="0" cellspacing="0" border="0" class="advance_search"><tr><td>
            	<div class="leftside" id="checkBoxDiv" style="background-color:#FD8181" >
                	<p>'Intelligent' search on S/N</p>
                    <input type="checkbox" id="IntelligentCheckbox" class="checkbox filter_field advanced_search checkBoxStl" name="Intelligent" value="yes" checked/>
                    <p id="switch"><strong>ON</strong></p>
                </div>
                 </td></tr></table>
            	<div class="rightside">
                    <div class="blk"><input type="button" id="advance_search" class="button1" value="SEARCH" /></div>
                    <div class="blk"><input type="button" class="button2 " id="closeWendow"  value="Close" /></div>
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