<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Log\Log;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Http\Client;
use Cake\I18n\Time;
use Cake\Mailer\Email;



/**
 * Simple console wrapper around Psy\Shell.
 */
class TriviaWinnerShell extends Shell
{
  private  $_fb = null;
   /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
   public function getOptionParser()
   {
    $parser = parent::getOptionParser();

    return $parser;
  }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */

    public function main()
    {
      $this->out($this->OptionParser->help());
    }

    public function startChallenge(){
        $currentTime = Time::now();
        $currentTime = $currentTime->format('Y-m-d H:i');
        $this->loadModel('Challenges');
        $allChallenges =   $this->Challenges->find()->all();

        foreach ($allChallenges as $key => $value) {
            $startTime = $value->start_time->format('Y-m-d H:i');
            $endTime = $value->end_time->format('Y-m-d H:i');
            if($currentTime >= $startTime && $currentTime <= $endTime){
                $data = [
                            'id' => $value->id,
                            'is_active' => 1
                        ];

                $challenge = $this->Challenges->patchEntity($value, $data);
            }
        }
        if($this->Challenges->save($challenge)){
            echo "Challenge has been active successfully";
        }else{
            echo "Something went wrong while saving data.";
        }  
    }
    
    private  function _triviaWinner($activeChallengeId){
      $this->loadModel('UserChallengeResponses');
      $userResponses = $this->UserChallengeResponses->findByChallengeId($activeChallengeId)
      ->where(['status' => 1])
      ->all()
      ->groupBy('fb_practice_information_id')
      ->toArray();

      $this->loadModel('ChallengeWinners'); 
      $challengeWinners = $this->ChallengeWinners->find()
      ->select(['fb_practice_information_id','identifier_value','identifier_type','created'])
      ->groupBy('fb_practice_information_id')
      ->toArray();
      $result = [];
      foreach ($userResponses as $key => $response) {
        $winnerArray = isset($challengeWinners[$key]) ? $challengeWinners[$key] : null;
        if(!$winnerArray){

          $triviaWinner = array_rand($response); 
          $result = $response[$triviaWinner];  

        }else{

          $new = (new Collection($response))->indexBy('identifier_value')->toArray();
          $existing = (new Collection($winnerArray))->indexBy('identifier_value')->toArray();            
          $newplayers = array_diff(array_keys($new),array_keys($existing));

          foreach ($newplayers as $newPlayer) {
            $newData[] = $new[$newPlayer];
          }

          $existingPlayers = array_intersect(array_keys($new), array_keys($existing));
          foreach ($existingPlayers as $existingPlayer) {
            $existingData[] = $existing[$existingPlayer];
          }

          if(empty($newData)){
            $result = (new Collection($existingData))->sortBy('created',SORT_ASC)->first();    
          }else{
            $triviaWinner = array_rand($newData); 
            $result = $newData[$triviaWinner];   
          }   
        }
        $data[] = [
        'fb_practice_information_id' => $result->fb_practice_information_id,
        'identifier_type' => $result->identifier_type,
        'identifier_value' => $result->identifier_value,
        'challenge_id' => $activeChallengeId,
        ];
      }
      // pr($result); die;

      // pr($data); die;
      $newEntity = $this->ChallengeWinners->newEntities($data);
      $activeChallengeWinner = $this->ChallengeWinners->patchEntities($newEntity, $data);
      if($this->ChallengeWinners->saveMany($activeChallengeWinner)){
        echo "Active Challenge Winner saved successfully";
      }else{
        echo "Something went wrong while saving data.";
      }       
    }

    private function _postWinnerOnFb($activeChallengeId){
     $activeChallenge = $this->Challenges->find()
                                         ->contain(['ChallengeWinners','ChallengeWinners.FbPracticeInformation'])
                                         ->where(['id'=>$activeChallengeId])
                                         ->first();

     $this->_fb = new \Facebook\Facebook([
      'app_id' => Configure::read('application.fbAppId'),
      'app_secret' =>Configure::read('application.fbAppSecret'),
      'default_graph_version' => 'v2.9',
      ]);


     foreach ($activeChallenge->challenge_winners as $key => $winner) {
      try {
              // Create a new SimpleImage object
        $image = new \claviska\SimpleImage();
        $image
                ->fromFile(WWW_ROOT.'challenge_images/'.$activeChallenge->image_name)  // load image
                ->autoOrient() // adjust orientation based on exif data
                ->resize(1000, 600)
                ->text('Winner of '.$activeChallenge->name.' is ',['color'=> $activeChallenge->image_details['text-color'], 
                  'anchor'=> $activeChallenge->image_details['text-position'],
                  'size'=> $activeChallenge->image_details['text-font-size'],
                  'yOffset'=>-80,
                  'fontFile'=>WWW_ROOT.'fonts/Futura-Std-Book.ttf'])
                ->text(ucfirst($winner->identifier_value),['color'=> $activeChallenge->image_details['text-color'], 
                  'anchor'=> $activeChallenge->image_details['text-position'],
                  'yOffset'=>80,
                  'shadow'=>['x'=>2,'y'=>4,'color'=>$activeChallenge->image_details['text-shadow-color']],
                  'size'=> $activeChallenge->image_details['text-font-size'],
                  'fontFile'=>WWW_ROOT.'fonts/Futura-Std-Book.ttf'])  
                ->toFile(WWW_ROOT.'/challenge_images/trivia_post_winner_fb_98765.png', 'image/png');

                $pageId =$winner->fb_practice_information->page_id; 
                
                $url = "/$pageId/photos";
                $fileUrl = Configure::read('application.baseUrl').'/challenge_images/trivia_post_winner_fb_98765.png';
                $data = [
                'caption'=>'Winner of the challenge named '.$activeChallenge->name .'is: '.$winner->identifier_value,
                'url'=>$fileUrl
                ];
                // $triviaWinnerPoints = $this->_rewardPoints($winner);
                // pr($triviaWinnerPoints);
                $response =  $this->_fb->post($url,$data, $winner->fb_practice_information->page_token);
              } catch(Exception $err) {
                pr($err->getMessage());
              }
            }

            $sendMail = $this->_sendEmail($activeChallenge);
            
          }

          private function _sendEmail($challenge){
            $emailText = "";
            foreach ($challenge->challenge_winners as $key => $value) {
              if(isset($value->fb_practice_information->is_old_buzzydoc) && !empty($value->fb_practice_information->is_old_buzzydoc)){
                  $version = "BuzzyDoc 3.0" ;
              }else{
                  $version = "BuzzyDoc 2.0" ;
              }
                         $emailText = $emailText.'<tr><td>'.$value->identifier_value.'</td><td>'.$value->fb_practice_information->practice_name.'</td><td>'.$version.'</td></tr>';
            }

            $emailText ='<h5>The list of winners are given bellow:</h5><br><table class = "table"><thead><tr><td><b>Winner Name&nbsp;</b></td><td><b>Practice Name&nbsp;<b></td><td><b>Buzzydoc Version&nbsp;<b></td></tr></thead><tbody>'.$emailText.'</tbody>';

            $email = new Email();
            $email->to("sunpreet.kaur@twinspark.co")
                  ->subject("Winner of Challenge ".$challenge->name." on ".$challenge->start_time->format('d-m-Y'))
                  ->emailFormat('html')
                  ->send($emailText);
            
          }

          private function _rewardPoints($challengeWinner){
            $this->loadModel('FbPracticeInformation');
            $vendorId = $this->FbPracticeInformation->findById($challengeWinner->fb_practice_information_id)
                                                  ->first()
                                                  ->get('buzzydoc_vendor_id');
                                                  
            $data = [
                        "vendor_id" => $vendorId,
                        "identifier_type" => $challengeWinner->identifier_type,
                        "identifier_value" => $challengeWinner->identifier_value
                    ];

            $http = new Client();
            $response = $http->post(Configure::read('buzzydocApp.baseUrl'), json_encode($data));
            $response = json_decode($response->body());
            return $response;

          }

          public function endChallenge($isAdminRequest = false){
           $this->loadModel('Challenges');
           $activeChallenge = $this->Challenges->find()
                                               ->where(['is_active'=> 1])
                                               ->first();

           if(!$activeChallenge){
            return false;
          }
          $currentTime = date('Y-m-d H:i:s');
          $currentTime = strtotime($currentTime);

          $activeChallengeEndTime = $activeChallenge['end_time'];
          $activeChallengeEndTime = strtotime($activeChallengeEndTime);
          if($currentTime >= $activeChallengeEndTime || $isAdminRequest){
            $data = [
            'id' => $activeChallenge['id'],
            'is_active' => 0
            ];
            $challenge = $this->Challenges->patchEntity($activeChallenge, $data);  

            if($this->Challenges->save($challenge)){
              echo "Challenge end Successfully";
              // $this->_triviaWinner($activeChallenge['id']);
              $this->_postWinnerOnFb($activeChallenge['id']);
              pr($challenge);
            }else{
              Log::config('error', $this->error());
            }      
          }
        }

        
      }


