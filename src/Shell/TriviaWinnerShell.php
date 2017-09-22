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
use Psy\Shell as PsyShell;
use Cake\Core\Configure;



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
    
    private  function _triviaWinner($activeChallengeId){
        // $this->FbGraphApi =  new FbGraphApiComponent(new ComponentRegistry(), []);
        // $this->loadComponent('FbGraphApi'); 
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
      }

      $data = [
      'fb_practice_information_id' => $result->fb_practice_information_id,
      'identifier_type' => $result->identifier_type,
      'identifier_value' => $result->identifier_value,
      'challenge_id' => $activeChallengeId,
      ];

      $newEntity = $this->ChallengeWinners->newEntity();
      $activeChallengeWinner = $this->ChallengeWinners->patchEntity($newEntity, $data);
      if($this->ChallengeWinners->save($activeChallengeWinner)){
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

      $pageId =$winner->fb_practice_information->page_id; 
      $url = "/$pageId/feed";
      $data = [
      'message'=>'Winner of the challenge named '.$activeChallenge->name .'is: '.$winner->identifier_value,
      ];
      $response =  $this->_fb->post($url,$data, $winner->fb_practice_information->page_token);
    }
  }

   public function endChallenge(){
     $this->loadModel('Challenges');

      $activeChallenge = $this->Challenges->find()
                                         ->where(['is_active'=> 1])
                                         ->first();
      // pr($activeChallenge);die;
                                         if(!$activeChallenge){
                                          return false;
                                         }
      $currentTime = date('Y-m-d H:i:s');
      $currentTime = strtotime($currentTime);

      $activeChallengeEndTime = $activeChallenge['end_time'];
      $activeChallengeEndTime = strtotime($activeChallengeEndTime);
      if($currentTime >= $activeChallengeEndTime){
          
          $data = [
                    'id' => $activeChallenge['id'],
                    'is_active' => 0
                  ];
          $challenge = $this->Challenges->patchEntity($activeChallenge, $data);  

          if($this->Challenges->save($challenge)){
                echo "Challenge end Successfully";
                $this->_triviaWinner($activeChallenge['id']);
                $this->_postWinnerOnFb($activeChallenge['id']);
            }else{
                Log::config('error', $this->error());
          }      
      }
  }
}


