<?php echo $form->open(); ?>

    <div id="insertfile" style="background-color: #FFFFA6;height:100%;">
    	
        <div class="content" >
        	
            <h1>INSERT FILE</h1>
            
            
            <div class="box-1">
            	<div class="row-1">
            		<div class="blk1">
                    	<p>TYPE:</p>
                        <?php echo $form->build_field('type'); ?>
                    </div>
                    <div class="blk2">
                    	<input type="radio" class="radio" checked="checked" value="1" disabled/>
                        <p style="color:#C0C0C0">Syd</p>
                        <input type="radio" class="radio" value="2" disabled/>
                        <p style="color:#C0C0C0">Melb</p>
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
                                    <td width="14%"><p>SEQ:</p></td>
                                    <td width="18%"><?php echo $form->build_field('seq'); ?></td>
                                    <td align="center"><input type="button" class="button1" id="get_next" value="Get next available" /></td>
                                </tr>
                            </table>
                        </div>
                        <div class="r1_new">
                        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                            	<tr>
                                	<td width="30%" class="NotUnderLine"><p>FILE NUMBER:</p></td>
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
                	<div class="blk"><input type="submit" Id="submitInsertIId" class="button1" value="insert" style="width:120px" /></div>
                    <div class="blk"><input type="button" onClick="ClouseButton();"  class="button2 " value="cancel / close" style="width:120px"/></div>
                </div>
            </div>
            
        </div>
        
    </div>
<?php echo $form->close(); ?>


<script type="text/javascript">
    function ClouseButton(){
  
 parent.$('body').css('overflow','auto'); 
     parent.$('#InsertNewFile').dialog('close');
    }
        $('#submitInsertIId').click(function(e){
           
    if($('#year').val()> 1899 && $('#year').val()< 1912 && $('#seq').val()< 763 && $('#form_type').val()=='CB'){
        
    alert('Number out of range.');
        return false;
    }else{
           if($('#year').val().length!=0){
                
                    if(!isNaN($('#year').val())){
                        if($('#seq').val().length!=0){
                    
                        if(!isNaN($('#seq').val())){
                            
                        if($('#seq').val()< 0 || $('#seq').val()> 9999||$('#year').val()< 1900 ||$('#year').val()> 2025){
                             alert('Number out of range.');
                             return false;
                             e.stop();
                             }
                       
                                  if($('#form_title').val().length!=0){
                                      
                                  if($('#form_title').val().length<199){
               
           
               }else{
               alert('The Title is '+$('#form_title').val().length+' characters in length.  Please limt to 200 characters.');
              // e.stop();
               return false;
                }
               
           
               }else{
               alert('Please fill in the Title.');
              // e.stop();
               return false;
                }
           
           
              
           
           
               }else{
               alert('Invalid type of sequencial number');
               //e.stop();
               return false;
                }
                
                }else{
               alert('Please fill in the Sequential number.');
               //e.stop();
               return false;
                }
           
                
                 }else{
               alert('Invalid type of year.');
              // e.stop();
               return false;
                }
           
               
               }else{
               alert('Please fill in the Year.');
               //e.stop();
               return false;
           }
     if($('#seq').val()< 0 || $('#seq').val()> 9999||$('#year').val()< 1900||$('#year').val()> 2025){
                             alert('Number out of range.');
                             }
       //return false;
    }
        });
        
        
        $('#build_number').click(function(e){
           
     
           if($('#year').val().length!=0){
                if($('#seq').val().length!=0){
                    if(!isNaN($('#year').val())){
                    if(!isNaN($('#seq').val())){
                       if($('#seq').val()< 0 || $('#seq').val()> 9999||$('#year').val()< 1900||$('#year').val()> 2025){
                             alert('Number out of range.');
                            e.stop();
                             }else{
       
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
           }
           
           }else{
               alert('Invalid type of sequencial number.');
               return false;
                }
               }else{
               alert('Invalid type of year.');
              return false;
                }
           
               }else{
               alert('Please fill in the Sequential number.');
               return false;
                }
           
               }else{
               alert('Please fill in the Year.');
              return false;
           }
    
           
        });
        
        
     $('#year').click(function(){   
         if(isNaN($('#seq').val())){
              alert('Invalid type of sequencial number.');
              return false;
         }
        });
          $('#seq').click(function(){
              if(isNaN($('#year').val())){
              alert('Invalid type of year.');
              return false;
         }
        
        });
          $('#form_title').click(function(e){   
            if(isNaN($('#year').val())){
              alert('Invalid type of year.');
              return false;
         }
          if(isNaN($('#seq').val())){
              alert('Invalid type of sequencial number.');
              return false;
         }
        
        });
        
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
			
//				var type    = $('#form_type').val();
//				var seq     = $('#seq').val();
//				var year    = $('#year').val();
//				
//				$.ajax({
//					url : "<?php echo Uri::create('files/build_number'); ?>",
//					type: "GET",
//					data: { 'type' : type, 'seq' : seq, 'year' : year },
//					dataType: 'json',
//					success : function(callback){
//						$('#fill').val(callback.CF_FileNumber_pk);
//					}
//			});
		});
		
    });
    
</script>

