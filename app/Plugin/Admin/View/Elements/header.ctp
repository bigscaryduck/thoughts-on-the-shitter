<header id="header">
	<div class="header-bar">
		<div class="container">
			<ul class="pull-right">
				<li><a href="<?php echo $this->Html->url('/admin/'); ?>"><span class="glyphicon glyphicon-user"></span><?php echo __('My Account'); ?></a></li>
				<li><a class="logout" href="<?php echo $this->Html->url('/logout'); ?>"><span class="glyphicon glyphicon-share-alt"></span><?php echo __('Log Out'); ?></a></li>
			</ul>		
		</div>
	</div>
	<div class="header-top">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="logo">
						<a href="">
							<strong>P<span>i</span>nk</strong>
							<?php echo __('Administration'); ?>
						</a>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<nav class="header-navbar navbar navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-toggle-wrap">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".header-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>	
			<div class="collapse navbar-collapse header-navbar-collapse">		
				<ul class="nav navbar-nav">
					<li>
						<a href="<?php echo $this->Html->url('/admin'); ?>">
							<span class="hidden-xs glyphicon glyphicon-home"></span>
							<span class="visible-xs"><?php echo __('Dashboard'); ?></span>
						</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Users'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Members', array('controller' => 'members', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link('Merchants', array('controller' => 'merchants', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link('Marketers', array('controller' => 'marketers', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link('Charities', array('controller' => 'charities', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link('Administrators', array('controller' => 'administrators', 'action' => 'index')); ?></li>
						</ul>
					</li>					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Catalog'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Products', array('controller' => 'products', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link('Product Categories', array('controller' => 'product_categories', 'action' => 'index')); ?></li>
						</ul>
					</li>					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Sales'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Orders', array('controller' => 'orders', 'action' => 'index')); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Blog'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link('Posts', array('controller' => 'blog_posts', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link('Categories', array('controller' => 'blog_post_categories', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link('Tags', array('controller' => 'blog_post_tags', 'action' => 'index')); ?></li>
							<li><?php echo $this->Html->link('Settings', array('controller' => 'blog_settings', 'action' => 'index')); ?></li>
						</ul>
					</li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Pages'); ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('List', array('controller' => 'pages', 'action' => 'index')); ?></li>
                            <li><?php echo $this->Html->link('Add', array('controller' => 'pages', 'action' => 'add')); ?></li>
                        </ul>
                    </li>

				</ul>
			</div>	
		</div>
	</nav>		
</header>	