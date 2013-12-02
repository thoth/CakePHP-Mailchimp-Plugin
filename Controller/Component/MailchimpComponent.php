<?php
/** 
 * Mailchimp Component
 * This will let me subscribe, unsubscribe, and manage other email newsletter functions easily.
 * #author      Shahruk Khan
 * #date        08/09/12
 */
 
App::import('Vendor', 'Mailchimp.MCAPI2');
class MailchimpComponent extends Component {

	
	public function initialize(Controller $controller, $settings = NULL) {
		if ($controller->request->is('ajax')) {
			Configure::write('debug', 0);

			// Must disable security component for AJAX
			if (isset($controller->Security)) {
				$controller->Security->validatePost = false;
			}

			// If not from this domain, destroy
			if (($this->allowRemote === false) && (strpos(env('HTTP_REFERER'), trim(env('HTTP_HOST'), '/')) === false)) {
				if (isset($controller->Security)) {
					$controller->Security->blackHole($controller, 'Invalid referrer detected for this request.');
				} else {
					$controller->redirect(null, 403, true);
				}
			}
		}

		$this->controller = $controller;
		
		//$this->api = new MCAPI(Configure::read('Mailchimp.api_key'));
		$this->api = new MailChimp(Configure::read('Mailchimp.api_key'));
		if($settings['listId'] == NULL)
		{
			$this->listId = Configure::read('Mailchimp.primary_list');
		}	
		else
			$this->listId = $settings['listId'];

	}

	public function startup(Controller$controller) {
		$this->controller = $controller;
	}

	public function listSubscribe($email=NULL, $name=NULL){

		$merge_vars = array('FNAME'=>$name);

		$retval = $this->api->listSubscribe( $this->listId, $email, $merge_vars, NULL, false );
		if ($this->api->errorCode){
			return false;
		} else {
			return true;
		}

	}

	public function createCampaign($content, $segments, $options, $type = 'regular'){

		$submit = array(
			'type'=>$type,
			'options'=>$options,
			'content'=>$content,
			'segment_opts'=>$segments
		);
//debug($submit); exit();
		$retval = $this->api->call('/campaigns/create', $submit);
		return $retval;


	}
	public function sendCampaign($cid){

		$submit = array(
			'apikey'=>Configure::read('Mailchimp.api_key'),
			'cid'=>$cid
		);

		$retval = $this->api->call('/campaigns/send', $submit);
		return $retval;


	}
	public function getLists(){

		$retval = $this->api->call('lists/list');
		return $retval;


	}

	public function getSegments(){
		$retval = $this->api->call('lists/segments', array('id'=>Configure::read('Mailchimp.primary_list')));
		
		return $retval;

	}

	public function getTemplates(){

		$retval = $this->api->call('templates/list');
		//$retval = $this->api->templates(array(), null, array('inactives'=>false));
		return $retval;

	}


}
