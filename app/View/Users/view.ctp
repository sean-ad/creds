<?php
$breadcrumb = array(
	array(
		'label' => 'Users',
		'link'	=> '/users'
	),
	array(
		'label'	=> $user['username']
	)
);
echo $this->element('breadcrumb',array('links' => $breadcrumb));
?>

<h3><?php echo $user['username'] ?></h3>
<hr>
<div class="media">
  <a class="pull-left" href="#">
  	<img class="media-object" src="https://secure.gravatar.com/avatar/<?php echo md5($user['email']) ?>?s=80&d=mm">
  </a>
  <div class="media-body">
    <h4 class="media-heading"><?php echo $user['username'] ?></h4>
    <strong>Email: </strong><?php echo $user['email'] ?><br/>
	<strong>Role: </strong><?php echo $user['role'] ?>
  </div>
</div>

<?php if (AuthComponent::user('role') == 'admin') {?>
    <hr />
    <div class="row">
      <div class="col-lg-10"><h4><?php echo $user['username'] . ' has access to these projects: ';?></h4></div>
      <div class="col-lg-2">
      </div>
    </div>
            <?php if (!empty($projects)):?>
              <div class='row'>
                <div class="col-md-8">
                  <table class='table table-bordered'>
                    <tr>
                      <th><?php echo __('Name'); ?></th>
                      <th><?php echo __('Action'); ?></th>
                    </tr>
                      <?php foreach ($projects as $project) :?>
                      <tr>
                        <td><?php echo $project['Project']['name'] ?></td>
                        <td><a href="/projects/permissions/<?php echo $project['Project']['id'] . '/' . $user['id'];?>/deny"> Remove</a></td>
                      </tr>
                    <?php endforeach; ?>
                    </table>
              </div>
              </div>
            <?php endif;?>

<?php } ?>
