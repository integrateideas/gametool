<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;
use Cake\Core\Configure;
use App\Model\Entity\MediaFileUpload;

/**
 * MediaFileUploads Model
 *
 * @method \App\Model\Entity\MediaFileUpload get($primaryKey, $options = [])
 * @method \App\Model\Entity\MediaFileUpload newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MediaFileUpload[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MediaFileUpload|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MediaFileUpload patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MediaFileUpload[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MediaFileUpload findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MediaFileUploadsTable extends Table
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

        $this->setTable('media_file_uploads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
          'image_name' => [

            'path' => Configure::read('ImageUpload.uploadPathForMediaFileUploadImages'),

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
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->allowEmpty('image_path');

        $validator
            ->allowEmpty('image_name');

        $validator
            ->allowEmpty('is_deleted');

        return $validator;
    }
}
