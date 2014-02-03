<?php

$config = array(
	'Application' => array(
		'name' 	  => 'Credentials',
		'version' => 'v0.1',
		'status'  => 1,
	),
	'Meta' => array(
		'title' 	  => '',
		'description' => '',
		'keywords' 	  => '',
	),

	'Google' => array(
		'analytics'  => '',
	),

	'Email' => array(
		'from_email' => array('{{from_name}}' => '{{from_email}}'),
		'contact_mail' => array('{{contact_name}}' => '{{contact_mail}}')
	)
);

?>
