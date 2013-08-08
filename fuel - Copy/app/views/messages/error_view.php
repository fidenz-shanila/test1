<div class="alert-message block-message error" data-alert="alert">
  <a class="close" href="#">×</a>
  <ul>
   <?php
 	foreach($messages as $m): ?>
		<li><?php echo $m; ?></li>
   <?php endforeach; ?>
  </ul>

</div>