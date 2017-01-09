<?php
namespace App\Controller;

use PDOException;
use App\Controller\AppController;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $products = $this->paginate($this->Products);
        $status = true;

        $this->set(compact(['products', 'status']));
        $this->set('_serialize', ['products', 'status']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id);
        $status = true;
        $this->set(compact(['product', 'status']));
        $this->set('_serialize', ['product', 'status']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $product = $this->Products->patchEntity($this->Products->newEntity(), $this->request->data);
        if ($this->Products->save($product)) {
            $message = 'Se ha guardado el registro';
            $status = true;
        } else {
            $message = 'No se ha guardado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($product->errors());
        }

        $this->set(compact(['product', 'status', 'message', 'errors']));
        $this->set('_serialize', ['product', 'status', 'message', 'errors']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['put']);
        $product = $this->Products->patchEntity($this->Products->get($id), $this->request->data);
        if ($this->Products->save($product)) {
            $message = 'Se ha editado el registro';
            $status = true;
        } else {
            $message = 'No se ha editado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($product->errors());
        }
        $this->set(compact(['product', 'status', 'message', 'errors']));
        $this->set('_serialize', ['product', 'status', 'message', 'errors']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        try {
            if ($this->Products->delete($product)) {
                $message = 'Se ha eliminado el registro';
                $status = true;
            } else {
                $message = 'No se ha eliminado el registro';
                $status = false;
            }
        } catch (PDOException $e) {
            $message = 'No se ha eliminado el registro, existen otros registros que dependen de él';
            $status = false;
        }
        $this->set(compact(['product', 'status', 'message']));
        $this->set('_serialize', ['product', 'status', 'message']);
    }
}
