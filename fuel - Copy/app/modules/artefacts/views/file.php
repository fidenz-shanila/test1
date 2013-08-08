<div class="c2">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="70%"><h3>CB FILE: <?php echo $CF_FileNumber_pk ?></h3></td>
			 <td><div class="blk"><p>Open File:</p><input  type="button"  value="..."  id="btn_load_cb" /></div></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><textarea cols="" rows="" class="textarea-1" disabled="disabled"><?php echo $cb_file['CF_Title'] ?></textarea></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
$("#btn_load_cb").click(function(){
	 $.colorbox({ width: "90%", height: "500px", iframe: true, href: " <?php echo \Uri::create('files/list_quote_files?CF_FileNumber_pk=' . $cb_file['CF_FileNumber_pk']);?>" });
});

</script>