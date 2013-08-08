<?php echo $form->open(array('enctype' => 'multipart/form-data')); ?>

<div id="cb_file_upload">
	<?php echo $form->build_field('image'); ?>
	<?php echo $form->build_field('CF_FileNumber_pk'); ?>
	<?php echo $form->build_field('path'); ?>
	<input type="submit" value="upload" >
</div>

<?php echo $form->close(); ?>
