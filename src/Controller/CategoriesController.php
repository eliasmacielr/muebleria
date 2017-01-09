<?php
namespace App\Controller;

use PDOException;
use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $categories = $this->paginate($this->Categories);
        $status = true;

        $this->set(compact(['categories', 'status']));
        $this->set('_serialize', ['categories', 'status']);
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
        $category = $this->Categories->get($id);
        $status = true;
        $this->set(compact(['category', 'status']));
        $this->set('_serialize', ['category', 'status']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $category = $this->Categories->patchEntity($this->Categories->newEntity(), $this->request->data);
        if ($this->Categories->save($category)) {
            $message = 'Se ha guardado el registro';
            $status = true;
        } else {
            $message = 'No se ha guardado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($category->errors());
        }

        $this->set(compact(['category', 'status', 'message', 'errors']));
        $this->set('_serialize', ['category', 'status', 'message', 'errors']);
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
        $category = $this->Categories->patchEntity($this->Categories->get($id), $this->request->data);
        if ($this->Categories->save($category)) {
            $message = 'Se ha editado el registro';
            $status = true;
        } else {
            $message = 'No se ha editado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($category->errors());
        }
        $this->set(compact(['category', 'status', 'message', 'errors']));
        $this->set('_serialize', ['category', 'status', 'message', 'errors']);
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
        $category = $this->Categories->get($id);
        try {
            if ($this->Categories->delete($category)) {
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
        $this->set(compact(['category', 'status', 'message']));
        $this->set('_serialize', ['category', 'status', 'message']);
    }
}
