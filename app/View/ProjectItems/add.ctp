<div class="projectItems form">
<?php echo $this->Form->create('ProjectItem'); ?>
	<fieldset>
		<legend><?php echo __($project['Project']['name'] . ': Add Credentials'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('username');
		echo $this->Form->input('password', array('after' => '<a id="PassGen">Generate</a><div id="PassGenResultHolder">The new password is <div id="PassGenResult" style="display:inline"></div></div>'));
		echo $this->Form->input('url');
		echo $this->Form->input('notes');
		echo $this->Form->input('project_id', array('type'=>'hidden', 'value'=>$project['Project']['id']));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
