<?php
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Admin side Controller.
 */
class AdminController extends Controller
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index()
    {
        $this->viewBuilder()
            ->layout('angular')
            ->templatePath('Pages')
            ->template('admin');
    }
}
