<table class="datatable">
	<thead>
		<tr>
			<th></th>
			<th width="15%" id="col2"></th>
			<th width="15%"></th>
			<th width="48%%"></th>
			<th width="22%" id="col5"></th>
			
		</tr>
	</thead>
</table>
<!-- cb inline modals -->
<div id="dialog-form" style="display:none;" >
       <div id="advance_search_modal" >
	<div id="search_employee_listing"  style="width:580px;height:300px; background-color:#D7AEFF;">
		
		
    	
        <div class="content" >
        	
            <h1>SEARCH EMPLOYEE LISTING</h1>
			
			<div class="box-1">
            	<div class="row-1">
                	<div class="blk">
                        <table class="table-1 advance_search " width="100%" id="job_advanced_search">
                            <tr>
                                <td width="36%"><p>FIELD</p></td>
                                <td width="25%"><p>EQUALITY</p></td>
                                <td><p>CRITERIA</p></td>
                            </tr>
                            <tr>
                                <td align="center">
								<select class="filter_field check1 select-1 select" data-label="Search Field" id="fieldOne" name="field" style="text-align:center">
										<option value="Full name">Full name</option>
										<option value="First name">First name</option>
										<option value="Last name" selected="selected">Last name</option>
										<option value="Phone">Phone</option>
										<option value="Fax">Fax</option>
										<option value="Position descriptor">Position descriptor</option>
								</select>
								</td>
                                <td align="center">
										<?php echo \Helper_Form::seach_criteria('equality', 'LIKE', array('class' => 'filter_field','style'=>'text-align:center', 'data-label' => 'Search Equality','id'=>'field2Eq')); ?>
								</td>
                                <td align="center">
										<input  class="filter_field" type="text" data-label="Search Criteria" name="criteria" id="criteria1St" style="text-align:center"/>
								</td>
                            </tr>
                        </table>
                    </div>
                    <div class="blk">
                        <table class="advance_search " width="100%" id="">
                            <tr>
                                <td width="36%"><p>ADDITIONAL CRITERIA</p></td>
                                <td width="25%"></td>
                                <td></td>
                            </tr>
                            <tr >
                                <td align="center">
								<select class="filter_field check2 select-1 select" data-label="Search Field" name="field_crieteria_02" id="field_crieteria_02">
									<option value="N/A">N/A</option>
									<option value="AND">AND</option>
									<option value="OR">OR</option>
								</select>
								</td>
                                <td align="center"></td>
                                <td align="center"></td>
                            </tr>
                            <tr id="advanceCriteria" >
                                <td><p id="PField">FIELD</p></td>
                                <td><p id="PEquality">EQUALITY</p></td>
                                <td><p id="PCriteria">CRITERIA</p></td>
                            </tr>
                            <tr>
                                <td align="center">
								<select class="filter_field" data-label="Search Field" name="advance[field]" id="advance_field_2">
										<option ></option>
                                                                                <option value="Full name">Full name</option>
										<option value="First name">First name</option>
										<option value="Last name" >Last name</option>
										<option value="Phone">Phone</option>
										<option value="Fax">Fax</option>
										<option value="Position descriptor">Position descriptor</option>
								</select>
								</td>
                                <td align="center">
										<?php echo \Helper_Form::seach_criteria2('advance[equality]', '', array('class' => 'field2 filter_field','id'=>'advanceEquality2','style'=>'text-align:center' , 'data-label' => 'Search Equality','id'=>'2ndEq')); ?>
								</td>
                                <td align="center"><input class="filter_field field2" type="text" data-label="Search Criteria" name="advance[criteria]" id="criteria2nd" style="text-align:center"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            
            <div class="box-2">
            	<div class="rightside">
                	<div class=" blk"><input type="button" id="advance_search12" class="button1 " value="search" /></div>
                    <div class="blk"><input type="button" id="closeNewWindow" class="button2 " value="close" /></div>
                </div>
            </div>

        </div>
        
    </div>
	

		</div>
</div>		
			
			
 		
