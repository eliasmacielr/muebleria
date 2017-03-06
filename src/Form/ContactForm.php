<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Mailer\Email;
use Cake\Validation\Validator;

/**
 * Contact Form.
 */
class ContactForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', ['type' => 'string'])
            ->addField('email', ['type' => 'email'])
            ->addField('phone', ['type' => 'string'])
            ->addField('message', ['type' => 'string']);
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        return $validator
            ->notEmpty('name')
            ->notEmpty('email')
            ->email('email')
            ->notEmpty('phone')
            ->notEmpty('message');
    }

    /**
     * Defines what to execute once the From is being processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $contact)
    {
        $email = new Email('default');
        if (isset($contact['product']) && is_numeric($contact['product'])) {
            $contact['message'] = 'Esta interesado en el producto #' . $contact['product'];
        }
        $email->emailFormat('html')->template('contact')->viewVars($contact)
            ->subject($contact['title'])
            ->send();
        return true;
    }
}
