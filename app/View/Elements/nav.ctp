<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<?php echo $this->Html->link(
				Configure::read('Application.name'),
				AuthComponent::user('id') ? "/home" : "/"
				, array('class' => 'navbar-brand')) ?>
			<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
			    <span class="sr-only">Toggle navigation</span>
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>
			</button>
		</div>
		<div id="navbar" class=" navbar-collapse collapse">
		<?php if(AuthComponent::user('id')){?>
			<ul class="nav navbar-nav">
				<li><a href="<?php echo $this->params->webroot?>projects">Projects</a></li>
				<?php if (AuthComponent::user('role') == 'admin') {?>
				<li><a href="<?php echo $this->params->webroot?>users">Users</a></li>
				<?php } ?>
			</ul>
		<?php } ?>
		</div>
	</div>
</nav>
