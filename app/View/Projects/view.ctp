<?php
$breadcrumb = array(
	array(
		'label' => 'Projects',
		'link'	=> '/projects/index'
	),
	array(
		'label'	=> $project['Project']['name']
	)
);
echo $this->element('breadcrumb',array('links' => $breadcrumb));
?>

<h3><?php echo h($project['Project']['name']); ?></h3>
<hr>

<div class="related">
	<h4><?php echo __('Credentials:'); ?></h4>
	<?php if (!empty($project['ProjectItem'])): ?>
	<div class='row'>
		<div class="col-12">
			<table class='table table-bordered'>
				<tr>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Username'); ?></th>
					<th><?php echo __('Password'); ?></th>
					<th><?php echo __('Url/Server'); ?></th>
					<th><?php echo __('Details'); ?></th>
					<?php if (AuthComponent::user('role') == 'admin') {?>
						<th class="actions"><?php echo __('Actions'); ?></th>
					<?php } ?>
				</tr>
				<?php foreach ($project['ProjectItem'] as $projectItem): ?>
					<tr>
						<td><?php echo $projectItem['name']; ?></td>
						<td><?php echo $projectItem['username']; ?></td>
						<td><?php echo $projectItem['password']; ?></td>
						<td><?php echo $projectItem['url']; ?></td>
						<td><?php if (!empty($projectItem['notes'])): ?><?php echo $this->Html->link(__('Note'), array('controller' => 'project_items', 'action' => 'view', $projectItem['id'])); ?><?php endif; ?></td>
						<?php if (AuthComponent::user('role') == 'admin') {?>
							<td class="actions">
								<?php //echo $this->Html->link(__('Details'), array('controller' => 'project_items', 'action' => 'view', $projectItem['id'])); ?>
								<?php echo $this->Html->link(__('Edit'), array('controller' => 'project_items', 'action' => 'edit', $projectItem['id'])); ?>
								<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'project_items', 'action' => 'delete', $projectItem['id']), null, __('Are you sure you want to delete # %s?', $projectItem['id'])); ?>
							</td>
						<?php } ?>
					</tr>
				<?php endforeach; ?>
				</table>
		</div>
	</div>
<?php endif; ?>

<?php if (!empty($project['Project']['notes'])): ?>
<div class="projects view">
<h4>Notes:</h4>
<?php echo $project['Project']['notes']; ?>
</div>
<?php endif; ?>

