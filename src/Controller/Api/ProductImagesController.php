<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * ProductImages Controller
 *
 * @property \App\Model\Table\ProductImagesTable $ProductImages
 */
class ProductImagesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index', 'view']);
    }

    /**
     * Access Control. All Granted
     *
     * @param  array   $user
     * @return bool
     */
    public function isAuthorized(array $user)
    {
        return true;
    }

    /**
     * Index method
     *
     * @param string|null $product_id Product id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function index($product_id = null)
    {
        $productImages = $this->ProductImages->find()->where(['ProductImages.product_id' => $product_id]);
        $status = true;
        $this->set(compact(['productImages', 'status']));
        $this->set('_serialize', ['productImages', 'status']);
    }

    /**
     * View method
     *
     * @param string|null $product_id Product id.
     * @param string|null $id Image id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($product_id = null, $id = null)
    {
        $productImage = $this->ProductImages->get($id);
        $status = true;
        $this->set(compact(['productImage', 'status']));
        $this->set('_serialize', ['productImage', 'status']);
    }

    /**
     * Add method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function add($product_id = null)
    {
        $this->request->allowMethod(['post']);
        $this->request->data['product_id'] = $product_id;
        $productImage = $this->ProductImages->patchEntity($this->ProductImages->newEntity(), $this->request->data);
        if ($this->ProductImages->save($productImage)) {
            $message = 'Se ha agregado el registro';
            $status = true;
        } else {
            $message = 'No se ha agregado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($productImage->errors());
        }
        $this->set(compact(['productImage', 'status', 'message', 'errors']));
        $this->set('_serialize', ['productImage', 'status', 'message', 'errors']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @param string|null $id Image id.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($product_id = null, $id = null)
    {
        $this->request->allowMethod(['put']);
        $productImage = $this->ProductImages->get($id);
        $productImage->set('main', true);
        if ($this->ProductImages->save($productImage)) {
            $message = 'Se ha editado el registro';
            $status = true;
        } else {
            $message = 'No se ha editado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($productImage->errors());
        }
        $this->set(compact(['productImage', 'status', 'message', 'errors']));
        $this->set('_serialize', ['productImage', 'status', 'message', 'errors']);
    }

    /**
     * Delete method
     *
     * @param string|null $product_id Product id.
     * @param string|null $id Image id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($product_id = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productImage = $this->ProductImages->get($id);
        if ($this->ProductImages->delete($productImage)) {
            $message = 'Se ha eliminado el registro';
            $status = true;
        } else {
            $message = 'No se ha eliminado el registro';
            $status = false;
        }
        $this->set(compact(['productImage', 'status', 'message']));
        $this->set('_serialize', ['productImage', 'status', 'message']);
    }
}
