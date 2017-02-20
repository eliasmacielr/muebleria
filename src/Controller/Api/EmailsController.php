<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use App\Form\ContactForm;
use Cake\Event\Event;

/**
 * Email Controller
 */
class EmailsController extends AppController
{

    private $to = 'siac215@gmail.com';

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['send']);
    }

    public function send()
    {
        $contact = $this->request->data;
        $contact += ['title' => 'ClickMuebles.com.py - ' . $contact['email']];
        $contactForm = new ContactForm();
        if ($contactForm->execute($contact)) {
            $status = true;
        } else {
            $status = false;
            $errors = $this->ErrorAdapter->reduce($contactForm->errors());
        }
        $this->set(compact(['status', 'errors']));
        $this->set('_serialize', ['status', 'errors']);
    }
}
