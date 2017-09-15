<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Cache\Cache;
use Cake\Collection\Collection;
/**
 * Challenges Controller
 *
 * @property \App\Model\Table\ChallengesTable $Challenges
 *
 * @method \App\Model\Entity\Challenge[] paginate($object = null, array $settings = [])
 */
class ChallengesController extends AppController
{
   public function initialize()
   {
    parent::initialize();
    $this->Auth->allow(['userFbPosts']);
}

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
            // pr($this->request->data); die;
            if($this->request->data['challenge_type_id'] == 3 || $this->request->data['challenge_type_id'] == 4){
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
        //If old image is available, unlink the path(and delete the image) and and  upload image from "upload" folder in webroot.
        $oldImageName = $challenge->image_name;
        $path = Configure::read('ImageUpload.uploadPathForChallengeImages');
        if ($this->request->is(['patch', 'post', 'put'])) {
            // pr($this->request->data); die;
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

    public function activeChallenge()
    {
        $this->viewBuilder()->layout('facebookuser');
        $activeChallenge = $this->Challenges->find()
                                            ->where(['is_active IS NOT' => 0])
                                            ->first();

        $image_url = Router::url('/', true);
        $image_url = $image_url.$activeChallenge->image_path.'/'.$activeChallenge->image_name;
        $url = Router::url(['controller'=>'Challenges','action'=>'activeChallenge'],true);
        $activeChallenge->url = $url;
        $activeChallenge->image_url = $image_url;                                
        $this->set(compact('activeChallenge'));
        $this->set('_serialize', ['activeChallenge']);
    }

    // public function userFbPosts(){
       
    //     $this->loadComponent('FbGraphApi'); 
    //     $getFbPages = $this->FbGraphApi->getPages(true);
    //     // pr($getFbPages['response']);die;
    //     $data = [];

    //     foreach ($getFbPages['response'] as $key => $value) {
    //         $data[] = [ 
    //                     'page_token'=> $value->access_token,
    //                     'page_id' => $value->id,
    //                     'page_name' => $value->name,
    //                     'user_id' =>$this->Auth->User('id'),
    //                     'status' => $getFbPages['status']
    //                    ];
    //     }
        
    //     $this->loadModel('FbPracticeInformation');
    //     $fbPageInfo = $this->FbPracticeInformation->newEntities($data);
    //     $fbPageInfo = $this->FbPracticeInformation->patchEntities($fbPageInfo, $data);
    //     if ($this->FbPracticeInformation->saveMany($fbPageInfo)) {
    //             pr($this->FbPracticeInformation->saveMany($fbPageInfo));die;
    //         }else{
    //             pr('There is an error while saving data.');
    //         }
        
    //     $response = $this->FbGraphApi->postOnFb($data['fb_page_identifier'],$data['message'],$pageToken[$data['fb_page_identifier']]);

    // }

    public function isAuthorized($user)
    {

        return parent::isAuthorized($user);
    }
}
