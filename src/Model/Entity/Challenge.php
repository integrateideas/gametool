<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Challenge Entity
 *
 * @property int $id
 * @property int $challenge_type_id
 * @property string $name
 * @property string $details
 * @property string $response
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ChallengeType $challenge_type
 * @property \App\Model\Entity\UserChallengeResponse[] $user_challenge_responses
 */
class Challenge extends Entity
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
