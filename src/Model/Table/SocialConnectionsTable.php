<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SocialConnections Model
 *
 * @property \App\Model\Table\UserSocialConnectionsTable|\Cake\ORM\Association\HasMany $UserSocialConnections
 *
 * @method \App\Model\Entity\SocialConnection get($primaryKey, $options = [])
 * @method \App\Model\Entity\SocialConnection newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SocialConnection[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SocialConnection|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SocialConnection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SocialConnection[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SocialConnection findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SocialConnectionsTable extends Table
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

        $this->setTable('social_connections');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('UserSocialConnections', [
            'foreignKey' => 'social_connection_id'
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

        $validator
            ->scalar('label')
            ->requirePresence('label', 'create')
            ->notEmpty('label');

        $validator
            ->boolean('status')
            ->allowEmpty('status');

        $validator
            ->dateTime('is_deleted')
            ->allowEmpty('is_deleted');

        return $validator;
    }
}
