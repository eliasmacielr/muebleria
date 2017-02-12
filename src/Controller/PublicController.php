<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Network\Exception\NotFoundException;

/**
 * Public side Controller.
 *
 * @property \App\Model\Table\SettingsTable $Settings
 */
class PublicController extends Controller
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadModel('Settings');

        $settings = $this->Settings->find()->firstOrFail();

        if ($settings->site_active == false)
        {
            throw new NotFoundException('El sitio no esta disponible por el momento');
        }
    }

    public function index()
    {
        $this->viewBuilder()
            ->layout('angular')
            ->templatePath('Pages');
    }
}
