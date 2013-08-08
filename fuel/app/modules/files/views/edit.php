<?php echo $form->open(); ?>


    
<div id="edit-file">
    
    <h1>CB File : <?php echo $CF_FileNumber_pk; ?> CONTENTS</h1>
    <h3>FILE TITLE (an in TRIM)</h3>
    
    <?php echo $form->build_field('title'); ?>
    
    <div id="location">
        <div id="c_loc">
            <h3>CURRENT LOCATION</h3>
            <?php echo $form->build_field('current_location'); ?><br/>
            <p>Date at Location</p>
            <?php echo $form->build_field('cl_date_at_location'); ?>
        </div>
        <div id="r_loc">
            <h3>REQUESTED LOCATION</h3>
            <?php echo $form->build_field('requested_location'); ?><br/>
            <label>Date at Location</label>
            <?php echo $form->build_field('rl_date_at_location'); ?>
        </div>
        <button href="">Change</button>
        
        <div class="clear"></div>
    </div>
    
    <div id="file_listing">
        <h2>CB FILE CONTENT LISTING (ie.. Related Records)</h2>
        
        <table>
            <tr>
                <td>QUOTE NUMBER</td>
                <td>OWNER</td>
            </tr>
        </table>
        
        <table>
            
            <?php foreach ($cb_file_content as $cb_file) { ?>
                <tr>
                    <td><button>..</button></td>
                    <td><input  type="text" value="<?php echo $cb_file['Q_FullNumber']; ?>"/></td>
                    <td><input id="owner_text" type="text" value="<?php echo $cb_file['A_Description']; ?>"/></td>
                </tr>
            <?php } ?>
            
            
            <tr>
                <td colspan=3><input type="text" id="des"/></td>
            </tr>
            
        </table>
        
        <div id="path">
        <label>Directory Path</label><input type="text" /><button>..</button><button href="<?php echo \Uri::create('Files/create_folder?CF_FileNumber_pk='.$CF_FileNumber_pk.'&CF_Year='.$CF_Year); ?>">Create</button>
        </div>
        <br/>
        <button>Close</button>
    </div>
</div>
</div>

<?php echo $form->close(); ?>
