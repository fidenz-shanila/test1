
<?php echo $form->open(array('enctype' => 'multipart/form-data')); ?>

<div id="cb_file_upload">
        <table>
        <tr><td>
               <p>IMAGE PATH</p>
            </td></tr>
        <tr><td>
               <?php echo $form->build_field('image'); ?>
            </td>
            <td>
                <input type="submit" value="upload" >
            </td>
        </tr>
    </table>
	
	<?php echo $form->build_field('RD_YearSeq_pk'); ?>
	
</div>

<?php echo $form->close(); ?>




