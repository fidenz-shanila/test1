<?php echo \Asset::js(array('editinplace.js')); ?>

<script type="text/javascript">

$(document).ready(function() {
	$(".editable_category").editInPlace({ // edit in place initialize
		url: "<?php echo \Uri::create('admins/update_organisation_catergory'); ?>",
		params: "field=ORGC_Name" // parameters to be send on change
	});
});

</script>

<h1>ORGANISATION CATEGORIES</h1>

<table>
	<thead>
		<th>Number</th>
		<th>Category Name</th>
	</thead>
	<tbody>
    	<?php foreach($sort_order as $sort_order_item) { ?>
		<tr>
			<td><?php echo $sort_order_item['ORGC_Code_ind']; ?></td>
			<td><div id="<?php echo $sort_order_item['ORGC_Code_ind']; ?>" class="inline_editable editable_category"><?php echo $sort_order_item['ORGC_Name']; ?></div></td>
		</tr>
        <?php } ?>
	</tbody>
</table>
<button href="<?php echo \Uri::create('admins/insert_organisation_cats'); ?>" class="spaced">Insert Category</button>
<button class="spaced cb iframe close">Close</button>