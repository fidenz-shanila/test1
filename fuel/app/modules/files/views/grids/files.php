<table class="datatable">
	<thead>
		<tr>
			<th width="3%" id="ButtonFile"></th>
			<th width="10%" id="col2"></th>
                        <th width="3%"></th>
			<th width="71%" id="col4"></th>
			<th width="10%" id="col5"></th>
                        <th width="3%"></th>
		</tr>
	</thead>
</table>

<!-- cb inline modals -->
<div id="dialog-form" style="display:none;" >
       <div id="advance_search_modal" >
	<div id="searchforfile"  style="width:590px;height:350px;background-color: #ffffb0;">
		
		
    	
        <div class="content" >
        	
            <h1>SEARCH FOR FILE(S)</h1>
			
			<div class="box-1">
            	<div class="row-1">
                	<div class="blk">
                        <table class="table-1 advance_search" width="100%" id="job_advanced_search">
                            <tr>
                                <td width="36%"><p>FIELD</p></td>
                                <td width="25%"><p>EQUALITY</p></td>
                                <td><p>CRITERIA</p></td>
                            </tr>
                            <tr>
                                <td align="center">
								<select class="filter_field check1 select-1 select" data-label="Search Field" id="fieldOne" name="field" style="text-align:center">
										<option value="File location">File location</option>
										<option value="File number">File number</option>
										<option value="File title" selected="selected">File title</option>
								</select>
								</td>
                                <td align="center">
										<?php echo \Helper_Form::seach_criteria('equality', 'LIKE', array('class' => 'filter_field','style'=>'text-align:center', 'data-label' => 'Search Equality')); ?>
								</td>
                                <td align="center">
										<input  class="filter_field" type="text" data-label="Search Criteria" name="criteria" id="criteria1St" style="text-align:center"/>
								</td>
                            </tr>
                        </table>
                    </div>
                    <div class="blk">
                        <table class="advance_search" width="100%" id="">
                            <tr>
                                <td width="36%"><p>ADDITIONAL CRITERIA</p></td>
                                <td width="25%"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td align="center">
								<select class="filter_field check2 select-1 select" data-label="Search Field" name="field_crieteria_02" id="field_crieteria_02" style="text-align:center">
									<option value="N/A">N/A</option>
									<option value="AND">AND</option>
									<option value="OR">OR</option>
								</select>
								</td>
                                <td align="center"></td>
                                <td align="center"></td>
                            </tr>
                            <tr id="advanceCriteria">
                                <td><p>FIELD</p></td>
                                <td><p>EQUALITY</p></td>
                                <td><p>CRITERIA</p></td>
                            </tr>
                            <tr>
                                <td align="center">
								<select class="filter_field field2 select-1" data-label="Search Field" name="advance[field]" id="advance_field_2" style="text-align:center">
                                                                                <option ></option>    		
                                                                                <option value="File location">File location</option>
										<option value="File number">File number</option>
										<option value="File title">File title</option>
								</select>
								</td>
                                <td align="center">
										<?php echo \Helper_Form::seach_criteria2('advance[equality]', '', array('class' => 'field2 filter_field','id'=>'advanceEquality2','style'=>'text-align:center' , 'data-label' => 'Search Equality')); ?>
								</td>
                                <td align="center"><input class="filter_field field2" type="text" data-label="Search Criteria" name="advance[criteria]" id="criteria2nd" style="text-align:center"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            
            <div class="box-2">
            	<div class="rightside">
                	<div class=" blk"><input type="button" id="advance_search12" class="button1" value="search" /></div>
                    <div class="blk"><input type="button" id="closeNewWindow" class="button2" value="close" /></div>
                </div>
            </div>

        </div>
        
    </div>
	

		</div>
</div>	
<style>
    text-align:center
    </style>
   