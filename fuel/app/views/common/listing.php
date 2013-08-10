<div class="container listing_screen">
    <div id="content"  >
         <?php if(isset($topmenu)){?>
        <div id="module_top_menu" class="<?php echo $body_classes; ?>">
   
		<?php echo $topmenu; ?>
	
            </div>
         <?php } ?>
	
            <div id="grid_box">
		<?php echo $grid; ?>
            </div>
	</div><!-- content --> 
        <div id="filter" class="<?php echo $body_classes; ?>">
		<?php echo $sidebar; ?>
	</div><!-- sidebar -->
        <div>
	<div class="clear"></div>
</div>
</div><!-- container -->
<script src="app.js">
  $(function() {
    $( "input[type=button],button" )
      .button()
      .click(function( event ) {
        event.preventDefault();
      });
  });
  </script>			
		