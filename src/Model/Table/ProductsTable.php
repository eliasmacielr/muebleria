<?php
namespace App\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;
use Search\Model\Filter\Callback;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Association\HasMany $ProductImages
 * @property \Cake\ORM\Association\HasMany $ProductSpecifications
 *
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
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

        $this->table('products');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Slug.Slug', [
            'displayField' => 'name',
            'onUpdate' => true,
        ]);
        $this->addBehavior('Search.Search');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ProductImages', [
            'foreignKey' => 'product_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('ProductSpecifications', [
            'foreignKey' => 'product_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->maxLength('name', 50, "El campo admite hasta 50 caracteres")
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Ya existe otro producto con ese nombre']);

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description')
            ->maxLength('description', 1000, "El campo admite hasta 1000 caracteres");

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->notEmpty('price');

        $validator
            ->integer('stock')
            ->requirePresence('stock', 'create')
            ->notEmpty('stock');

        $validator
            ->boolean('in_offer');

        $validator
            ->integer('discount');

        $validator
            ->integer('category_id')
            ->requirePresence('category_id', 'create');

        $validator
            ->boolean('available');

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
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));

        return $rules;
    }

    /**
     * Search Manager configuration
     * @return \Search\Manager
     */
    public function searchConfiguration()
    {
        $search = new Manager($this);
        $search->like('name', [
            'before' => true,
            'after' => true,
            'filterEmpty' => true,
        ]);
        $search->compare('lte', [
            'field' => 'price',
            'operator' => '<=',
            'filterEmpty' => true,
        ]);
        $search->compare('gte', [
            'field' => 'price',
            'operator' => '>=',
            'filterEmpty' => true,
        ]);
        $search->callback('btw', [
            'callback' => function (Query $query, array $args, Callback $filter) {
                $prices = explode(',', $args['btw']);
                sort($prices, SORT_NUMERIC);
                $query->where(function (QueryExpression $expression, Query $query) use ($prices) {
                    return $expression->between('price', $prices[0], $prices[1]);
                });
            },
            'filterEmpty' => true,
        ]);
        $search->callback('discount', [
            'callback' => function (Query $query, array $args, Callback $filter) {
                $discounts = explode(',', $args['discount']);
                sort($discounts, SORT_NUMERIC);
                $query->where(function (QueryExpression $expression, Query $query) use ($discounts) {
                    return $expression->between('discount', $discounts[0], $discounts[1]);
                });
            },
            'filterEmpty' => true,
        ]);
        $search->value('category_id', [
            'multiValue' => true,
            'filterEmpty' => true,
        ]);
        $search->value('available', [
            'multiValue' => true,
            'filterEmpty' => true,
        ]);
        $search->value('in_offer', [
            'multiValue' => true,
            'filterEmpty' => true,
        ]);
        $search->like('search', [
            'before' => true,
            'after' => true,
            'filterEmpty' => true,
            'field' => [
                'Products.name',
                'Products.description',
            ]
        ]);
        $search->value('category_slug', [
            'multiValue' => true,
            'filterEmpty' => true,
            'field' => 'Categories.slug',
        ]);
        return $search;
    }
}
