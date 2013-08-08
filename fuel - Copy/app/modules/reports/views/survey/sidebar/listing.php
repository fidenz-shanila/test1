<h1>Contact Survey Listing</h1>
<form action="" id="contacts_listing_filter" class="grid_filter">
    <table  class="filter_table">
        <tr>
                <?php
                echo \Form::select('by_letter', '', array_combine(range('A', 'Z'), range('A', 'Z')), array('class' => 'filter_field'));
                ?>
        </tr>

        <tr class="sr">
            <td>
                <label for="">Owner</label>
                <?php echo \Form::select('csr_organsiation', '',array(), array('class' => 'filter_field')); ?>
                <?php echo \Helper_Form::clear_select('csr_organsiation'); ?>
            </td>
            <td>
                <label for="">Returned By:</label>
                <?php echo \Form::select('csr_returned_by', '',array(), array('class' => 'filter_field')); ?>
                <?php echo \Helper_Form::clear_select('csr_returned_by'); ?>
            </td>

        </tr>


        <tr class="sr">
            <td>
                <label for="">Survey Version:</label>
                <?php echo \Form::select('csr_survey_version', '',array(), array('class' => 'filter_field')); ?>
                <?php echo \Helper_Form::clear_select('csr_survey_version'); ?>
            </td>
            <td>
                <label for="">Sect:</label>
                <?php echo \Form::select('csr_sections', '',array(), array('class' => 'filter_field')); ?>
                <?php echo \Helper_Form::clear_select('csr_sections'); ?>
            </td>
        </tr>
        
         <tr class="sr">
            <td>
                <label for="">Proj:</label>
                <?php echo \Form::select('csr_projects', '',array(), array('class' => 'filter_field')); ?>
                <?php echo \Helper_Form::clear_select('csr_projects'); ?>
            </td>
            <td>
                <label for="">Area:</label>
                <?php echo \Form::select('csr_get_areas', '',array(), array('class' => 'filter_field')); ?>
                <?php echo \Helper_Form::clear_select('csr_get_areas'); ?>
            </td>
        </tr> 

        <tr class="tr" >
            <td colspan="">
                <label>Outcome:</label>
                <?php 
                $option = array('ALL Returned'=>'ALL Returne','Returned - No action required'=>'Returned - No action required','Returned - Correction action required'=>'Returned - Correction action required','Returned - with comments'=>'Returned - with comments','ALL - Not returned'=>'ALL - Not returned','Not Returned - No respons'=>'Not Returned - No respons');
                echo \Form::select('csr_Outcome', '', $option, array('class' => 'filter_field')); ?>
                <?php echo \Helper_Form::clear_select('csr_Outcome'); ?>
            </td>

            <td> 
                <label for="">Serveys Sent</label>
                <table>
                    <tr><td>FROM :<input type="text" class="datepicker"></td><td>TO :<input type="text" class="datepicker"></td></tr>
                </table>
            </td>
        </tr>


    </table>

</form>

<form action="" class="" method="post">
    <div class="export_to_excel">
        <?php echo \Form::select('export_to_excel_limit', null, array('ALL' => 'ALL', 50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000, 5000 => 5000, 10000 => 10000));?>
        <input type="submit" name="export_to_excel" class="spaced" value="Export to Excel" />
    </div>
</form>

<div class="actions" >
    <button  href="#advance_search_modal" class="cb spaced inline">Search</button>
</div>


    
