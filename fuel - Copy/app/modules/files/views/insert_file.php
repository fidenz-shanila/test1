<?php echo $form->open(); ?>

    <div id="insertfile">
    	
        <div class="content">
        	
            <h1>INSERT FILE</h1>
            
            
            <div class="box-1">
            	<div class="row-1">
            		<div class="blk1">
                    	<p>TYPE:</p>
                        <?php echo $form->build_field('type'); ?>
                    </div>
                    <div class="blk2">
                    	<?php echo $form->build_field('optsite'); ?>
                        <!--<p>Syd</p>
                        <input type="radio" class="radio" />
                        <p>Melb</p>-->
                    </div>
                </div>
                
                <div class="row-2">
                	<div class="blk1">
                    	<p>BUILD FILE NUMBER</p>
                        <div class="r1">
                        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                    <td width="18%"><p>YEAR:</p></td>
                                    <td width="18%"><?php echo $form->build_field('year'); ?></td>
                                    <td width="18%"><p>SEQ:</p></td>
                                    <td width="18%"><?php echo $form->build_field('seq'); ?></td>
                                    <td align="center"><input type="button" class="button1" id="get_next" value="Get next available" /></td>
                                </tr>
                            </table>
                        </div>
                        <div class="r1">
                        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td width="30%"><p>FILE NUMBER:</p></td>
                                    <td width="42%"><?php echo $form->build_field('fill_number'); ?></td>
                                    <td align="center"><input type="button" id="build_number" class="button1" value="Build" /></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="row-3">
                	<div class="blk1">
	                	<p>TITLE</p>
                        <?php echo $form->build_field('title'); ?>
                    </div>
                </div>
                
            </div>
            
            <div class="box-2">
            	<div class="rightside">
                	<div class="blk"><input type="submit" class="button1" value="insert"  /></div>
                    <div class="blk"><input type="button" href="<?php echo \Uri::create('files'); ?>" class="button2 cb iframe close" value="cancel / close" /></div>
                </div>
            </div>
            
        </div>
        
    </div>
<?php echo $form->close(); ?>


<script type="text/javascript">
    $(document).ready(function(){
	
		$('#get_next').on('click', function(){
			
			var type    = $('#form_type').val();
			var optsite = $('.optsite:checked').val();
			
			if(type ==''){
				alert('Please select a type');
				return false;
			}
			
				$.ajax({
				url : "<?php echo Uri::create('files/get_next'); ?>",
				type: "GET",
				data: { 'type' : type, 'optsite' : optsite },
				dataType: 'json',
				success : function(callback){
					$('#year').val(callback.Next_Year);
					$('#seq').val(callback.Next_Seq);
					$('#fill').val(callback.CF_FileNumber_pk);
				}
			});
		});
		
		$('#build_number').on('click', function(){
			
				var type    = $('#form_type').val();
				var seq     = $('#seq').val();
				var year    = $('#year').val();
				
				$.ajax({
					url : "<?php echo Uri::create('files/build_number'); ?>",
					type: "GET",
					data: { 'type' : type, 'seq' : seq, 'year' : year },
					dataType: 'json',
					success : function(callback){
						$('#fill').val(callback.CF_FileNumber_pk);
					}
			});
		});
		
    });
</script>

