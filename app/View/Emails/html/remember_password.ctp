<h2><?php echo Configure::read('Application.name') ?></h2>

<p>Need to change your password?  Visit this link: <?php echo $this->Html->link(__('Reset my password'),array('controller'=>'users', 'action'=>'remember_password_step_2/'.$hash, 'full_base' => true)); ?></p>

<p>If you did not request a new password, please ignore this email.</p>
