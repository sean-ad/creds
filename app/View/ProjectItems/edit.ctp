<div class="projectItems form">
<?php echo $this->Form->create('ProjectItem'); ?>
	<fieldset>
		<legend><?php echo __('Edit Credentials:'); ?></legend>
		<?php //debug($data['ProjectItem']);?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('username');
		echo $this->Form->input('password', array('after' => '<a id="PassGen">Generate</a><div id="PassGenResultHolder">The new password will be <div id="PassGenResult" style="display:inline"></div><br />Click Submit to save it</div>'));
		echo $this->Form->input('url');
		echo $this->Form->input('notes');
		echo $this->Form->input('project_id', array('type'=>'hidden'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
