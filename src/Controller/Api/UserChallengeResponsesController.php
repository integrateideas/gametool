<?php
namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use Cake\Collection\Collection;

/**
 * UserChallengeResponses Controller
 *
 * @property \App\Model\Table\UserChallengeResponsesTable $UserChallengeResponses
 *
 * @method \App\Model\Entity\UserChallengeResponse[] paginate($object = null, array $settings = [])
 */
class UserChallengeResponsesController extends ApiController
{

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //find challenge by id from challenge table and check that challenge is active or inactive if its active then compare user response with the correct responses, and  save user challenge data in user challenge response table if they give correct response. 
        $this->request->data = $this->request->data['data'];
        $challengeId = $this->request->data['challenge_id'];
        $userChallengeResponse = $this->UserChallengeResponses->newEntity(); 
        $challenge =  $this->UserChallengeResponses->Challenges->findById($challengeId)
                                                           ->where(['is_active' => true])
                                                           ->contain(['ChallengeTypes'])
                                                           ->first();
        $existingUser = $this->UserChallengeResponses->find()
                                                     ->where(['identifier_type' => $this->request->data['identifier_type'], 'identifier_value' => $this->request->data['identifier_value'], 'challenge_id' => $this->request->data['challenge_id']])
                                                     ->first();

        $this->loadModel('FbPracticeInformation');
        $fbPracticeInfoId = $this->FbPracticeInformation->findByPageId($this->request->data['page_id'])->first();
        $this->request->data['fb_practice_information_id'] = $fbPracticeInfoId->id;
        
        if ($this->request->is('post')) {
            if($challenge){
                if(!$existingUser){
                    $challengeType = $challenge->challenge_type;
                 if($challengeType->name == "READ THE ARTICLE" || $challengeType->name == "WEEKLY HEALTH TRIVIA"){
                    if($this->request->data['response'] == $challenge->response){
                        $this->request->data['status'] = true;
                    }else{
                        $this->request->data['status'] = false;
                    }
                  }else{
                        $this->request->data['status'] = true;
                  }
                  $userChallengeResponse = $this->UserChallengeResponses->patchEntity($userChallengeResponse, $this->request->getData());
                    if ($this->UserChallengeResponses->save($userChallengeResponse)){
                        $this->set('userChallengeResponse', $userChallengeResponse);
                        $this->set('response', ['message' => 'Thanks for your response']);
                    }
                }else{
                     $this->set('response', ['message' => 'You had already completed the game']);
                }
             }
        }
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }
}
