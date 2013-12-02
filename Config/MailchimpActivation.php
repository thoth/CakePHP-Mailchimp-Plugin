<?php
/**
 * MailchimpActivation
 *
 * Activation class for Mailchimp plugin.
  *
 * @package  Croogo
 * @author   Tom Rader <tom.rader@claritymediasolutions.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.claritymediasolutions.com
 */		
class MailchimpActivation {
	public function beforeActivation(&$controller) {
		return true;
	}

	public function onActivation(&$controller) {
        // ACL: set ACOs with permissions
		$controller->Setting->write('Mailchimp.api_key','xxxxxxxxxx',array('description' => 'API Key for Mailchimp','editable' => 1));
		$controller->Setting->write('Mailchimp.primary_list','0',array('editable' => 1));
		$controller->Setting->write('Mailchimp.secondary_list','0',array('editable' => 1));
		$controller->Setting->write('Mailchimp.primary_template','0',array('editable' => 1));
		$controller->Setting->write('Mailchimp.secondary_template','0',array('editable' => 1));
		$controller->Setting->write('Mailchimp.default_from_name','',array('editable' => 1));
		$controller->Setting->write('Mailchimp.default_from_email','',array('editable' => 1));
		$controller->Setting->write('Mailchimp.default_subject','',array('editable' => 1));


	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
        $controller->Croogo->removeAco('Mailchimp'); // ExampleController ACO and it's actions will be removed
	}

}