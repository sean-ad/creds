<div class="projectItems index">
	<h2><?php echo __('Project Items'); ?></h2>
	<div class='row'>
		<div class="col-12">
			<table class='table table-bordered'>
			<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('username'); ?></th>
					<th><?php echo $this->Paginator->sort('password'); ?></th>
					<th><?php echo $this->Paginator->sort('url'); ?></th>
					<th><?php echo $this->Paginator->sort('notes'); ?></th>
					<th><?php echo $this->Paginator->sort('project_id'); ?></th>
					<th><?php echo $this->Paginator->sort('created_at'); ?></th>
					<th><?php echo $this->Paginator->sort('updated_at'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($projectItems as $projectItem): ?>
			<tr>
				<td><?php echo h($projectItem['ProjectItem']['id']); ?>&nbsp;</td>
				<td><?php echo h($projectItem['ProjectItem']['name']); ?>&nbsp;</td>
				<td><?php echo h($projectItem['ProjectItem']['username']); ?>&nbsp;</td>
				<td><?php echo h($projectItem['ProjectItem']['password']); ?>&nbsp;</td>
				<td><?php echo h($projectItem['ProjectItem']['url']); ?>&nbsp;</td>
				<td><?php echo h($projectItem['ProjectItem']['notes']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($projectItem['Project']['name'], array('controller' => 'projects', 'action' => 'view', $projectItem['Project']['id'])); ?>
				</td>
				<td><?php echo h($projectItem['ProjectItem']['created_at']); ?>&nbsp;</td>
				<td><?php echo h($projectItem['ProjectItem']['updated_at']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $projectItem['ProjectItem']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $projectItem['ProjectItem']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $projectItem['ProjectItem']['id']), null, __('Are you sure you want to delete # %s?', $projectItem['ProjectItem']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
			</table>
			<p>
			<?php
			echo $this->Paginator->counter(array(
			'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			));
			?>	</p>
			<div class="paging">
			<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
			</div>
		</div>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Project Item'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>
