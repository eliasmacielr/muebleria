<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductSpecifications Model.
 *
 * @property \Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\ProductSpecification get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductSpecification newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProductSpecification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductSpecification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductSpecification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductSpecification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductSpecification findOrCreate($search, callable $callback = null, $options = [])
 */
class ProductSpecificationsTable extends Table
{
    /**
     * Initialize method.
     *
     * @param array $config The configuration for the Table
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('product_specifications');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => ['validateUnique', ['scope' => 'product_id']], 'provider' => 'table', 'message' => 'Ya existe la especificación para el producto']);

        $validator
            ->requirePresence('value', 'create')
            ->notEmpty('value');

        $validator
            ->requirePresence('product_id', 'create')
            ->notEmpty('product_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified
     *
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }
}
