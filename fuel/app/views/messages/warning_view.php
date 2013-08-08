<div class="alert-message block-message warning" data-alert="alert">
  <a class="close" href="#">×</a>
  <p><strong>Ops!</strong></p>
  <ul>
   <?php
 	foreach($messages as $m): ?>
		<li><?php echo $m; ?></li>
   <?php endforeach; ?>
  </ul>

</div>