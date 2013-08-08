<?php echo \Asset::js('carousel.js'); ?>
<script type="text/javascript">

    $(window).load(function(){ 
        $('#tabs .content div.tabcon').hide();
        $('#tabs .content div.tabcon:first').fadeIn(500);
        
        $('#tabs div.tabsmenu ul.tabs li:first-child').addClass('active');

        $('#tabs div.tabsmenu ul.tabs li a').click(function(){ 

            $('#tabs div.tabsmenu ul.tabs li').removeClass('active');
            $(this).parent().addClass('active'); 
            var currentTab = $(this).attr('href'); 
            $('#tabs .content div.tabcon').hide();
            $(currentTab).fadeIn(500);

            return false;
            
        });

        //lock quote
        $('#lock_quote input').click(function(){
            $(this).closest('form').append('<input type="hidden" name="save" value="1" /><input type="hidden" name="lock" value="1" />').submit();
        });
        
        $('#requestMail input').click(function(){ 
            $(this).closest('form').append('<input type="hidden" name="save" value="1" /><input type="hidden" name="lock" value="1" />').submit();
        });
        
        //Job form lock
        $('#job_lock input').click(function(){ 
            $(this).closest('form').append('<input type="hidden" name="save" value="1" /><input type="hidden" name="lock" value="3" />').submit();
        });
        

        
        

          <?php
            if(\Input::get('tab'))
            {
                $index = (int) \Input::get('tab') - 1;
                echo "$('#tabs div.tabsmenu ul.tabs li').eq({$index}).find('a').click();";
            }
        ?>
    });
</script>
<form action="" method="POST">
 <div id="contact_un">
        
        <div class="content">
            
            <div class="part-1">
                
                <div class="box-1">
                   <?php echo $subforms['artefact_description']; ?>
                    
                </div>
                
                <div class="box-2">
                     <?php echo $subforms['artefact_owner']; ?>
                     <?php echo $subforms['artefact_file']; ?>
                </div>
                
                <div class="box-3">
                     <?php echo $subforms['artefact_work']; ?>
                </div>
                
            </div>
            
            
            <!--div class="part-menu">
                <ul>
                    <li><a href="#" class="active">quote</a></li>
                    <li><a href="#">receipt and despatch</a></li>
                    <li><a href="#">attached information</a></li>
                </ul>
            </div-->
            
            
            
            <div id="tabs">
                <div class="tabsmenu">
                    <ul class="tabs">
                        <li><a href="#tab1">Quote</a></li>
                        <li><a href="#tab2">Receipt &amp; Despatch</a></li>
                        <?php 
                            if($subforms['job_tab']) 
                            {
                                echo '<li><a href="#tab3">Job &amp; Report</a></li>'; 
                                echo '<li><a href="#tab4">Invoicing</a></li>';
                            }    
                        ?>
                        
                        <li><a href="#tab5">Attached Info</a></li>
                    </ul>
                </div>
                <div class="content">
                    
                    <!-- ------------------------------------------------------------------------------------- -->
                    <!-- TAB 1 START -->
                    <!-- ------------------------------------------------------------------------------------- -->
                    <div id="tab1" class="tabcon">
                        <?php echo $subforms['quote_tab']; ?>
                    </div>
                    
                    
                    <!-- ------------------------------------------------------------------------------------- -->
                    <!-- TAB 2 START -->
                    <!-- ------------------------------------------------------------------------------------- -->
                    <div id="tab2" class="tabcon">
                         <?php echo $subforms['receipt_tab']; ?>
                    </div>
                    
                    
                    <!-- ------------------------------------------------------------------------------------- -->
                    <!-- TAB 3 START -->
                    <!-- ------------------------------------------------------------------------------------- -->
                    <?php if($subforms['job_tab']) : ?>
                    <div id="tab3" class="tabcon">
                        <?php echo $subforms['job_tab']; ?>
                    </div><!-- job tab -->
                    <?php endif; ?>
                    
                    
                    <!-- ------------------------------------------------------------------------------------- -->
                    <!-- TAB 4 START -->
                    <!-- ------------------------------------------------------------------------------------- -->
                    <?php if($subforms['job_tab']) : ?>
                    <div id="tab4" class="tabcon">
                        <?php echo $subforms['invoice_tab']; ?>
                    </div><!-- job tab -->
                    <?php endif; ?>
                    
                    <!-- ------------------------------------------------------------------------------------- -->
                    <!-- TAB 5 START -->
                    <!-- ------------------------------------------------------------------------------------- -->
                    <div id="tab5" class="tabcon">
                        <?php echo $subforms['attached_tab']; ?>
                    </div>
                    
                    
                </div>
            
                <div class="clearboth"></div>
            </div>
            
            
            
            
            
        </div>
        
    </div>
    <?php
        echo \Form::hidden('active_tab', (int)\Input::get('tab'));
        echo \Form::hidden('quote_id', \Input::get('quote_id'));
    ?>
</form>