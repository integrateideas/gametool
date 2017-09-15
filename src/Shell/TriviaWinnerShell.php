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
use Psy\Shell as PsyShell;

/**
 * Simple console wrapper around Psy\Shell.
 */
class TriviaWinnerShell extends Shell
{
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
    
    public function triviaWinner(){
        $this->loadModel('Challenges');
        $activeChallengeId = $this->Challenges->find()
                                            ->where(['is_active'=> 1])
                                            ->first()
                                            ->get('id');
        
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
                        'challenge_id' => $result->challenge_id,
                ];

        $newEntity = $this->ChallengeWinners->newEntity();
        $activeChallengeWinner = $this->ChallengeWinners->patchEntity($newEntity, $data);

        if($this->ChallengeWinners->save($activeChallengeWinner)){
            echo "Active Challenge Winner saved successfully";
        }else{
            echo "Something went wrong while saving data.";
        }       
    }
}
