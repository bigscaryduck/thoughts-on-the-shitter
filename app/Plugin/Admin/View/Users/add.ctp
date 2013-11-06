<?php echo $this->Form->create(false, array('class' => 'panel panel-default form-horizontal')); ?>
	<div class="panel-heading clearfix">
		<h1><?php echo __('New User'); ?></h1>
	</div>
	<div class="panel-body">
		<?php 
		echo $this->Form->input('User.first_name');
		echo $this->Form->input('User.last_name');
		echo $this->Form->input('User.email');
		echo $this->Form->input('User.pwd', array('label' => __('Password')));
		echo $this->Form->input('User.pwd_confirm', array('label' => __('Re-Enter Password')));			
		echo $this->Form->input('User.role_id', array('label' => __('Role'), 'options' => $roles, 'empty' => __('Select Role')));
		echo $this->Form->input('User.active', array('label' => __('Status'), 'options' => array(0 => 'Inactive', 1 => 'Active')));	
		?>
	</div>
	<div class="panel-footer form-actions">
		<?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
	</div>	
<?php echo $this->Form->end(); ?>