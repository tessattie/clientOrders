<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->set("status", $this->Customers->status);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $cust = $this->Customers->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])){
            if($this->request->data['formtype'] == "2"){
                $cust = $this->Customers->patchEntity($cust, $this->request->data);
                if ($this->Customers->save($cust)) {
                    $this->set('success', "The customer has successfully been saved");
                    $cust = $this->Customers->newEntity();
                    $this->request->data = [];
                }else{
                    $this->set('errors', $cust->errors());
                }
            }
            if($this->request->data['formtype'] == "1"){
                $cust = $this->Customers->get($this->request->data['id'], [
                    'contain' => []
                ]);
                $cust = $this->Customers->patchEntity($cust, $this->request->data);
                if ($this->Customers->save($cust)) {
                    $this->set('success', "The user has successfully been saved");
                    $this->request->data = [];
                    $cust = $this->Customers->newEntity();
                }else{
                    $this->set('modalToShow', "edit_customer_".$cust->id);
                    $this->set('currentEdit', $cust);
                    $this->set('editerrors', $cust->errors());
                    $cust = $this->Customers->newEntity();
                }
            }            
        }
        $customers = $this->paginate($this->Customers);
        $this->set(compact('customers', 'cust'));
        $this->set('_serialize', ['customers']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['Contacts']
        ]);

        $this->set('customer', $customer);
        $this->set('_serialize', ['customer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->Customers->newEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->data);
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->data);
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
        } else {
        }

        return $this->redirect(['action' => 'index']);
    }
}
