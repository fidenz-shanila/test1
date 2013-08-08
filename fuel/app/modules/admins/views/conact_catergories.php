<?php echo \Asset::js(array('editinplace.js')); ?>

<script type="text/javascript">

$(document).ready(function() {
	$(".editable_category").editInPlace({ // edit in place initialize
		url: "<?php echo \Uri::create('admins/update_conact_catergory'); ?>",
		params: "field=COC_Name" // parameters to be send on change
	});
});

</script>

<div id="contact_cat">
	
	<h1>Contact Categories</h1>
	
	<table id="contact_cat_edit">
		<thead>
			<th>Number</th>
			<th>Category Name</th>
		</thead>
		<tbody>
		<?php foreach($sort_order as $sort_order_item) { ?>
			<tr>
				<td><?php echo $sort_order_item['COC_Code_ind']; ?></td>
				<td><div id="<?php echo $sort_order_item['COC_Code_ind']; ?>" class="inline_editable editable_category"><?php echo $sort_order_item['COC_Name']; ?></div></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<div id="control">
	<button href="<?php echo \Uri::create('admins/insert_conact_catergories'); ?>" class="btn spaced">Insert Category</button>
	<button class="btn spaced cb iframe close">Close</button>
	</div>
</div>