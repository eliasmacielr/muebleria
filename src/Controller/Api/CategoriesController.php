<?php

namespace App\Controller\Api;

use PDOException;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Categories Controller.
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
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
     * Index method.
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'limit' => $this->request->query('limit') ?: 10,
            'sort' => $this->request->query('sort') ?: 'name',
            'direction' => $this->request->query('direction') ?: 'asc',
            'finder' => [
                'search' => $this->Categories->filterParams($this->request->query),
            ],
        ];

        $paged = $this->request->query('paged') !== null ? $this->request->query('paged') : true;
        if ($paged) {
            $categories = $this->paginate($this->Categories);
        } else {
            $categories = $this->Categories->find()->orderAsc('name');
        }

        $status = true;

        $this->set(compact(['categories', 'status']));
        $this->set('_serialize', ['categories', 'status']);
    }

    /**
     * View method.
     *
     * @param string|null $id_slug Category id or slug
     *
     * @return \Cake\Network\Response|null
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found
     */
    public function view($id_slug = null)
    {
        $category = $this->Categories->findByIdOrSlug($id_slug, $id_slug)->firstOrFail();
        $status = true;
        $this->set(compact(['category', 'status']));
        $this->set('_serialize', ['category', 'status']);
    }

    /**
     * Add method.
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise
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
     * Edit method.
     *
     * @param string|null $id Category id or slug
     *
     * @return \Cake\Network\Response|void
     *
     * @throws \Cake\Network\Exception\NotFoundException When record not found
     */
    public function edit($id_slug = null)
    {
        $this->request->allowMethod(['put']);
        $category = $this->Categories->findByIdOrSlug($id_slug, $id_slug)->firstOrFail();
        $category = $this->Categories->patchEntity($category, $this->request->data);
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
     * Delete method.
     *
     * @param string|null $id Category id or slug
     *
     * @return \Cake\Network\Response|null
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found
     */
    public function delete($id_slug = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->findByIdOrSlug($id_slug, $id_slug)->firstOrFail();
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
