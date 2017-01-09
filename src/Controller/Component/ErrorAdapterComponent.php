<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * ErrorAdapter component. Adapt model validations errors
 */
class ErrorAdapterComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function reduce(array $errors)
    {
        return collection($errors)->map(function ($value, $key) {
            return array_pop($value);
        })->toArray();
    }
}
