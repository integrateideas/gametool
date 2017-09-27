<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Cache\Cache;
use Cake\Collection\Collection;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Date;
use Cake\Utility\Text;
use App\Shell\TriviaWinnerShell;

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
        'contain' => ['ChallengeTypes'],
        'conditions' => ['user_id' => $this->Auth->user('id')]
        ];
        $activeChallenge = null;
        $challenges = $this->paginate($this->Challenges);
        foreach ($challenges as $key => $value) {
            if($value->is_active == 1){
                $activeChallenge = 1;
            }
        }

        $this->set(compact('challenges','activeChallenge'));
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
        $slug = strtolower(Text::slug($challenge->name));
        $url = Router::url(['controller'=>$slug.'/challenge','?'=>['chId'=>$id]],true);
        $this->set('challenge', $challenge);
        $this->set('url', $url);
        $this->set('_serialize', ['challenge']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    private function _checkActiveChallenge(){
        $getChallenges = $this->Challenges->find()->where(['is_active' => 1])->first();
        // pr($getChallenges);die;
        
            if($getChallenges){
                return true;
            }else{
                return false;
            }
    }

    public function add()
    {
        $challenge = $this->Challenges->newEntity();
        
        if ($this->request->is('post')) {
           
            $activeChallenge = $this->_checkActiveChallenge();
           
            if((!$activeChallenge) || ($activeChallenge && $this->request->data['is_active'] == 0)){
                

            if($this->request->data['challenge_type_id'] == 3 || $this->request->data['challenge_type_id'] == 4){
                $this->request->data['details'] = null;
                $this->request->data['response'] = null;
            }
            $this->request->data['image_name']['name'] = str_replace(' ', '_', $this->request->data['image_name']['name']);
            $this->request->data['user_id'] = $this->Auth->user('id');
            //provided timezone
            $tz_from = $this->request->data['timezone'];
            $tz_to = 'UTC';
            // Converting start-time into UTC Timezone.
            $startTime = $this->request->data['start_time'];
            $start = new \DateTime($startTime, new \DateTimeZone($tz_from));
            $start = $start->setTimeZone(new \DateTimeZone($tz_to));
            $this->request->data['start_time'] = $start;

            // Converting end-time into UTC Timezone.
            $endTime = $this->request->data['end_time'];
            $end = new \DateTime($endTime, new \DateTimeZone($tz_from));
            $end = $end->setTimeZone(new \DateTimeZone($tz_to));
            $this->request->data['end_time'] = $end;

            $challenge = $this->Challenges->patchEntity($challenge, $this->request->getData());
            
                if ($this->Challenges->save($challenge)) {
                    $this->Flash->success(__('The challenge has been saved.'));
                    return $this->redirect(['action' => 'index']);   
                }
                $this->Flash->error(__('The challenge could not be saved. Please, try again.'));
            }else{
  
                $this->Flash->error(__('Challenge is already active.Please deactivate the challenge to activate this challenge.'));   
            }
        }
        $challengeTypes = $this->Challenges->ChallengeTypes->find('list', ['limit' => 200]);
        $this->set(compact('challenge', 'challengeTypes'));
        $this->set('timeZoneList',array_flip($this->_getTimeZoneList()));
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
        // pr($challenge->timezone);die;
        $timezone = $challenge->timezone;
        //If old image is available, unlink the path(and delete the image) and and  upload image from "upload" folder in webroot.
        $oldImageName = $challenge->image_name;
        $path = Configure::read('ImageUpload.uploadPathForChallengeImages');
        if ($this->request->is(['patch', 'post', 'put'])) {
        if(isset($this->request->data['image_name'])){
           $this->request->data['image_name']['name'] = str_replace(' ', '_', $this->request->data['image_name']['name']); 
        }

            $challenge = $this->Challenges->patchEntity($challenge, $this->request->getData());
            if ($this->Challenges->save($challenge)) {
                $this->Flash->success(__('The challenge has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The challenge could not be saved. Please, try again.'));
        }
        $challengeTypes = $this->Challenges->ChallengeTypes->find('list', ['limit' => 200]);

        $this->set(compact('challenge', 'challengeTypes','date', 'startDate','timezone'));
        $this->set('timeZoneList',array_flip($this->_getTimeZoneList()));
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

    public function activeChallenge(){

        $this->viewBuilder()->layout('facebookuser');
        $chId  = (isset($this->request->query['chId']))?$this->request->query['chId']:null;
        $pageId  = (isset($this->request->query['p']))?$this->request->query['p']:null;
        if(!$pageId){
            $this->Flash->error(__('Invalid Request'));   
            return $this->redirect(['action' => 'error']);
        }

        if(!$chId){
            $activeChallenge = $this->Challenges->find()
            ->where(['is_active' => 1])
            ->first();    
        }else{

            $activeChallenge = $this->Challenges->findById($chId)
            ->first();

            // if(!$activeChallenge->is_active){
            //     return $this->redirect(['action' => 'winner', '?'=>['chId' => $chId, 'p' => $pageId]]);
            // }  
            
        }
        $challengeEndTime = $activeChallenge->end_time->setTimezone($activeChallenge->timezone)->format('Y-m-d h:i:s');
        if(!$activeChallenge->is_active){
            return $this->redirect(['action' => 'winner', 'chId' => $chId, 'p' => $pageId]);
        }else{
            $image_url = Router::url('/', true);
            $image_url = $image_url.$activeChallenge->image_path.'/'.$activeChallenge->image_name;
            $slug = strtolower(Text::slug($activeChallenge->name));
            $url = Router::url(['controller'=>$slug.'/challenge','?'=>['chId' => $chId, 'p' => $pageId]],true);
            $activeChallenge->url = $url;
            $activeChallenge->encodeUrl = urlencode($activeChallenge->url);
            $activeChallenge->image_url = $image_url;
            
            $this->set(compact('activeChallenge'));
            $this->set(compact('pageId','challengeEndTime'));

            $this->set('_serialize', ['activeChallenge','pageId']);    
        }
        
    }

    public function challengeWinners(){
        $this->loadModel('ChallengeWinners');
        $getExistingWinners = $this->ChallengeWinners->find()->contain(['FbPracticeInformation'])->all();
        
        $this->set(compact('getExistingWinners'));
        $this->set('_serialize', ['getExistingWinners']);
    }

    public function responseSubmitted(){
        $this->viewBuilder()->setLayout('trivia_winner');
    }


   
    public function postWinner(){

        $tr = new TriviaWinnerShell();
        $tr->endChallenge(true);
        $this->Flash->success(__('Challenge end Successfully.'));
        $this->Flash->success(__('Post Winner Successfully on Facebook.'));
        $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {

        return parent::isAuthorized($user);
    }

    public function winner(){
        $this->response->header("Content-Type: image/png");
        $this->viewBuilder()->layout('facebookuser');
        $challengeId = (isset($this->request->query['chId']))?$this->request->query['chId']:null;
        $pageId = (isset($this->request->query['p']))?$this->request->query['p']:null;
        // pr($pageId);die;
        $this->loadModel('FbPracticeInformation');
        $this->loadModel('ChallengeWinners');
        if(!$challengeId || !$pageId){
            return $this->redirect(['action' => 'error']);
        }
        $fbPracticeInfoId = $this->FbPracticeInformation->findByPageId($pageId)->first()->get('id');

        $challengeWinner = $this->ChallengeWinners->findByChallengeId($challengeId)
        ->contain(['Challenges'])
        ->where([
            'fb_practice_information_id' => $fbPracticeInfoId
            ])
        ->first();
        if(!$challengeWinner){
            die(' no one played the game');
        }                                                                                 
        $activeChallenge = $challengeWinner->challenge;

        $this->_createImage($challengeWinner);                                
        $this->set(compact('activeChallenge', 'challengeWinner'));
        $this->set('_serialize', ['challenge', 'challengeWinner']);
    }

    private function _createImage($challengeDetails){
        if($challengeDetails){
            $activeChallenge = $challengeDetails->challenge;
           try {
              // Create a new SimpleImage object
                  $image = new \claviska\SimpleImage();
                  $image
                ->fromFile(WWW_ROOT.'challenge_images/'.$activeChallenge->image_name)                     // load image.jpg
                ->autoOrient()  // adjust orientation based on exif data
                ->resize(1000, 600)                            
                ->text('Winner of '.$activeChallenge->name.' is ',['color'=> $activeChallenge->image_details['text-color'], 
                'anchor'=> $activeChallenge->image_details['text-position'],
                'size'=> $activeChallenge->image_details['text-font-size'],
                'yOffset'=>-80,
                'fontFile'=>WWW_ROOT.'fonts/Futura-Std-Book.ttf'])
                ->text(ucfirst($challengeDetails->identifier_value),['color'=> $activeChallenge->image_details['text-color'], 
                'anchor'=> $activeChallenge->image_details['text-position'],
                'yOffset'=>80,
                'shadow'=>['x'=>2,'y'=>4,'color'=>$activeChallenge->image_details['text-shadow-color']],
                  'size'=> $activeChallenge->image_details['text-font-size'],
                'fontFile'=>WWW_ROOT.'fonts/Futura-Std-Book.ttf'])  
                ->toScreen();  
            die;                             
            } catch(Exception $err) {
              echo $err->getMessage();
            }
        }
    }
}
