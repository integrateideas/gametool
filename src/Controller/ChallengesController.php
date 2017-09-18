<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Cache\Cache;
use Cake\Collection\Collection;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
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
        $url = Router::url(['controller'=>'Challenges','action'=>'activeChallenge','?'=>['challenge'=>$id]],true);
        $this->set('challenge', $challenge);
        $this->set('url', $url);
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
            if($this->request->data['challenge_type_id'] == 3 || $this->request->data['challenge_type_id'] == 4){
                $this->request->data['details'] = null;
                $this->request->data['response'] = null;
            }
            $time = $this->request->data['end_time'];
            $timestamp = strtotime($time);
            $new_date = date('Y-m-d H:i:s',$timestamp );
            $this->request->data['end_time'] = $new_date;
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

     public function triviaWinner(){
        $this->loadModel('UserChallengeResponses');
        // active challenge id

        // find active challenge from challenge table and then find users from user challenge response table corresponding to active challenge id
        $challengeId = $this->Challenges->find()
                                            ->where(['is_active'=> 1])
                                            ->first()
                                            ->get('id');
        $userResponses = $this->UserChallengeResponses->findByChallengeId($challengeId)
                                             ->where(['status' => 1])
                                             ->groupBy('fb_practice_information_id')
                                             ->toArray();
        // pr($userResponses);
        $this->loadModel('ChallengeWinners'); 
        $challengeWinners = $this->ChallengeWinners->find()
                                                   ->select(['fb_practice_information_id','identifier_value','identifier_type','created'])
                                                   ->groupBy('fb_practice_information_id')
                                                   ->toArray();

            // pr($challengeWinners);die;
        // $triviaWinner = [];                                            
        foreach ($userResponses as $key => $response) {
            $winnerArray = isset($challengeWinners[$key]) ? $challengeWinners[$key] : null;
            // pr($winnerArray); die;
            if(!$winnerArray){
                //$triviaWinner[$key]= select random winner
            }else{
                foreach ($response as $value) {
                    pr($value);
                    foreach ($winnerArray as $winner) {
                        // pr($winner);
                        if($value->identifier_type === $winner->identifier_type &&  $value->identifier_value === $winner->identifier_value){
                            pr('here when match');
                            pr($value->identifier_type); 
                            pr($value->identifier_value);
                            $triviaWinner[] = $winner;
                        // }else{
                        //     pr('here when not');
                        //     pr($value->identifier_type); 
                        //     pr($value->identifier_value);
                        //     //isme vo winner declare kiya jayega jiski entry abhi tk challenge winner mein nahi ho rakhi kisi practice k corresponding.
                        } 
                    }
                }
            }
        }
        die;
        // pr($triviaWinner); die;
        // //pr(asort($triviaWinner)); die;
        // $win = $triviaWinner;
        // asort($win);
        // foreach($win as $x => $value) {
        //     echo "Key=" . $value->identifier_value . ", Value=" . $value->created;
        //     echo "<br>";
        // }
    }

    public function activeChallenge(){
        $this->viewBuilder()->layout('facebookuser');
        $chId  = (isset($this->request->query['challenge']))?$this->request->query['challenge']:null;
        $pageId  = (isset($this->request->query['p']))?$this->request->query['p']:null;
        if(!$pageId){
            $this->Flash->error(__('Invalid Request'));   
            return $this->redirect(['action' => 'error']);
        }

        if($chId){
            $activeChallenge = $this->Challenges->find()
                                            ->where(['id' =>$chId])
                                            ->first();
            if($activeChallenge){
                return $this->redirect(['action' => 'winner', 'chId' => $chId, 'p' => $pageId]);
            }  
              
        }else{
            $activeChallenge = $this->Challenges->find()
                                            ->where(['is_active IS NOT' => 0])
                                            ->first();    
        }
                $image_url = Router::url('/', true);
        $image_url = $image_url.$activeChallenge->image_path.'/'.$activeChallenge->image_name;
        $url = Router::url(['controller'=>'Challenges','action'=>'activeChallenge'],true);
        $activeChallenge->url = $url;
        $activeChallenge->image_url = $image_url;                                
        $this->set(compact('activeChallenge'));
        $this->set(compact('pageId'));
        $this->set('_serialize', ['activeChallenge','pageId']);
    }

    public function responseSubmitted(){
        $this->viewBuilder()->setLayout('trivia_winner');
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

    public function winner(){
        $this->viewBuilder()->layout('facebookuser');
        $challengeId = (isset($this->request->query['chId']))?$this->request->query['chId']:null;
        $pageId = (isset($this->request->query['p']))?$this->request->query['p']:null;
        $this->loadModel('FbPracticeInformation');
        $this->loadModel('ChallengeWinners');
        if((empty($challengeId) || !$challengeId) && (empty($pageId) || !$pageId)){
            return $this->redirect(['action' => 'error']);
        }
        $fbPracticeInfoId = $this->FbPracticeInformation->findByPageId($pageId)->first()->get('id');

        $challengeWinner = $this->ChallengeWinners->findByChallengeId($challengeId)
                                                ->contain(['Challenges'])
                                                ->where(['fb_practice_information_id' => $fbPracticeInfoId])
                                                ->first();
        if(!$challengeWinner){
            throw new NotFoundException("Not Found");
            
        }                                                                               
        $activeChallenge = $challengeWinner->challenge;

        $image_url = Router::url('/', true);
        $image_url = $image_url.$activeChallenge->image_path.'/'.$activeChallenge->image_name;
        $activeChallenge->image_url = $image_url;                                
        $this->set(compact('activeChallenge', 'challengeWinner'));
        $this->set('_serialize', ['challenge', 'challengeWinner']);
    }
}
