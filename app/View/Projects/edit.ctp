<div class="projects form">
<?php echo $this->Form->create('Project'); ?>
	<fieldset>
		<legend><?php echo __('Edit Project'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('notes');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="alert alert-warning">
        <strong>Warning!</strong> There's currently a bug when editing the project name.  After this step you'll see a permissions error.  To correct that, also change the project name in the ACOS table.
      </div>
