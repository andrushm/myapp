<?php
App::uses('AppController', 'Controller');
/**
 * Recipes Controller
 *
 * @property Recipe $Recipe
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RecipesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

    public $uses = array('Recipe', 'RecipeIngredient', 'Ingredient');
/**
 * index method
 *
 * @return void
 */
	public function index() {
//        $this->Session->setFlash('Something good.', 'default', array(), 'success');
		$this->Recipe->recursive = 2;
//        $this->paginate['fields'] = array('Recipe.name');
//        $t = $this->Recipe->find('all',array('recursive'=>2));
//        var_dump($this->paginate());die;
		$this->set('recipes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Recipe->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid recipe'));
		}

		$options = array('conditions' => array('Recipe.' . $this->Recipe->primaryKey => $id,  ),'recursive'=>2);
		$this->set('recipe', $this->Recipe->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Recipe->create();

            $this->request->data['Recipe']['user_id'] = $this->curUser['id'];

			if ($this->Recipe->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The recipe has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('alert');//, 'The recipe could not be saved. Please, try again.'), 'default', array('class' => 'error'));
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

		if (!$this->Recipe->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid recipe'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ( $this->Recipe->saveAll($this->request->data)) {
                $this->Session->setFlash('The recipe has been saved!', 'default', array(), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
                $this->Session->setFlash('The recipe could not be saved. Please, try again.', 'default', array(), 'alert');

			}
		}; //else {
			$options = array('conditions' => array('Recipe.' . $this->Recipe->primaryKey => $id, ),'recursive'=>2);
			$this->request->data = $this->Recipe->find('first', $options);
        $ingredients = $this->Ingredient->find('all', array('recursive'=>'0'));
        $list = array();
        foreach($ingredients as $ingredient){
            $list[$ingredient['Ingredient']['id']] = $ingredient['Ingredient']['name'].' ('.$ingredient['Ingredient']['dimension'].')';
        }
//        pr($list);die;
            $this->set('Ingredient',$list);
//		}
	}

    /**
     * add ingredient method
     */
    public function add_ingredient(){
//        pr($this->request->data);die;
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->RecipeIngredient->save( $this->request->data)){
                $this->redirect(array('action'=>'edit', $this->request->data['RecipeIngredient']['recipe_id']));
            }
        }

    }

    /*
     *
     */
    public function del_ingredient($id,$ingredient_id){

        if (!empty($id)){
            if ($this->RecipeIngredient->delete($ingredient_id, false)){
                $this->redirect(array('action'=>'edit', $id));
            }
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
		$this->Recipe->id = $id;
		if (!$this->Recipe->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid recipe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Recipe->delete()) {
			$this->Session->setFlash(__d('croogo', 'Recipe deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Recipe was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Recipe->recursive = 0;
		$this->set('recipes', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Recipe->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid recipe'));
		}
		$options = array('conditions' => array('Recipe.' . $this->Recipe->primaryKey => $id));
		$this->set('recipe', $this->Recipe->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Recipe->create();
			if ($this->Recipe->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The recipe has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The recipe could not be saved. Please, try again.'), 'default', array('class' => 'error'));
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
		if (!$this->Recipe->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid recipe'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Recipe->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The recipe has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The recipe could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('Recipe.' . $this->Recipe->primaryKey => $id));
			$this->request->data = $this->Recipe->find('first', $options);
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
		$this->Recipe->id = $id;
		if (!$this->Recipe->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid recipe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Recipe->delete()) {
			$this->Session->setFlash(__d('croogo', 'Recipe deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Recipe was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}
