<div class="alert-message block-message info" data-alert="alert">
  <a class="close" href="#">×</a>
  <p><strong>Info!</strong></p>
  <ul>
   <?php
 	foreach($messages as $m): ?>
		<li><?php echo $m; ?></li>
   <?php endforeach; ?>
  </ul>

</div>