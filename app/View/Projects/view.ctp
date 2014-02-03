<div class="projects view">
<h2><?php echo h($project['Project']['name']); ?></h2>
</div>

<div class="related">
	<h3><?php echo __('Credentials:'); ?></h3>
	<?php if (!empty($project['ProjectItem'])): ?>
	<div class='row'>
		<div class="col-12">
			<table class='table table-bordered'>
				<tr>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Username'); ?></th>
					<th><?php echo __('Password'); ?></th>
					<th><?php echo __('Url'); ?></th>
					<th><?php echo __('Notes'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
				<?php foreach ($project['ProjectItem'] as $projectItem): ?>
					<tr>
						<td><?php echo $projectItem['name']; ?></td>
						<td><?php echo $projectItem['username']; ?></td>
						<td><?php echo $projectItem['password']; ?></td>
						<td><?php echo $projectItem['url']; ?></td>
						<td><?php echo $projectItem['notes']; ?></td>
						<td class="actions">
							<?php echo $this->Html->link(__('Details'), array('controller' => 'project_items', 'action' => 'view', $projectItem['id'])); ?>
							<?php if (AuthComponent::user('role') == 'admin') {?>
							<?php echo $this->Html->link(__('Edit'), array('controller' => 'project_items', 'action' => 'edit', $projectItem['id'])); ?>
							<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'project_items', 'action' => 'delete', $projectItem['id']), null, __('Are you sure you want to delete # %s?', $projectItem['id'])); ?>
							<?php } ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</table>
		</div>
	</div>
<?php endif; ?>

