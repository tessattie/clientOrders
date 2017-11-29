<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Brands Controller
 *
 * @property \App\Model\Table\BrandsTable $Brands
 */
class BrandsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $brd = $this->Brands->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->data['formtype'] == "2"){
                $featured_image = false;
                if(!empty($_FILES['featured_image']['name'])){
                    $featured_image = $this->checkFile($_FILES['featured_image'], $this->request->data['name'], 'brands');
                }
                $brd = $this->Brands->patchEntity($brd, $this->request->data);
                if($featured_image != false){
                    $brd->featured_image = $featured_image;
                }
                if ($this->Brands->save($brd)) {
                    $this->set('success', "The brand has successfully been saved");
                    $brd = $this->Brands->newEntity();
                    $this->request->data = [];
                }else{
                    $this->set('errors', $brd->errors());
                }
            }
            if($this->request->data['formtype'] == "1"){
                unset($this->request->data['featured_image']);
                $brd = $this->Brands->get($this->request->data['id'], [
                    'contain' => []
                ]);
                $featured_image = false;
                if(!empty($_FILES['featured_image']['name'])){
                    $featured_image = $this->checkFile($_FILES['featured_image'], $brd->name, 'brands');
                }
                $brd = $this->Brands->patchEntity($brd, $this->request->data);
                if($featured_image != false){
                    $brd->featured_image = $featured_image;
                }
                if ($this->Brands->save($brd)) {
                    $this->set('success', "The brand has successfully been saved");
                    $this->request->data = [];
                    $brd = $this->Brands->newEntity();
                }else{
                    $this->set('modalToShow', "edit_user_".$brd->id);
                    $this->set('currentEdit', $brd);
                    $this->set('editerrors', $brd->errors());
                }
            }            
        }
        $brands = $this->paginate($this->Brands);

        $this->set(compact('brands', 'brd'));
        $this->set('_serialize', ['brands']);
    }

    /**
     * View method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $brand = $this->Brands->get($id, [
            'contain' => ['Products']
        ]);

        $this->set('brand', $brand);
        $this->set('_serialize', ['brand']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $brand = $this->Brands->newEntity();
        if ($this->request->is('post')) {
            $brand = $this->Brands->patchEntity($brand, $this->request->data);
            if ($this->Brands->save($brand)) {
                $this->Flash->success(__('The brand has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The brand could not be saved. Please, try again.'));
        }
        $this->set(compact('brand'));
        $this->set('_serialize', ['brand']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $brand = $this->Brands->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $brand = $this->Brands->patchEntity($brand, $this->request->data);
            if ($this->Brands->save($brand)) {
                $this->Flash->success(__('The brand has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The brand could not be saved. Please, try again.'));
        }
        $this->set(compact('brand'));
        $this->set('_serialize', ['brand']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $brand = $this->Brands->get($id);
        if ($this->Brands->delete($brand)) {
            $this->Flash->success(__('The brand has been deleted.'));
        } else {
            $this->Flash->error(__('The brand could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
