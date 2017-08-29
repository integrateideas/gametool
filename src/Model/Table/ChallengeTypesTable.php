<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChallengeTypes Model
 *
 * @property \App\Model\Table\ChallengesTable|\Cake\ORM\Association\HasMany $Challenges
 *
 * @method \App\Model\Entity\ChallengeType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChallengeType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ChallengeType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChallengeType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChallengeType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChallengeType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChallengeType findOrCreate($search, callable $callback = null, $options = [])
 */
class ChallengeTypesTable extends Table
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

        $this->setTable('challenge_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Challenges', [
            'foreignKey' => 'challenge_type_id'
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
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
