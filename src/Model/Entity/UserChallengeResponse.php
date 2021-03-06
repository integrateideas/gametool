<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserChallengeResponse Entity
 *
 * @property int $id
 * @property int $identifier_type
 * @property int $identifier_value
 * @property int $challenge_id
 * @property string $response
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $fb_practice_information_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Challenge $challenge
 * @property \App\Model\Entity\FbPracticeInformation $fb_practice_information
 */
class UserChallengeResponse extends Entity
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
}
