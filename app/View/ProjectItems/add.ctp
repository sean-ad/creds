<div class="projectItems form">
<?php echo $this->Form->create('ProjectItem'); ?>
	<fieldset>
		<legend><?php echo __('Add Project Item'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('url');
		echo $this->Form->input('notes');
		echo $this->Form->input('project_id');
		echo $this->Form->input('created_at');
		echo $this->Form->input('updated_at');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Project Items'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>
