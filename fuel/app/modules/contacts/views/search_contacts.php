<div id="dialog-form_contacts" style="background-color:#BAC7FC;" >
       <div id="advance_search_modal" >
	<div id="search_contact_listing"  style="width:580px;height:300px; background-color:#BAC7FC;">
		
		
    	
        <div class="content"  >
        	
            <h1>SEARCH CONTACT LISTING</h1>
			
			<div class="box-1" style="background-color:#8FA5FA;">
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
								<?php echo \Form::select('field','Last name',array('Country'=>'Country','First name'=>'First name','Last name'=>'Last name','Phone'=>'Phone','Org. name'=>'Org. name','Org. web address'=>'Org. web address','Position'=>'Position'),array('data-label'=>"Search Field",'class'=>'filter_field basic_search'));?>
								</td>
                                <td align="center">
										 <?php echo \Helper_Form::seach_criteria('equality', 'LIKE', array('class'=>'filter_field basic_search', 'data-label' => 'Search Equality')); ?>
								</td>
                                <td align="center">
										<input   type="text" class="filter_field basic_search"  data-label="Search Criteria" id="ASCriteria_1" name="criteria" style="text-align:center"/>
								</td>
                            </tr>
                        </table>
                    </div>
                    <div class="blk">
                        <table class="advance_search " width="100%" id="">
                            <tr>
                                <td  wialign="center"dth="36%"><p>ADDITIONAL CRITERIA</p></td>
                                <td width="25%"></td>
                                <td></td>
                            </tr>
                            <tr >
                                <td align="center">
								<select class="filter_field" name="advance[add_criteria]" id="">
	                    <option value="N/A">N/A</option>
	                    <option value="AND">AND</option>
	                    <option value="OR">OR</option>
	                </select>
								</td>
                                <td align="center"></td>
                                <td align="center"></td>
                            </tr>
                            <tr id="advanceCriteria" >
                                <td align="center"><label id="aField" for=""><u>FIELD</u></label></td>
                                <td align="center"><label id="aEquality" for=""><u>EQUALITY</u></label></td>
                                <td align="center"><label id="aCriteria" for=""><u>CRITERIA</u></label></td>
                            </tr>
                            <tr>
                                <td align="center">
								 <?php
	                    $opts = array('','Country', 'First name', 'Last name', 'Phone','Org. name', 'Org. web address', 'Position');
	                    echo \Form::select('advance[field]', '', array_combine($opts, $opts), array('class'=>'filter_field advance_search', 'data-label' => 'Field'));
	                ?>
								</td>
                                <td align="center">
										<?php echo \Helper_Form::seach_criteria2('advance[equality]', '', array('class'=>'filter_field advance_search', 'data-label' => 'Equality')); ?>
								</td>
                                <td align="center"><input type="text" name="advance[criteria]" class="filter_field advance_search"  id="ASCriteria_2" data-label="Criteria" style="text-align:center" /></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            
            <div class="box-2">
            	<div class="rightside">
                	<div class=" blk"><input type="button" id="advance_search" style="color:red; font-weight:bold;" value="SEARCH" /></div>
                    <div class="blk"><input type="button" id="advance_search1" class="button2 " value="close" /></div>
                </div>
            </div>

        </div>
        
    </div>
	

		</div>
</div>		
		

<script type="text/javascript">
    function closeWendow(){
      $('#ASCriteria_1').val(''); 
      $('#ASCriteria_2').val('');
      document.getElementsByName("advance[add_criteria]")[0].selectedIndex=0;
      document.getElementsByName("advance[field]")[0].selectedIndex=0;
      document.getElementsByName("advance[equality]")[0].selectedIndex=0;
      $('*[name="advance[field]"]').attr('disabled','disabled');
      $('*[name="advance[equality]"]').attr('disabled','disabled');
      $('input[name="advance[criteria]"]').attr('readonly','readonly');
     // $('input[name="field"]').attr('selected','selected');
      $('#aField').css("color",'#B8B8B8');
      $('#aEquality').css("color",'#B8B8B8');
      $('#aCriteria').css("color",'#B8B8B8');
      parent.$.colorbox.close();
    }
    
    
    
    </script>
