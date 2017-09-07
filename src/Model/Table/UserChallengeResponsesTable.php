<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserChallengeResponses Model
 *
 * @property \App\Model\Table\ChallengesTable|\Cake\ORM\Association\BelongsTo $Challenges
 * @property |\Cake\ORM\Association\BelongsTo $FbPracticeInformations
 *
 * @method \App\Model\Entity\UserChallengeResponse get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserChallengeResponse newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserChallengeResponse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserChallengeResponse|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserChallengeResponse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserChallengeResponse[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserChallengeResponse findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserChallengeResponsesTable extends Table
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

        $this->setTable('user_challenge_responses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Challenges', [
            'foreignKey' => 'challenge_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('FbPracticeInformation', [
            'foreignKey' => 'fb_practice_information_id',
            'joinType' => 'INNER'
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
            ->scalar('identifier_type')
            ->requirePresence('identifier_type', 'create')
            ->notEmpty('identifier_type');

        $validator
            ->scalar('identifier_value')
            ->requirePresence('identifier_value', 'create')
            ->notEmpty('identifier_value');

        $validator
            ->scalar('response')
            ->requirePresence('response', 'create')
            ->notEmpty('response');

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
        $rules->add($rules->existsIn(['challenge_id'], 'Challenges'));
        $rules->add($rules->existsIn(['fb_practice_information_id'], 'FbPracticeInformation'));

        return $rules;
    }
}
