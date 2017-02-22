<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use \Josegonzalez\Upload\Validation\DefaultValidation;

/**
 * ProductImages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\ProductImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProductImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductImage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductImagesTable extends Table
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

        $this->table('product_images');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'file_name' => [
                'keepFilesOnDelete' => false,
                'restoreValueOnFailure' => false,
                'path' => 'webroot{DS}resources{DS}{model}{DS}{field}{DS}',
                'fields' => [
                    'dir' => 'file_dir',
                ],
                'nameCallback' => function (array $data, array $settings) {
                    $ext = pathinfo($data['name'], PATHINFO_EXTENSION);
                    return Text::uuid().'-'.date('YmdHis').'.'.$ext;
                },
            ],
        ]);

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
        $validator->provider('upload', DefaultValidation::class);
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('file_name', 'create')
            ->notEmpty('file_name')
            ->add('file_name', 'fileCompletedUpload', [
                'rule' => 'isCompletedUpload',
                'message' => 'El archivo no se ha subido por completo',
                'provider' => 'upload'
            ])
            ->add('file_name', 'fileFileUpload', [
                'rule' => 'isFileUpload',
                'message' => 'No se encontró el archivo ha guardar',
                'provider' => 'upload'
            ])
            ->add('file_name', 'fileBelowMaxSize', [
                'rule' => ['isBelowMaxSize', 1024*1024],
                'message' => 'El archivo es muy grande se admite hasta 1MB',
                'provider' => 'upload'
            ])
            ->add('file_name', 'custom', [
                'rule' => function ($value, $context) {
                    return in_array($value['type'], ['image/jpeg', 'image/pjpeg', 'image/png']);
                },
                'message' => 'Solo se admiten archivos .jpg, .jpeg y .png',
            ]);

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
        $rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }

    /**
     * Call before save a entity
     * @param  Event           $event
     * @param  EntityInterface $entity
     * @param  ArrayObject     $options
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->query()->update($this->table())->set(['main' => false])->where(['product_id' => $entity->product_id, 'main' => true])->execute()->closeCursor();
        return true;
    }
}
