<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UserChallengeResponses Controller
 *
 * @property \App\Model\Table\UserChallengeResponsesTable $UserChallengeResponses
 *
 * @method \App\Model\Entity\UserChallengeResponse[] paginate($object = null, array $settings = [])
 */
class UserChallengeResponsesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Challenges']
        ];
        $userChallengeResponses = $this->paginate($this->UserChallengeResponses);

        $this->set(compact('userChallengeResponses'));
        $this->set('_serialize', ['userChallengeResponses']);
    }

    /**
     * View method
     *
     * @param string|null $id User Challenge Response id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userChallengeResponse = $this->UserChallengeResponses->get($id, [
            'contain' => ['Users', 'Challenges']
        ]);

        $this->set('userChallengeResponse', $userChallengeResponse);
        $this->set('_serialize', ['userChallengeResponse']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($challengeId)
    {
        //find challenge by id from challenge table and check that challenge is active or inactive if its active then compare user response with the correct responses, and  save user challenge data in user challenge response table if they give correct response. 
        $userChallengeResponse = $this->UserChallengeResponses->newEntity(); 
        $challenge =  $this->UserChallengeResponses->Challenges->findById($challengeId)
                                                           ->where(['is_active' => true])
                                                           ->contain(['ChallengeTypes'])
                                                           ->first();
        $this->request->data['user_id'] = $this->Auth->user('id');
        if ($this->request->is('post')) {
            if($challenge){
                 $challengeType = $challenge->challenge_type;
                 if($challengeType->name == "READ THE ARTICLE" && $challengeType->name == "WEEKLY HEALTH TRIVIA"){
                    //compare user response
                    if($this->request->data['response'] == $challenge->response){
                        $this->request->data['status'] = true;
                    }
                  }else{
                        $this->request->data['status'] = true;
                  }
                $userChallengeResponse = $this->UserChallengeResponses->patchEntity($userChallengeResponse, $this->request->getData());
                if ($this->UserChallengeResponses->save($userChallengeResponse)) {
                    $this->Flash->success(__('Challenge Completed.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Something went wrong!!. Please, try again.'));
             }
        }
        // $users = $this->UserChallengeResponses->Users->find('list', ['limit' => 200]);
        // $challenges = $this->UserChallengeResponses->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('userChallengeResponse', 'users', 'challenges'));
        $this->set('_serialize', ['userChallengeResponse']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Challenge Response id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userChallengeResponse = $this->UserChallengeResponses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userChallengeResponse = $this->UserChallengeResponses->patchEntity($userChallengeResponse, $this->request->getData());
            if ($this->UserChallengeResponses->save($userChallengeResponse)) {
                $this->Flash->success(__('The user challenge response has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user challenge response could not be saved. Please, try again.'));
        }
        $users = $this->UserChallengeResponses->Users->find('list', ['limit' => 200]);
        $challenges = $this->UserChallengeResponses->Challenges->find('list', ['limit' => 200]);
        $this->set(compact('userChallengeResponse', 'users', 'challenges'));
        $this->set('_serialize', ['userChallengeResponse']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User Challenge Response id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userChallengeResponse = $this->UserChallengeResponses->get($id);
        if ($this->UserChallengeResponses->delete($userChallengeResponse)) {
            $this->Flash->success(__('The user challenge response has been deleted.'));
        } else {
            $this->Flash->error(__('The user challenge response could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
