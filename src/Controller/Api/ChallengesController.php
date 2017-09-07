<?php
namespace App\Controller\Api
;

use App\Controller\Api\ApiController;
use Cake\Collection\Collection;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 *
 * @method \App\Model\Entity\Project[] paginate($object = null, array $settings = [])
 */
class ChallengesController extends ApiController
{

    
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        // $this->Auth->allow(['dashboard']);
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    
    public function getChallengeData(){

        $activeChallenge = $this->Challenges->find()
                                            ->contain('ChallengeTypes')
                                            ->where(['is_active IS NOT' => 0])
                                            ->first();
                                            
        $this->set(compact('activeChallenge'));
        $this->set('_serialize', ['activeChallenge']);
    }
}
