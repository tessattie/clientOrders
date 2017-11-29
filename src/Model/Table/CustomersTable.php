<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Customers Model
 *
 * @property \Cake\ORM\Association\HasMany $Contacts
 *
 * @method \App\Model\Entity\Customer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Customer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Customer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Customer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Customer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Customer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Customer findOrCreate($search, callable $callback = null, $options = [])
 */
class CustomersTable extends Table
{

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

        $this->table('customers');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Contacts', [
            'foreignKey' => 'customer_id'
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
            ->add('name', 'isValidName', [
            'rule' => function ($data, $provider) {
                $regex = "/^[a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,30}$/";
                if (preg_match($regex, $data)) {
                    return true;
                }
                return 'The name has unauthorized characters';
            }
            ]);

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username')
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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

        $validator
            ->integer('phone')
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');

        $validator
            ->allowEmpty('customer_message');

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
}
