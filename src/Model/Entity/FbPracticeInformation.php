<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * FbPracticeInformation Entity
 *
 * @property int $id
 * @property string $practice_name
 * @property string $page_id
 * @property string $page_name
 * @property int $user_id
 * @property int $buzzydoc_vendor_id
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ChallengeWinner[] $challenge_winners
 * @property \App\Model\Entity\UserChallengeResponse[] $user_challenge_responses
 */
class FbPracticeInformation extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    
    protected function _getImageUrl()
    {
        if(isset($this->_properties['image_name']) && !empty($this->_properties['image_name'])) {
            $url = Router::url('/challenge_images/'.$this->_properties['image_name'],true);
        }else{
            $url = Router::url('/img/default-img.jpeg',true);
        }
        return $url;

    }
}
