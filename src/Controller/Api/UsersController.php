<?php
namespace App\Controller\Api;

use PDOException;
use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);
        $status = true;

        $this->set(compact(['users', 'status']));
        $this->set('_serialize', ['users', 'status']);
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
        $user = $this->Users->get($id);
        $status = true;
        $this->set(compact(['user', 'status']));
        $this->set('_serialize', ['user', 'status']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $user = $this->Users->patchEntity($this->Users->newEntity(), $this->request->data);
        if ($this->Users->save($user)) {
            $message = 'Se ha guardado el registro';
            $status = true;
        } else {
            $message = 'No se ha guardado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($user->errors());
        }

        $this->set(compact(['user', 'status', 'message', 'errors']));
        $this->set('_serialize', ['user', 'status', 'message', 'errors']);
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
        $user = $this->Users->patchEntity($this->Users->get($id), $this->request->data);
        if ($this->Users->save($user)) {
            $message = 'Se ha editado el registro';
            $status = true;
        } else {
            $message = 'No se ha editado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($user->errors());
        }
        $this->set(compact(['user', 'status', 'message', 'errors']));
        $this->set('_serialize', ['user', 'status', 'message', 'errors']);
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
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $message = 'Se ha eliminado el registro';
            $status = true;
        } else {
            $message = 'No se ha eliminado el registro';
            $status = false;
        }
        $this->set(compact(['user', 'status', 'message']));
        $this->set('_serialize', ['user', 'status', 'message']);
    }
}
