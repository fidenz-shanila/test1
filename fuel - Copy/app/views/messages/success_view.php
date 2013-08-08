<div class="alert-message block-message success" data-alert="alert">
  <a class="close" href="#">×</a>
  <p><strong>Success!</strong></p>
  <ul>
   <?php
 	foreach($messages as $m): ?>
		<li><?php echo $m; ?></li>
   <?php endforeach; ?>
  </ul>

</div>