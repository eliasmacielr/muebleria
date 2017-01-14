<?php
namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 */
class SettingsController extends AppController
{

    /**
     * View method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $setting = $this->Settings->find()->first();
        $status = true;
        $this->set(compact(['setting', 'status']));
        $this->set('_serialize', ['setting', 'status']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['put']);
        $setting = $this->Settings->patchEntity($this->Settings->find()->first(), $this->request->data);
        if ($this->Settings->save($setting)) {
            $message = 'Se ha editado el registro';
            $status = true;
        } else {
            $message = 'No se ha editado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($setting->errors());
        }
        $this->set(compact(['setting', 'status', 'message', 'errors']));
        $this->set('_serialize', ['setting', 'status', 'message', 'errors']);
    }
}
