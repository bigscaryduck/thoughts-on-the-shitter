<?php 
if (!empty($message)): 
	if (!is_array($message)) {
		$message = array($message);
	}
?>	
<div class="alert alert-danger">
	<ul>
		<?php foreach ($message as $item): ?>
		<li><?php echo !is_array($item) ? $item : 'Array to string conversion'; ?></li>
		<?php endforeach; ?>
	</ul>
</div>	
<?php endif; ?>