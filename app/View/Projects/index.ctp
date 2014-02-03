<div class="row">
  <div class="col-lg-10"><h3><?php echo __('Projects')?></h3></div>
  <div class="col-lg-2">
    <?php echo $this->Html->link(__('Add Project'),'/projects/add',array('class' => 'btn btn-default pull-right','style' => 'margin-top: 15px')) ?>
  </div>
</div>

<div class="row">

	<div class="col-12">
		<?php echo $this->Session->flash() ?>

    <hr>
			<table class='table table-bordered'>
			<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($projects as $project): ?>
			<tr>
				<td><?php echo h($project['Project']['id']); ?>&nbsp;</td>
				<td><?php echo h($project['Project']['name']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $project['Project']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $project['Project']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $project['Project']['id']), null, __('Are you sure you want to delete # %s?', $project['Project']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
			</table>
			<p>
			<?php
			// echo $this->Paginator->counter(array(
			// 'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			// ));
			?>	</p>
			<div class="paging">
			<?php
				// echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				// echo $this->Paginator->numbers(array('separator' => ''));
				// echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</div>
	</div>
</div>
</div>
