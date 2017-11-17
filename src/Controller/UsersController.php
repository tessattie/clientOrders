<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->set("roles", $this->Users->roles);
        $this->set("status", $this->Users->status);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $us = $this->Users->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->data['formtype'] == "2"){
                $us = $this->Users->patchEntity($us, $this->request->data);
                if ($this->Users->save($us)) {
                    $this->set('success', "The user has successfully been saved");
                    $us = $this->Users->newEntity();
                    $this->request->data = [];
                }else{
                    $this->set('errors', $us->errors());
                }
            }
            if($this->request->data['formtype'] == "1"){
                $usr = $this->Users->get($this->request->data['id'], [
                    'contain' => []
                ]);
                $usr = $this->Users->patchEntity($usr, $this->request->data);
                if ($this->Users->save($usr)) {
                    $this->set('success', "The user has successfully been saved");
                    $this->request->data = [];
                }else{
                    $this->set('modalToShow', "edit_user_".$usr->id);
                    $this->set('currentEdit', $usr);
                    $this->set('editerrors', $usr->errors());
                }
            }            
        }
        $this->set(compact('us', 'usr'));
        $users = $this->Users->find('all');
        $this->set(compact('user'));
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
        } else {
        }

        return $this->redirect(['action' => 'index']);
    }
}
