<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Search\Manager;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
    }

    /**
     * Create and hash api_key
     *
     * @param  Event           $event
     * @param  EntityInterface $entity
     * @param  ArrayObject     $options
     * @return bool
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew() || $entity->dirty('password')) {
            $hasher = new DefaultPasswordHasher();
            $entity->api_key = Text::uuid();
            $entity->api_key_hash = $hasher->hash($entity->api_key);
        }

        return true;
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
            ->maxLength('name', 50, "El campo admite hasta 50 caracteres");

        $validator
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name')
            ->maxLength('last_name', 50, "El campo admite hasta 50 caracteres");

        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username')
            ->maxLength('username', 20, "El campo admite hasta 20 caracteres")
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Nombre de usuario no disponible'])
            ->add('username', 'custom', [
                'rule' => [$this, 'checkUsername'],
                'message' => 'Nombre de usuario es incorrecto',
                'provider' => 'table',
            ]);

        $validator
            ->requirePresence('password', 'create')
            ->maxLength('password', 50, "El campo admite hasta 50 caracteres")
            ->minLength('password', 6, "El campo requiere de almenos 6 caracteres")
            ->notEmpty('password');

        $validator
            ->requirePresence('role', 'create')
            ->notEmpty('role');

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
        $rules->add($rules->isUnique(['username']));

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
        $search->like('last_name', [
            'before' => true,
            'after' => true,
            'filterEmpty' => true,
        ]);
        $search->like('username', [
            'before' => true,
            'after' => true,
            'filterEmpty' => true,
        ]);
        $search->value('role', [
            'filterEmpty' => true,
        ]);
        return $search;
    }

    /**
     * Check if the username is in the form of username[0975]
     *
     * @param  string $username
     * @param  array  $context
     * @return bool
     */
    public function checkUsername($username, array $context)
    {
        return (boolean) preg_match("/^[a-z][a-z0-9]+$/", $username);
    }

    /**
     * Filter users. Hide super-admin user and current user.
     *
     * @param  Query  $query
     * @param  array  $options
     * @return \Cake\ORM\Query
     */
     public function findFilterRole(Query $query, array $options)
     {
         if ($options['user']['role'] === 'super-admin') {
             return $query->where([$this->aliasField('username').' !=' => 'sadmin']);
         } elseif ($options['user']['role'] === 'admin') {
             return $query->where([$this->aliasField('role').' !=' => 'super-admin']);
         }
         return $query->where([$this->aliasField('role').' !=' => 'super-admin'])->where([$this->aliasField('role').' !=' => 'admin']);
     }
}
