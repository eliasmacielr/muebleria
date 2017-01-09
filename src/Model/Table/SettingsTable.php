<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Settings Model
 *
 * @method \App\Model\Entity\Setting get($primaryKey, $options = [])
 * @method \App\Model\Entity\Setting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Setting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Setting|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Setting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Setting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Setting findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SettingsTable extends Table
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

        $this->table('settings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->requirePresence('site_name', 'create')
            ->notEmpty('site_name');

        $validator
            ->requirePresence('site_cellphone', 'create')
            ->notEmpty('site_cellphone');

        $validator
            ->requirePresence('site_phone', 'create')
            ->notEmpty('site_phone');

        $validator
            ->requirePresence('site_email', 'create')
            ->notEmpty('site_email');

        $validator
            ->requirePresence('social_facebook', 'create')
            ->notEmpty('social_facebook');

        $validator
            ->requirePresence('social_twitter', 'create')
            ->notEmpty('social_twitter');

        $validator
            ->requirePresence('social_instagram', 'create')
            ->notEmpty('social_instagram');

        $validator
            ->boolean('site_active')
            ->requirePresence('site_active', 'create')
            ->notEmpty('site_active');

        return $validator;
    }
}
