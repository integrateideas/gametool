<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Challenges Controller
 *
 * @property \App\Model\Table\ChallengesTable $Challenges
 *
 * @method \App\Model\Entity\Challenge[] paginate($object = null, array $settings = [])
 */
class ChallengesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ChallengeTypes']
        ];
        $challenges = $this->paginate($this->Challenges);

        $this->set(compact('challenges'));
        $this->set('_serialize', ['challenges']);
    }

    /**
     * View method
     *
     * @param string|null $id Challenge id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $challenge = $this->Challenges->get($id, [
            'contain' => ['ChallengeTypes', 'UserChallengeResponses']
        ]);

        $this->set('challenge', $challenge);
        $this->set('_serialize', ['challenge']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $challenge = $this->Challenges->newEntity();
        if ($this->request->is('post')) {
            if($this->request->data['challenge_type_id'] == 2 || $this->request->data['challenge_type_id'] == 3 || $this->request->data['challenge_type_id'] == 4){
                $this->request->data['details'] = null;
                $this->request->data['response'] = null;
            }
            $challenge = $this->Challenges->patchEntity($challenge, $this->request->getData());
            if ($this->Challenges->save($challenge)) {
                $this->Flash->success(__('The challenge has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challenge could not be saved. Please, try again.'));
        }
        $challengeTypes = $this->Challenges->ChallengeTypes->find('list', ['limit' => 200]);
        $this->set(compact('challenge', 'challengeTypes'));
        $this->set('_serialize', ['challenge']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Challenge id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $challenge = $this->Challenges->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $challenge = $this->Challenges->patchEntity($challenge, $this->request->getData());
            if ($this->Challenges->save($challenge)) {
                $this->Flash->success(__('The challenge has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challenge could not be saved. Please, try again.'));
        }
        $challengeTypes = $this->Challenges->ChallengeTypes->find('list', ['limit' => 200]);
        $this->set(compact('challenge', 'challengeTypes'));
        $this->set('_serialize', ['challenge']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Challenge id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $challenge = $this->Challenges->get($id);
        if ($this->Challenges->delete($challenge)) {
            $this->Flash->success(__('The challenge has been deleted.'));
        } else {
            $this->Flash->error(__('The challenge could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function triviaWinner(){
        
        $this->loadModel('UserChallengeResponses');
        $selectedWinneres = $this->UserChallengeResponses->find()
                                                         ->contain('FbPracticeInformation')
                                                         ->all()
                                                         ->groupBy('fb_practice_information_id')
                                                         ->toArray();

        $data = [];
        foreach ($selectedWinneres as $key => $value) {

            $getRandomWinner = array_rand($value);
            $result = $value[$getRandomWinner];
            $data[] = [
                        'user_id' => $result->user_id,
                        'fb_practice_information_id'=> $result->fb_practice_information_id,
                        'challenge_id'=>$result->challenge_id   
                    ];
        }
         
        $this->loadModel('ChallengeWinners');
        $triviaWinner = $this->ChallengeWinners->newEntities($data);
        $triviaWinner = $this->ChallengeWinners->patchEntities($triviaWinner, $data);

        if($this->ChallengeWinners->saveMany($triviaWinner)){
                pr('here');die;
        }   
    }
}
