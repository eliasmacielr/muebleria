<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Authorization Controller.
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class AuthController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Users');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login']);
    }

    public function login()
    {
        $this->request->allowMethod(['post']);
        $user = $this->Users->find()->where(['username' => $this->request->data('username')])->firstOrFail();

        $hasher = new DefaultPasswordHasher();
        if ($hasher->check($this->request->data('password'), $user->password)) {
            $status = true;
            // Disable hide api_key property
            $user->hiddenProperties(array_diff($user->hiddenProperties(), ['api_key']));
        } else {
            $status = false;
        }

        $this->set(compact(['user', 'status']));
        $this->set('_serialize', ['user', 'status']);
    }
}
