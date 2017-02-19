<?php
namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Access control. Check Denied case
     * @param  array $user
     * @return bool
     */
    public function isAuthorized(array $user)
    {
        // It is widely used
        $request = $this->request;

        // If request index and user is not staff
        if ($request->params['action'] === 'index' && $user['role'] !== 'staff') {
            return true;
        }

        if ($request->param('id')) {
            // Only sadmin can access
            if ($request->params['id'] == 1 && $user['id'] == 1) {
                return true;
            }
        }

        // If request view
        if ($request->params['action'] === 'view') {
            // Staff users can only access their own registry
            if ($user['role'] === 'staff' && $user['id'] == $request->params['id']) {
                return true;
            }
            // Users super-admin and admin can access but not to sadmin record
            if (in_array($user['role'], ['super-admin', 'admin']) && $request->params['id'] != 1) {
                return true;
            }
        }

        // If request add, edit and delete
        if (in_array($request->params['action'], ['add', 'edit', 'delete'])) {
            // Only super-admin and admin allowed
            if (in_array($user['role'], ['super-admin', 'admin'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'limit' => $this->request->query('limit') ?: 10,
            'sort' => $this->request->query('sort') ?: 'name',
            'direction' => $this->request->query('direction') ?: 'asc',
        ];
        $query = $this->Users->find('filterRole', ['user' => $this->Auth->user()])->find('search', $this->Users->filterParams($this->request->query));
        $users = $this->paginate($query);
        $status = true;

        $this->set(compact(['users', 'status']));
        $this->set('_serialize', ['users', 'status']);
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
        $user = $this->Users->get($id);
        $status = true;
        $this->set(compact(['user', 'status']));
        $this->set('_serialize', ['user', 'status']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
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
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ($this->request->data('password') == null) {
            unset($this->request->data['password']);
        }
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
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
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
