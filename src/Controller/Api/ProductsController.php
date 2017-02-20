<?php
namespace App\Controller\Api;

use PDOException;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\Query;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
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
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'ProductImages' => function (Query $query) {
                    return $query->where(['ProductImages.main' => true]);
                },
                'Categories',
            ],
            'finder' => [
                'search' => $this->Products->filterParams($this->request->query),
            ]
        ];
        $products = $this->paginate($this->Products);
        $status = true;

        $this->set(compact(['products', 'status']));
        $this->set('_serialize', ['products', 'status']);
    }

    /**
     * View method
     *
     * @param string|null $id_slug Product id or slug.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id_slug = null)
    {
        $product = $this->Products->findByIdOrSlug($id_slug, $id_slug)->firstOrFail();
        $status = true;
        $this->set(compact(['product', 'status']));
        $this->set('_serialize', ['product', 'status']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void
     */
    public function add()
    {
        $product = $this->Products->patchEntity($this->Products->newEntity(), $this->request->data);
        if ($this->Products->save($product)) {
            $message = 'Se ha guardado el registro';
            $status = true;
        } else {
            $message = 'No se ha guardado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($product->errors());
        }

        $this->set(compact(['product', 'status', 'message', 'errors']));
        $this->set('_serialize', ['product', 'status', 'message', 'errors']);
    }

    /**
     * Edit method
     *
     * @param string|null $id_slug Product id or slug.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id_slug = null)
    {
        $product = $this->Products->findByIdOrSlug($id_slug, $id_slug)->firstOrFail();
        $product = $this->Products->patchEntity($product, $this->request->data);
        if ($this->Products->save($product)) {
            $message = 'Se ha editado el registro';
            $status = true;
        } else {
            $message = 'No se ha editado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($product->errors());
        }
        $this->set(compact(['product', 'status', 'message', 'errors']));
        $this->set('_serialize', ['product', 'status', 'message', 'errors']);
    }

    /**
     * Delete method
     *
     * @param string|null $id_slug Product id or slug.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id_slug = null)
    {
        $product = $this->Products->findByIdOrSlug($id_slug, $id_slug)->firstOrFail();
        try {
            if ($this->Products->delete($product)) {
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
        $this->set(compact(['product', 'status', 'message']));
        $this->set('_serialize', ['product', 'status', 'message']);
    }
    /**
     * Delete all method
     *
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteAll()
    {
        $products = $this->Products->find()->where(['id IN' => $this->request->data['ids']]);
        try {
            foreach ($products as $product) {
                $this->Products->delete($product);
            }
            $status = true;
            $message = 'Se han eliminado los registros';
        } catch (PDOException $e) {
            $status = false;
            $message = 'No se han eliminado los registros';
        }

        $this->set(compact(['products', 'status', 'message']));
        $this->set('_serialize', ['products', 'status', 'message']);
    }
}
