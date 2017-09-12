<?php 
namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\Log\Log;
use Cake\Network\Exception;

class UserEventListener implements EventListenerInterface {


	public function implementedEvents()
	{
	    return [
	        'Triviagame.getFbPages' => 'ongetFbPages',
	    ];
	}

	public function ongetFbPages($event, $data){
				
		// $this->loadComponent('FbGraphApi');
		// $getFbPages = $this->FbGraphApi->getPages(true);
		// pr($getFbPages);die;

	}

}

?>