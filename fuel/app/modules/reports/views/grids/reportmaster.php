<table class="datatable">
	<thead>
		<tr>
			<th width="1%"></th>
                        <th width="1%"></th>
			<th id="col2" width="7%"></th>
                        <th width="1%"></th>
			<th id="col3" width="7%"></th>
			<th id="col4" width="33%"></th>
			<th id="col5" width="20%"></th>
			<th id="col6" width="10%"></th>
			<th id="col7" width="8%"></th>
			<th id="col8" width="6%"></th>
			<th id="col9" width="6%"></th>
		</tr>
	</thead>
</table>

		
<div id="dialog-form" style="display:none;">
<div  id="advance_search_modal" class="masterLisstSer" >
		
	<div id="searchmaster" style="width:100%; height:100%;  background-color: #C7C78D">
    	
        <div class="content">
        	
            <h1>SEARCH MASTER LIST</h1>
            
            <div class="box-1">
            	<div class="c1">
                    <table class="advance_search table-1" width="100%" id="job_advanced_search">
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
								<select class="filter_field field1 select-1" data-label="Search Field" name="field" id="">
									<option value="Artefact Description">Artefact Description</option>
									<option value="Artefact Make">Artefact Make</option>
									<option value="Artefact Model">Artefact Model</option>
									<option value="Artefact Serial number">Artefact Serial number</option>
									<option value="Artefact Contact">Artefact Contact</option>
									<option value="File number">File number</option>
									<option value="Artefact Owner">Artefact Owner</option>
									<option value="Report number">Report number</option>
									<option value="Test Officer">Test Officer</option>
									<option value="Services Offered">Services Offered</option>
									<option value="Special Conditions">Special Conditions</option>
									<option value="Quote number">Quote number</option>
								</select>
							</td>
                            <td valign="top" align="center">
								<?php echo \Helper_Form::seach_criteria('equality', '', array('class' => 'field1 filter_field', 'data-label' => 'Search Equality')); ?>
							</td>
                            <td valign="top" align="center">
								<input class="field1 filter_field" id="criteria1St" type="text" data-label="Search Criteria" name="criteria" style="text-align:center" />
							</td>
                        </tr>
                    </table>
                </div>
                <div class="c1 advanceP">
                    <table class="advance_search table-1 advanceCriteria1P"  width="100%" id="job_advanced_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>FIELD CRITERIA 2</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select class="filter_field check2 select-1 select" data-label="Search Field" name="field_crieteria_02" id="field_crieteria_02">
									<option value="N/A">N/A</option>
									<option value="AND">AND</option>
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
								<select id="advanceField2"  class="filter_field field2 select-1" data-label="Search Field" name="advance[field]" id="">
                                                                    <option ></option>
                                                                    <option value="Artefact Description">Artefact Description</option>
										<option value="Artefact Make">Artefact Make</option>
										<option value="Artefact Model">Artefact Model</option>
										<option value="Artefact Serial number">Artefact Serial number</option>
										<option value="Artefact Contact">Artefact Contact</option>
										<option value="File number">File number</option>
										<option value="Artefact Owner">Artefact Owner</option>
										<option value="Report number">Report number</option>
										<option value="Test Officer">Test Officer</option>
										<option value="Services Offered">Services Offered</option>
										<option value="Special Conditions">Special Conditions</option>
										<option value="Quote number">Quote number</option>
								</select>
							</td>
                            <td valign="top" align="center">
								<?php echo \Helper_Form::seach_criteria2('advance[equality]', '', array('class' => 'field2 filter_field','id'=>'advanceEquality2', 'data-label' => 'Search Equality')); ?>
							</td>
                            <td valign="top" align="center">
								<input class="filter_field field2" id="criteria2Nd" type="" data-label="Search Criteria" name="advance[criteria]" style="text-align:center"/>
							</td>
                        </tr>
                    </table>
                </div>
                <div class="c1 advanceP">
                    <table class="advance_search table-1 advanceCriteria1P2" width="100%" id="job_advanced_search">
                        <tr>
                            <td width="30%" valign="top" align="center"><p>DATE CRITERIA 1</p></td>
                            <td width="30%" valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select id="3rdDate_crieteria" class="filter_field check3 select-1 select" data-label="Search Field" name="date_crieteria" id="">
										<option value="N/A">N/A</option>
										<option value="AND">AND</option>
										<option value="OR">OR</option>
								</select>
							</td>
                            <td valign="top" align="center"></td>
                            <td valign="top" align="center"></td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="center"><p>DATE FIELDS</p></td>
                            <td width="30%" valign="top" align="center"><p>FROM</p></td>
                            <td valign="top" align="center"><p>TO</p></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
								<select class="filter_field field3 select-1" data-label="Search Field" name="date[field]" id="dateField">
                                                                    <option ></option>
									<option value="Date of report">Date of report</option>
									<option value="Date report sent">Quotation date</option>
								</select>
							</td>
                            <td valign="top" align="center">
								<input type="text" id="criteria3Rd" class="field3 textbox-1 filter_field advanced_search datepicker" name="date[from]" style="text-align:center"/>
							</td>
                            <td valign="top" align="center">
								<input type="text" id="criteria4Th" class="field3 textbox-1 filter_field advanced_search datepicker" name="date[to]" style="text-align:center"/>
							</td>
                        </tr>
                    </table>
                </div>
                
                
            </div>
            
            <div class="box-2">
             <table cellpadding="0" width="50%" cellspacing="0" border="0" class="advance_search"><tr><td>
            	<div width="55%" class="leftside" id="checkBoxDiv" style="background-color:#FD8181" >
                	<p>'Intelligent' search on S/N:</p>
                   <input id="checkboxForIntelligent" type="checkbox" class="checkbox filter_field advanced_search checkBoxStl" name="Intelligent" value="yes" checked/>
                    <p id="switch" style="font-weight: bold" ><strong id="strong">ON</strong></p>
                </div>
                 </td></tr></table>
            	<div style="vertical-align:top;" class="rightside">
                	<div class="blk"><input id="advance_search" type="button" class="button1 " value="SEARCH" /></div>
                    <div class="blk"><input type="button" id="closeNewWindow" class="button2 " value="close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>

		
		
	</div>
</div>
<script>
  $(function() {
    $( "input[type=button],button" )
      .button()
      .click(function( event ) {
        event.preventDefault();
      });
  });
  </script>