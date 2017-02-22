<?php
namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\Query;

/**
 * ProductImages Controller
 *
 * @property \App\Model\Table\ProductImagesTable $ProductImages
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductImagesController extends AppController
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
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function index($product_id_slug = null)
    {
        $query = $this->ProductImages->find();
        if (is_numeric($product_id_slug)) { // if is id
            $query->where(['ProductImages.product_id' => $product_id_slug]);
        } else {
            $product = $this->Products->find()->select(['id'])->where(['Products.slug' => $product_id_slug])->firstOrFail();
            $query->where(['ProductImages.product_id' => $product->id]);
        }
        $productImages = $query->orderDesc('ProductImages.main');

        $status = true;
        $this->set(compact(['productImages', 'status']));
        $this->set('_serialize', ['productImages', 'status']);
    }

    /**
     * View method
     *
     * @param string|null $product_id Product id.
     * @param string|null $id Image id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($product_id = null, $id = null)
    {
        $productImage = $this->ProductImages->get($id);
        $status = true;
        $this->set(compact(['productImage', 'status']));
        $this->set('_serialize', ['productImage', 'status']);
    }

    /**
     * Add method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function add($product_id = null)
    {
        // if no error when upload
        if (!empty($this->request->data['file_name']) && $this->request->data['file_name']['error'] === UPLOAD_ERR_OK) {
            $this->request->data['product_id'] = $product_id;
            $productImage = $this->ProductImages->patchEntity($this->ProductImages->newEntity(), $this->request->data);
            if ($this->ProductImages->save($productImage)) {
                $message = 'Se ha agregado el registro';
                $status = true;
            } else {
                $message = 'No se ha agregado el registro';
                $status = false;
                $errors = $this->ErrorAdapter->reduce($productImage->errors());
            }
        } else {
            $status = false;
            $message = "Ocurrio un error al intentar subir el archivo, verifique el tamaño máximo de 1MB y si es .jpg o .png";
        }

        $this->set(compact(['productImage', 'status', 'message', 'errors']));
        $this->set('_serialize', ['productImage', 'status', 'message', 'errors']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @param string|null $id Image id.
     * @return \Cake\Network\Response|void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($product_id = null, $id = null)
    {
        $productImage = $this->ProductImages->get($id);
        $productImage->set('main', true);
        if ($this->ProductImages->save($productImage)) {
            $message = 'Se ha editado el registro';
            $status = true;
        } else {
            $message = 'No se ha editado el registro';
            $status = false;
            $errors = $this->ErrorAdapter->reduce($productImage->errors());
        }
        $this->set(compact(['productImage', 'status', 'message', 'errors']));
        $this->set('_serialize', ['productImage', 'status', 'message', 'errors']);
    }

    /**
     * Delete method
     *
     * @param string|null $product_id Product id.
     * @param string|null $id Image id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($product_id = null, $id = null)
    {
        $productImage = $this->ProductImages->get($id);
        if ($this->ProductImages->delete($productImage)) {
            $message = 'Se ha eliminado el registro';
            $status = true;
        } else {
            $message = 'No se ha eliminado el registro';
            $status = false;
        }
        $this->set(compact(['productImage', 'status', 'message']));
        $this->set('_serialize', ['productImage', 'status', 'message']);
    }
}
