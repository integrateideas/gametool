<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;

/**
 * FbPracticeInformation Controller
 *
 * @property \App\Model\Table\FbPracticeInformationTable $FbPracticeInformation
 *
 * @method \App\Model\Entity\FbPracticeInformation[] paginate($object = null, array $settings = [])
 */
class FbPracticeInformationController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [

            'contain' => ['ChallengeWinners'],
            'conditions' => ['user_id' => $this->Auth->user('id')]
        ];

        $fbPracticeInformation = $this->paginate($this->FbPracticeInformation);
        
        $this->set(compact('fbPracticeInformation'));
        $this->set('_serialize', ['fbPracticeInformation']);
    }

    /**
     * View method
     *
     * @param string|null $id Fb Practice Information id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fbPracticeInformation = $this->FbPracticeInformation->get($id, [
            'contain' => []
        ]);

        $this->set('fbPracticeInformation', $fbPracticeInformation);
        $this->set('_serialize', ['fbPracticeInformation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fbPracticeInformation = $this->FbPracticeInformation->newEntity();
        if ($this->request->is('post')) {
            $fbPracticeInformation = $this->FbPracticeInformation->patchEntity($fbPracticeInformation, $this->request->getData());
            
            if ($this->FbPracticeInformation->save($fbPracticeInformation)) {
                $this->Flash->success(__('The fb practice information has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fb practice information could not be saved. Please, try again.'));
        }
        $this->set(compact('fbPracticeInformation'));
        $this->set('_serialize', ['fbPracticeInformation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Fb Practice Information id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fbPracticeInformation = $this->FbPracticeInformation->get($id, [
            'contain' => []
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fbPracticeInformation = $this->FbPracticeInformation->patchEntity($fbPracticeInformation, $this->request->getData());
            if ($this->FbPracticeInformation->save($fbPracticeInformation)) {
                $this->Flash->success(__('The fb practice information has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fb practice information could not be saved. Please, try again.'));
        }
        $this->set(compact('fbPracticeInformation'));
        $this->set('_serialize', ['fbPracticeInformation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Fb Practice Information id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fbPracticeInformation = $this->FbPracticeInformation->get($id);
        if ($this->FbPracticeInformation->delete($fbPracticeInformation)) {
            $this->Flash->success(__('The fb practice information has been deleted.'));
        } else {
            $this->Flash->error(__('The fb practice information could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
