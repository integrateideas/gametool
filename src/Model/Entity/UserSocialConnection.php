<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserSocialConnection Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $social_connection_id
 * @property string $social_connection_identifier
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $is_deleted
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\SocialConnection $social_connection
 */
class UserSocialConnection extends Entity
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
