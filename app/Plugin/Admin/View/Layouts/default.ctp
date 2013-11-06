<?php

$this->assign('body_class', 'fluid-layout');


?><!DOCTYPE HTML>
<!--[if lt IE 7 ]><html class="ie6 no-js" lang="en-US" xmlns="http://www.w3.org/1999/xhtml"	><![endif]-->
<!--[if IE 7 ]><html class="ie7 no-js" lang="en-US" xmlns="http://www.w3.org/1999/xhtml"><![endif]-->
<!--[if IE 8 ]><html class="ie8 no-js" lang="en-US" xmlns="http://www.w3.org/1999/xhtml"><![endif]-->
<!--[if IE 9 ]><html class="ie9 no-js" lang="en-US" xmlns="http://www.w3.org/1999/xhtml"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" lang="en-US" xmlns="http://www.w3.org/1999/xhtml"><!--<![endif]-->
<head>
<?php echo $this->element('head'); ?>
</head>
<body<?php if ($body_class = $this->fetch('body_class')) echo ' class="'. $body_class .'"'; ?>>
<?php echo $this->fetch('after_body_start'); ?>
	<div id="container">
		<div class="push-wrap">
			<?php echo $this->fetch('push_menu'); ?>
			<div class="wrap">
				<div class="wrap-inner">
					<?php echo $this->element('header'); ?>
					<div class="main">
						<div class="container">
							<?php echo $this->Session->flash(); ?>
							<?php echo $this->fetch('content'); ?>
						</div>	
					</div>
				</div>
				<?php echo $this->element('footer'); ?>
			</div>
		</div>			
	</div>
	<?php echo $this->fetch('before_body_end'); ?>
	<?php echo $this->fetch('scriptBottom'); ?>
</body>
</html>