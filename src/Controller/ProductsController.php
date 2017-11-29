<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->set("status", $this->Products->status);
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $brands = $this->Products->Brands->find('list', ['limit' => 200]);
        $prd = $this->Products->newEntity();
        $this->paginate = [
            'contain' => ['Brands']
        ];
        if ($this->request->is(['put', 'post'])) {
            if($this->request->data['formtype'] == "2"){
                unset($this->request->data['featured_image']);
                $prd = $this->Products->patchEntity($prd, $this->request->data);
                $prd->UPC = $this->completeValue($prd->UPC, 15);
                $prd->featured_image = $this->checkFile($_FILES['featured_image'], $prd->UPC, 'products');
                if ($this->Products->save($prd)) {
                    $this->set('success', "The product has successfully been saved");
                    $prd = $this->Products->newEntity();
                    $this->request->data = [];
                }else{
                    $this->set('errors', $prd->errors());
                }
            }else{
               if($this->request->data['formtype'] == "1"){
                    unset($this->request->data['featured_image']);
                    $prd = $this->Products->get($this->request->data['id'], [
                        'contain' => []
                    ]);
                    $featured_image = false;
                    if(!empty($_FILES['featured_image']['name'])){
                        $featured_image = $this->checkFile($_FILES['featured_image'], $prd->UPC, 'products');
                    }
                    $prd = $this->Products->patchEntity($prd, $this->request->data);
                    $prd->UPC = $this->completeValue($prd->UPC, 15);
                    if($featured_image != false){
                        $prd->featured_image = $featured_image;
                    }
                    if ($this->Products->save($prd)) {
                        $this->set('success', "The product has successfully been saved");
                        $this->request->data = [];
                        $prd = $this->Products->newEntity();
                    }else{
                        $this->set('modalToShow', "edit_product_".$prd->id);
                        $this->set('currentEdit', $prd);
                        $this->set('editerrors', $prd->errors());
                    }
                }  
            }
        }
        
        $products = $this->paginate($this->Products);
        $this->set(compact('products', 'prd', 'brands'));
        $this->set('_serialize', ['products']);
    }

    public function importExcel(){
        if ($this->request->is(['put', 'post'])) {
                debug($_FILES); 
                debug($this->request->data);
        }
         
    }

    private function completeValue($val, $length){
        $total = $length;
        $value = '';
        $amount = strlen($val);
        $toadd = $total - (int)$amount;
        for($i=0;$i<$toadd;$i++){
            $value .= "0";
        }
        return $value.$val;
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Brands']
        ]);

        $this->set('product', $product);
        $this->set('_serialize', ['product']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->data);
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $brands = $this->Products->Brands->find('list', ['limit' => 200]);
        $this->set(compact('product', 'brands'));
        $this->set('_serialize', ['product']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->data);
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $brands = $this->Products->Brands->find('list', ['limit' => 200]);
        $this->set(compact('product', 'brands'));
        $this->set('_serialize', ['product']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete', 'get']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
