<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FbPracticeInformation Entity
 *
 * @property int $id
 * @property string $practice_name
 * @property int $fb_page_id
 * @property int $buzzydoc_vendor_id
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\FbPage $fb_page
 * @property \App\Model\Entity\BuzzydocVendor $buzzydoc_vendor
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
}
