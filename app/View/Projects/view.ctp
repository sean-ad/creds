


<?php //print_r ($project['User']);?>
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

<div class="row">
  <div class="col-lg-10"><h3><?php echo __($project['Project']['name'])?></h3></div>
  <div class="col-lg-2">
  	<?php if (AuthComponent::user('role') == ('admin' || 'author')) {?>
    <?php echo $this->Html->link(__('Add Credentials'),'/credentials/add/project:' . $project['Project']['id'],array('class' => 'btn btn-default pull-right','style' => 'margin-top: 15px')) ?>
    <?php } ?>
  </div>
</div>

<hr>

<div class="related">
	<h4><?php echo __('Credentials:'); ?></h4>

	<?php if (!empty($project['ProjectItem'])): ?>
	<div class='row'>
		<div class="col-12 table-responsive" id="no-more-tables">
			<table class='table table-bordered'>
				<thead><tr>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Username'); ?></th>
					<th><?php echo __('Password'); ?></th>
					<th><?php echo __('Url/Server'); ?></th>
					<th><?php echo __('Details'); ?></th>
					<?php if (AuthComponent::user('role') == 'admin' || AuthComponent::user('role') == 'author') {?>
						<th class="actions"><?php echo __('Actions'); ?></th>
					<?php } ?>
				</tr>
                         </thead>
                          <tbody>
				<?php foreach ($project['ProjectItem'] as $projectItem): ?>
					<tr>
						<td data-title="Name"><?php echo $projectItem['name']; ?></td>
						<td data-title="Username"><?php echo $projectItem['username']; ?></td>
						<td data-title="Password"><?php echo $projectItem['password']; ?></td>
						<td data-title="URL"><?php echo $projectItem['url']; ?></td>
						<td data-title="Notes"><?php if (!empty($projectItem['notes'])): ?>
                                          <?php echo $this->Html->link(__('Note'), array('controller' => 'project_items', 'action' => 'view', $projectItem['id'])); ?>
                                          <?php endif; ?></td>
						<?php if (AuthComponent::user('role') == ('admin' ||  'author')) {?>
							<td data-title="Actions" class="actions">
								<?php //echo $this->Html->link(__('Details'), array('controller' => 'project_items', 'action' => 'view', $projectItem['id'])); ?>
								<?php echo $this->Html->link(__('Edit'), array('controller' => 'project_items', 'action' => 'edit', $projectItem['id'])); ?> |
								<?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'project_items', 'action' => 'delete', $projectItem['id']), null, __('Are you sure you want to delete # %s?', $projectItem['id'])); ?>
                                                    <?php echo $this->Html->link(
                                                      __('Delete'),
                                                      '#CredentialsModal',
                                                      array(
                                                        'class' => 'btn-remove-modal',
                                                        'data-toggle' => 'modal',
                                                        'role'  => 'button',
                                                        'data-uid' => $projectItem['id'],
                                                        'data-uname' => $projectItem['name']
                                                      ));
                                                    ?>
							</td>
						<?php } ?>
					</tr>
				<?php endforeach; ?>
				</tbody></table>
		</div>
	</div>
<?php endif; ?>

<?php if (!empty($project['Project']['notes'])): ?>
<div class="projects view">
<h4>Notes:</h4>
<?php echo $project['Project']['notes']; ?>
</div>
<?php endif; ?>

<?php if (AuthComponent::user('role') == 'admin') {?>
	<?php if (!empty($users)):?>
		<hr />
		<div class="row">
		  <div class="col-lg-10"><h4><?php echo  ' Users with access to this project: ';?></h4></div>
		  <div class="col-lg-2">
		  </div>
		</div>
              <div class='row'>
                <div class="col-md-8">
                  <table class='table table-bordered'>
                    <tr>
                      <th><?php echo __('Name'); ?></th>
                      <th><?php echo __('Action'); ?></th>
                    </tr>
                      <?php foreach ($users as $user) :?>
                      <tr>
                        <td><?php echo $user['User']['username']; ?></td>
                        <td><a href="/projects/permissions/<?php echo $project['Project']['id'] . '/' . $user['User']['id'];?>/deny"> Remove</a></td>
                      </tr>
                    <?php endforeach; ?>
                    </table>
              </div>
            </div>
	<?php endif;?>
  <?php /* -----------------Users to add----------------------------------- */?>
      <?php if (!empty($disallowedusers)):?>
      <div class="row">
        <div class="col-lg-10"><h4><?php echo  ' Users without access: ';?></h4></div>
      </div>
      <?php echo $this->Form->create('Project', array('type' => 'post', 'action'=>array('controller'=>'projects'), 'action'=>'permissions', 'default'=>true));?>
      <?php echo $this->Form->input('id', array('value'=>$project['Project']['id'])); ?>
      <?php foreach ($disallowedusers as $disalloweduser) :?>
        <!-- <li><?php //echo $disalloweduser['User']['username'] ?></li> -->
      <?php //echo $this->Form->input('users_to_allow', array('type'=>'checkbox', 'name' =>'data[Project][users_to_allow][]', 'label'=> $disalloweduser['User']['username'], 'value'=>$disalloweduser['User']['id'], 'div'=>'checkbox', 'class' => 'checkbox'));  ?>
      <div class="checkbox ">
        <label>
        <input type="checkbox" name="data[Project][users_to_allow][]" value="<?php echo $disalloweduser['User']['id'];?>">
          <?php echo $disalloweduser['User']['username'];?>
        </label>
      </div>
      <?php endforeach;?>
      <p>&nbsp; </p>
      <?php echo $this->Form->end('Grant Access'); ?>

    <?php endif;?>
  <?php /* ---------------------------------------------------- */?>
</div>
<?php }?>

<?php if (AuthComponent::user('role') == 'admin') {?>

<div class="modal fade" id="CredentialsModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 id="myModalLabel"><?php echo __('Remove Credentials') ?></h4>
      </div>
      <div class="modal-body">
        <p><?php echo __('Are you sure you want to remove the credentials ') ?><span class="label-uname strong"></span> ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default " data-dismiss="modal"><?php echo __('Cancel') ?></button>
        <?php echo $this->Html->link(__('Delete'),'/credentials/delete/#{uid}',array('class' => 'btn btn-danger delete-credentials-link')) ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php }  ?>
<?php //echo $this->element('sql_dump');?>
