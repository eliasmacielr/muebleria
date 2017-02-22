<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * ProductSpecifications Controller
 *
 * @property \App\Model\Table\ProductSpecificationsTable $ProductSpecifications
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductSpecificationsController extends AppController
{
    public function initialize() {
        parent::initialize();

        $this->loadModel('Products');
    }

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
     * @param string|null $product_id_slug Product id or slug.
     * @return \Cake\Network\Response|null
     */
    public function index($product_id_slug = null)
    {
        $query = $this->ProductSpecifications->find();
        if (is_numeric($product_id_slug)) { // if is id
            $query->where(['ProductSpecifications.product_id' => $product_id_slug]);
        } else {
            $product = $this->Products->find()->select(['id'])->where(['Products.slug' => $product_id_slug])->firstOrFail();
            $query->where(['ProductSpecifications.product_id' => $product->id]);
        }
        $productSpecifications = $query;
        $status = true;

        $this->set(compact(['productSpecifications', 'status']));
        $this->set('_serialize', ['productSpecifications', 'status']);
    }

    /**
     * View method
     *
     * @param string|null $product_id Product id.
     * @param string|null $id Specification id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($product_id = null, $id = null)
    {
        $productSpecification = $this->ProductSpecifications->get($id);
        $status = true;
        $this->set(compact(['productSpecification', 'status']));
        $this->set('_serialize', ['productSpecification', 'status']);
    }

    /**
     * Add method
     *
     * @param string|null $product_id Product id.
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($product_id = null)
    {
        $productSpecification = $this->ProductSpecifications->patchEntity($this->ProductSpecifications->newEntity(), $this->request->data);
        if ($this->ProductSpecifications->save($productSpecification)) {
            $message = 'Se ha guardado el registro';
            $status = true;
        } else {
            $message = 'No se ha guardado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($productSpecification->errors());
        }

        $this->set(compact(['productSpecification', 'status', 'message', 'errors']));
        $this->set('_serialize', ['productSpecification', 'status', 'message', 'errors']);
    }

    /**
     * Edit method
     *
     * @param string|null $product_id Product id.
     * @param string|null $id Specification id.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($product_id = null, $id = null)
    {
        $productSpecification = $this->ProductSpecifications->patchEntity($this->ProductSpecifications->get($id), $this->request->data);
        if ($this->ProductSpecifications->save($productSpecification)) {
            $message = 'Se ha editado el registro';
            $status = true;
        } else {
            $message = 'No se ha editado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($productSpecification->errors());
        }
        $this->set(compact(['productSpecification', 'status', 'message', 'errors']));
        $this->set('_serialize', ['productSpecification', 'status', 'message', 'errors']);
    }

    /**
     * Delete method
     *
     * @param string|null $product_id Product id.
     * @param string|null $id Specification id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($product_id = null, $id = null)
    {
        $productSpecification = $this->ProductSpecifications->get($id);
        if ($this->ProductSpecifications->delete($productSpecification)) {
            $message = 'Se ha eliminado el registro';
            $status = true;
        } else {
            $message = 'No se ha eliminado el registro';
            $status = false;
        }
        $this->set(compact(['productSpecification', 'status', 'message']));
        $this->set('_serialize', ['productSpecification', 'status', 'message']);
    }
}
