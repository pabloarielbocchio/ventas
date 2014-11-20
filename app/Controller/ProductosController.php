<?php

App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ProductosController extends AppController {

    public $helpers = array('Html', 'Form');

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $paginate = array(
        'paramType' => 'querystring',
        'recursive' => 1
    );
    public $components = array('Paginator');
    public $uses = array();

    public function add() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['Producto']['preview_name'] = md5($data['Producto']['nombre']);
            $this->Producto->create();
            $tag = $this->Producto->save($this->request->data);

            $header_pathInfo = pathinfo($data['Producto']['logo']['name'], PATHINFO_EXTENSION);
            $headerDir = new Folder(WWW_ROOT . 'files' . DS . 'productos' . DS . 'logo' . DS . $this->Producto->getLastInsertID(), true, 0755);
            $headerFile = new File($headerDir->pwd() . DS . $data['Producto']['preview_name'] . '.' . $header_pathInfo);
            // If exists
             if ($headerFile) {
              $headerFile->copy($headerDir->pwd() . DS . $this->Producto->getLastInsertID(). DS . 'untouched.' . $header_pathInfo);
              $headerFile->delete();
              $headerFile->close();
              } 

            if ($tag) {
                $this->Session->setFlash('El producto fue agregado con exito.', 'success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('El producto no pude ser agregado. Por favor intente nuevamente.', 'error');
            }
        }
    }

    public function edit($id = null) {
        if (!$this->Producto->exists($id)) {
            throw new NotFoundException(__('Invalid tag'));
        }
        $data = $this->Producto->getById($id);
         if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            $data['Producto']['preview_name'] = md5($data['Producto']['nombre']);
            $tag = $this->Producto->save($this->request->data);

            $header_pathInfo = pathinfo($data['Producto']['logo']['name'], PATHINFO_EXTENSION);
            $headerDir = new Folder(WWW_ROOT . 'files' . DS . 'productos' . DS . 'logo' . DS . $this->Producto->getLastInsertID(), true, 0755);
            $headerFile = new File($headerDir->pwd() . DS . $data['Producto']['preview_name'] . '.' . $header_pathInfo);
            // If exists
             if ($headerFile) {
              $headerFile->copy($headerDir->pwd() . DS . $this->Producto->getLastInsertID(). DS . 'untouched.' . $header_pathInfo);
              $headerFile->delete();
              $headerFile->close();
              }

            if ($tag) {
                $this->Session->setFlash('El producto fue editado con exito.', 'success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('El producto no pude ser editado. Por favor intente nuevamente.', 'error');
            }
        } 
        $this->request->data = $data;
        $this->set(compact('producto'));
    }

    public function index() {
        if ($this->request->is('get')) {
            if (array_key_exists('search-field', $this->request->query) && !empty($this->request->query['search-field'])) {
                $search_field_cleaned = preg_replace('/\s+/', ' ', trim($this->request->query['search-field']));
                $conditions = array(
                    'conditions' => array('Producto.nombre LIKE' => "%" . $search_field_cleaned . "%")
                );
                $this->Paginator->settings = $conditions;
            }
        }
        $productos = $this->Paginator->paginate();
        $this->set(compact('productos'));
    }

    public function view($id = null){
        if (!$this->Producto->exists($id)) {
            throw new NotFoundException(__('Invalid tag'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->Producto->id = $id;
            $data = $this->request->data;
            $data['Producto']['preview_name'] = md5($data['Producto']['logo']['name']);
            $producto = $this->Producto->save($this->request->data);
    
            $header_pathInfo = pathinfo($data['Producto']['logo']['name'], PATHINFO_EXTENSION);
            $headerDir = new Folder(WWW_ROOT . 'files' . DS . 'productos' . DS . 'logo' . DS . $this->Producto->getLastInsertID(), true, 0755);
            $headerFile = new File($headerDir->pwd() . DS . $data['Producto']['preview_name'] . '.' . $header_pathInfo);
            if ($headerFile) {
              $headerFile->copy($headerDir->pwd() . DS . $this->Producto->getLastInsertID(). DS . 'untouched.' . $header_pathInfo);
              $headerFile->delete();
              $headerFile->close();
            } 
        }
        $this->request->data = $this->Producto->getById($id);
        $producto = $this->request->data;
        
        $this->set(compact('producto'));
    }
}
