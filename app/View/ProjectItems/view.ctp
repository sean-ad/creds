<?php
$breadcrumb = array(
	array(
		'label' => $projectItem['Project']['name'],
		'link'	=> '/projects/view/' . $projectItem['Project']['id']
	),
	array(
		'label'	=> $projectItem['ProjectItem']['name'],
	)
);
echo $this->element('breadcrumb',array('links' => $breadcrumb));
?>

<h3><?php echo $projectItem['Project']['name'] ?></h3>
<hr>
<div class="media">
  <a class="pull-left" href="#">
  	<!--<img class="media-object" src="https://secure.gravatar.com/avatar/<?php //echo md5($user['email']) ?>?s=80&d=mm"> -->
  </a>
  <div class="media-body">
    <h4 class="media-heading"><?php echo $projectItem['ProjectItem']['name'] ?></h4>
 	<strong>Username: </strong><?php echo $projectItem['ProjectItem']['username']?><br/>
	<strong>Password: </strong><?php echo $projectItem['ProjectItem']['password'] ?><br />
	<strong>URL: </strong><?php echo $projectItem['ProjectItem']['url'] ?><br />
	<strong>Notes: </strong><?php echo $projectItem['ProjectItem']['notes'] ?>
  </div>
</div>


