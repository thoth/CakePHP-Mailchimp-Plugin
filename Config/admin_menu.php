<?php

CroogoNav::add('settings.children.mailchimp', array(
	'title' => 'Mailchimp',
	'url' => array(
		'admin' => true,
		'plugin' => 'settings',
		'controller' => 'settings',
		'action' => 'prefix',
		'Mailchimp',
	),
));