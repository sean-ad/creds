<div class="row">
  <div class="col-lg-10"><h3><?php echo __('Projects')?></h3></div>
  <div class="col-lg-2">
  	<?php if (AuthComponent::user('role') == 'admin') {?>
    <?php echo $this->Html->link(__('Add Project'),'/projects/add',array('class' => 'btn btn-default pull-right','style' => 'margin-top: 15px')) ?>
    <?php } ?>
  </div>
</div>

<div class="row">

	<div class="col-12">
		<?php echo $this->Session->flash() ?>

    <hr>

	<?php /*  Admins get an info page with tables */ ?>

	<?php if (AuthComponent::user('role') == 'admin') {?>

			<table class='table table-bordered'>
			<tr>
					<th><?php echo h('id'); ?></th>
					<th><?php echo h('name'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($projects as $project): ?>
			<tr>
				<td><?php echo h($project['Project']['id']); ?>&nbsp;</td>
				<td><?php echo h($project['Project']['name']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $project['Project']['id'])); ?> |
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $project['Project']['id'])); ?> |
					<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $project['Project']['id']), null, __('Are you sure you want to delete # %s?', $project['Project']['id'])); ?>
			            <?php echo $this->Html->link(
			              __('Delete'),
			              '#ProjectsModal',
			              array(
			                'class' => 'btn-remove-modal',
			                'data-toggle' => 'modal',
			                'role'  => 'button',
			                'data-pid' => $project['Project']['id'],
			                'data-pname' => $project['Project']['name']
			              ));
			            ?>
				</td>
			</tr>
		<?php endforeach; ?>
			</table>
	</div>
</div>

<?php } else { ?>

<?php /*  Users get a list of projects they can view */ ?>

<table class='table table-bordered'>
			<tr>
					<th><?php echo h('Name'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($projects as $project): ?>
			<tr>
				<td><?php echo h($project['Project']['name']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $project['Project']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
			</table>
			<p>
	</div>
</div>

<?php } ?>

</div>
</div>


<?php if (AuthComponent::user('role') == 'admin') {?>

<div class="modal fade" id="ProjectsModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 id="myModalLabel"><?php echo __('Remove Project') ?></h4>
      </div>
      <div class="modal-body">
        <p><?php echo __('Are you sure you want to delete the project ') ?><span class="label-pname strong"></span> ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancel') ?></button>
        <?php echo $this->Html->link(__('Delete'),'/projects/delete/#{uid}',array('class' => 'btn btn-danger delete-project-link')) ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php }  ?>
<?php //echo $this->element('sql_dump');?>
