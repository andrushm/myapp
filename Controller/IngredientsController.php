<?php
App::uses('AppController', 'Controller');
/**
 * Ingredients Controller
 *
 * @property Ingredient $Ingredient
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class IngredientsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

    public $helpers = array(
        'BootstrapHtml', 'BootstrapModal', 'BootstrapForm', 'BootstrapNavbar'
//        'Html' => array(
//            'className' => 'Bootstrap3.BootstrapHtml'
//        ),
//        'Form' => array(
//            'className' => 'Bootstrap3.BootstrapForm'
//        ),
//        'Modal' => array(
//            'className' => 'Bootstrap3.BootstrapModal'
//        )
    );

/**
 * index method
 *
 * @return void
 */
	public function index() {

		$this->Ingredient->recursive = 0;
//        $this->Session->setFlash('alert');
//        $this->Session->setFlash('Something good.', 'default', array(), 'success');
		$this->set('ingredients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Ingredient->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid ingredient'));
		}
		$options = array('conditions' => array('Ingredient.' . $this->Ingredient->primaryKey => $id));
		$this->set('ingredient', $this->Ingredient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ingredient->create();
			if ($this->Ingredient->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The ingredient has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The ingredient could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Ingredient->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid ingredient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ingredient->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The ingredient has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The ingredient could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Ingredient.' . $this->Ingredient->primaryKey => $id));
			$this->request->data = $this->Ingredient->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Ingredient->id = $id;
		if (!$this->Ingredient->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid ingredient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ingredient->delete()) {
			$this->Session->setFlash(__d('croogo', 'Ingredient deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Ingredient was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Ingredient->recursive = 0;
		$this->set('ingredients', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Ingredient->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid ingredient'));
		}
		$options = array('conditions' => array('Ingredient.' . $this->Ingredient->primaryKey => $id));
		$this->set('ingredient', $this->Ingredient->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Ingredient->create();
			if ($this->Ingredient->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The ingredient has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The ingredient could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Ingredient->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid ingredient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ingredient->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The ingredient has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The ingredient could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Ingredient.' . $this->Ingredient->primaryKey => $id));
			$this->request->data = $this->Ingredient->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Ingredient->id = $id;
		if (!$this->Ingredient->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid ingredient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ingredient->delete()) {
			$this->Session->setFlash(__d('croogo', 'Ingredient deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Ingredient was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}
