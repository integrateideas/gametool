<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;
use Cake\Core\Configure;
use App\Model\Entity\Challenge;
/**
 * Challenges Model
 *
 * @property \App\Model\Table\ChallengeTypesTable|\Cake\ORM\Association\BelongsTo $ChallengeTypes
 * @property \App\Model\Table\UserChallengeResponsesTable|\Cake\ORM\Association\HasMany $UserChallengeResponses
 *
 * @method \App\Model\Entity\Challenge get($primaryKey, $options = [])
 * @method \App\Model\Entity\Challenge newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Challenge[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Challenge|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Challenge patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Challenge[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Challenge findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChallengesTable extends Table
{

   protected function _initializeSchema(TableSchema $schema){
        
        $schema->columnType('details', 'json');
        return $schema;
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('challenges');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ChallengeTypes', [
            'foreignKey' => 'challenge_type_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('UserChallengeResponses', [
            'foreignKey' => 'challenge_id'
        ]);
         $this->addBehavior('Josegonzalez/Upload.Upload', [
          'image_name' => [

            'path' => Configure::read('ImageUpload.uploadPathForChallengeImages'),

            'fields' => [
              'dir' => 'image_path'
            ],
            'nameCallback' => function ($data, $settings) {
              return time(). $data['name'];
            },
          ],
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
            ->scalar('instruction')
            ->requirePresence('instruction', 'create')
            ->notEmpty('instruction');

        // $validator
        //     ->scalar('details')
        //     ->allowEmpty('details');
        $validator
            ->allowEmpty('image_path');

        $validator
            ->allowEmpty('image_name');
        
        $validator
            ->scalar('response')
            ->allowEmpty('response');

        $validator
            ->boolean('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active');

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
        $rules->add($rules->existsIn(['challenge_type_id'], 'ChallengeTypes'));

        return $rules;
    }
}
