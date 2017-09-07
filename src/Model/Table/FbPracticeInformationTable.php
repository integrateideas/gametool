<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FbPracticeInformation Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $FbPages
 * @property |\Cake\ORM\Association\BelongsTo $BuzzydocVendors
 * @property |\Cake\ORM\Association\HasMany $ChallengeWinners
 * @property |\Cake\ORM\Association\HasMany $UserChallengeResponses
 *
 * @method \App\Model\Entity\FbPracticeInformation get($primaryKey, $options = [])
 * @method \App\Model\Entity\FbPracticeInformation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FbPracticeInformation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FbPracticeInformation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FbPracticeInformation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FbPracticeInformation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FbPracticeInformation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FbPracticeInformationTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('fb_practice_information');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // $this->belongsTo('FbPages', [
        //     'foreignKey' => 'fb_page_id',
        //     'joinType' => 'INNER'
        // ]);
        // $this->belongsTo('BuzzydocVendors', [
        //     'foreignKey' => 'buzzydoc_vendor_id',
        //     'joinType' => 'INNER'
        // ]);
        $this->hasMany('ChallengeWinners', [
            'foreignKey' => 'fb_practice_information_id'
        ]);
        $this->hasMany('UserChallengeResponses', [
            'foreignKey' => 'fb_practice_information_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('practice_name')
            ->requirePresence('practice_name', 'create')
            ->notEmpty('practice_name');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['fb_page_id'], 'FbPages'));
        $rules->add($rules->existsIn(['buzzydoc_vendor_id'], 'BuzzydocVendors'));

        return $rules;
    }
}
