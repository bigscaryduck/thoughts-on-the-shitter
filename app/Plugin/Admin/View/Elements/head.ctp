	<title><?php echo $title_for_layout; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<?php echo $this->Html->meta('icon'); ?>	
	<?php echo $this->fetch('meta'); ?>
	<?php echo $this->Html->css('bootstrap-3.0.min.css') . "\n"; ?>
	<?php echo $this->Html->css('redactor.css') . "\n"; ?>
	<?php echo $this->fetch('css') . "\n"; ?>
	<?php echo $this->Html->css('style.css') . "\n"; ?>
	<?php echo $this->Html->script('modernizr.custom.js') . "\n"; ?>
	
	<?php $this->prepend('before_body_end'); ?>
	<?php echo $this->Html->script('jquery-1.10.2.min.js') . "\n"; ?>
	<?php echo $this->Html->script('bootstrap-3.0.min.js') . "\n"; ?>
	<?php echo $this->Html->script('redactor.min.js') . "\n"; ?>
	<?php echo $this->Html->script('custom') . "\n"; ?>
	<?php echo $this->fetch('script'); ?>
	<?php $this->end(); ?>