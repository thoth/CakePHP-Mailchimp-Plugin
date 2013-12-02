<?php
/**
 * Component
 *
 * This plugin's Mailchimp component will be loaded in ALL controllers.
 */
    Croogo::hookComponent('*', 'Mailchimp.Mailchimp');

	require 'admin_menu.php';
