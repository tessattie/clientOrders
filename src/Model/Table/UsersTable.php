<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
 */
class UsersTable extends Table
{

    public $roles = array(0 => "Admin", 1 => "Manager");

    public $status = array(0 => "Blocked", 1 => "Active");

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
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name')
            ->add('first_name', 'isValidFirstName', [
            'rule' => function ($data, $provider) {
                $regex = "/^[a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,30}$/";
                if (preg_match($regex, $data)) {
                    return true;
                }
                return 'The first name has unauthorized characters';
            }
        ]);

        $validator
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name')
            ->add('last_name', 'isValidFirstName', [
            'rule' => function ($data, $provider) {
                $regex = "/^[a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,30}$/";
                if (preg_match($regex, $data)) {
                    return true;
                }
                return 'The last name has unauthorized characters';
            }
        ]);

        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
            ->add('username', 'isValidUsername', [
            'rule' => function ($data, $provider) {
                $regex = "/^[A-Za-z][A-Za-z0-9.'-]{5,31}$/";
                if (preg_match($regex, $data)) {
                    return true;
                }
                return 'The username has unauthorized characters';
            }
        ]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password')
            ->add('password', [
            'compare' => [
                'rule' => ['compareWith', 'confirm_password'], 
                'message' => "This value must be the same as the password confirmation field"
            ]
        ])
            ->add('confirm_password', [
            'compare' => [
                'rule' => ['compareWith', 'password'], 
                'message' => "This value must be the same as the main password field"
            ]
        ]);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('role')
            ->requirePresence('role', 'create')
            ->notEmpty('role')
            ->add('role', 'isValidRole', [
            'rule' => function ($data, $provider) {
                if ($data >= 0 && $data <= 1) {
                    return true;
                }
                return 'This access type is invalid';
            }
        ]);

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status')
            ->add('status', 'isValidStatus', [
            'rule' => function ($data, $provider) {
                if ($data >= 0 && $data <= 1) {
                    return true;
                }
                return 'This status is invalid';
            }
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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
