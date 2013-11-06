
<?php echo $this->Html->link(__('Add User'), array('action' => 'add'), array('class' => 'btn btn-primary btn-block visible-xs push-bottom')); ?>

<?php echo $this->Form->create(false, array('type' => 'GET', 'class' => 'panel panel-default')); ?>
	<div class="panel-heading clearfix">
		<h1 class="pull-left"><?php echo __('Users'); ?></h1>
		<div class="btn-group pull-right hidden-xs">
			<?php echo $this->Html->link(__('Add User'), array('action' => 'add'), array('class' => 'btn btn-primary')); ?> 
		</div>
	</div>
	<table class="table">
		<thead>			
		<?php 
		
		echo $this->Html->tableHeaders(array(
			array($this->Paginator->sort('User.id', __('ID'))                 => array('class' => 'primary')),
			array($this->Paginator->sort('User.name', __('Name'))             => array('class' => 'visible-xs')),
			array($this->Paginator->sort('User.first_name', __('First Name')) => array('class' => 'hidden-xs')),
			array($this->Paginator->sort('User.last_name', __('Last Name'))   => array('class' => 'hidden-xs')),
			array($this->Paginator->sort('User.email', __('Email'))           => array('class' => 'hidden-xs')),
			array($this->Paginator->sort('Role.name', __('Role'))             => array('class' => 'hidden-xs')),
			array($this->Paginator->sort('User.created', __('Date Joined'))   => array('class' => 'hidden-xs')),
			'',
		)); 
		echo $this->Html->tableFilters(array(
			'User.id'         => array('type' => 'text', 'class' => 'primary'),
			'User.name'       => array('type' => 'text', 'class' => 'visible-xs'),
			'User.first_name' => array('type' => 'text', 'class' => 'hidden-xs'),
			'User.last_name'  => array('type' => 'text', 'class' => 'hidden-xs'),
			'User.email'      => array('type' => 'text', 'class' => 'hidden-xs'),
			'Role.id'         => array('type' => 'select', 'class' => 'hidden-xs', 'options' => $roles, 'empty' => __('Select Role'),),
			'User.created'    => array('type' => 'date', 'class' => 'hidden-xs')
		));
		
		?>
		</thead>
		<tbody>
		<?php if (!empty($users)): foreach ($users as $user): ?>
			<tr>
				<td class="primary"><?php echo $user['User']['id']; ?></td>
				<td class="visible-xs"><?php echo $user['User']['name']; ?></td>
				<td class="hidden-xs"><?php echo $user['User']['first_name']; ?></td>
				<td class="hidden-xs"><?php echo $user['User']['last_name']; ?></td>
				<td class="hidden-xs"><?php echo $user['User']['email']; ?></td>
				<td class="hidden-xs"><?php echo $user['Role']['name']; ?></td>
				<td class="hidden-xs"><?php echo $this->Time->nice($user['User']['created']); ?></td>		
				<td class="actions">	
					<div class="btn-group pull-right">
						<a class="btn btn-default btn-small" data-toggle="dropdown" href="#">
							<span class="glyphicon glyphicon-cog"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo $this->Html->url(array('action' => 'view', $user['User']['id'])); ?>">
									<span class="glyphicon glyphicon-list-alt"></span>
									<?php echo __('View User'); ?>
								</a>
							</li>
							<li>
								<a href="<?php echo $this->Html->url(array('action' => 'edit', $user['User']['id'])); ?>">
									<span class="glyphicon glyphicon-pencil"></span>
									<?php echo __('Edit User'); ?>
								</a>
							</li>
							<li>
								<a href="<?php echo $this->Html->url(array('action' => 'delete', $user['User']['id'])); ?>" onclick="return confirm('Are you sure you wish to delete this user?');">
									<span class="glyphicon glyphicon-trash"></span>
									<?php echo __('Delete User'); ?>
								</a>
							</li>																										
						</ul>
					</div>	
				</td>
			</tr>	
		<?php endforeach; else: ?>
			<tr><td colspan="99"><p class="no-results"><?php echo __('No users found.'); ?></p></td></tr>		
		<?php endif; ?>
		</tbody>	
	</table>
<?php echo $this->Form->end(); ?>
<?php echo $this->element('pagination'); ?>