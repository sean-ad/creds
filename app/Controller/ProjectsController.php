<?php
App::uses('AppController', 'Controller');
/**
 * Projects Controller
 *
 * @property Project $Project
 * @property PaginatorComponent $Paginator
 */
class ProjectsController extends AppController {

	//  Integrate with ACLs
	public $actsAs = array('Acl' => array('type' => 'controlled'));
	public function parentNode() {
    		return null;
	}

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Acl');

	public function beforeFilter() {
		parent::beforeFilter();
		// turn off auth
		//$this->Auth->allow();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		// TODO:
		// Only retrieve the projects they have permission to view anyway
		// Right now doing this in the view
		// $this->Project->recursive = 0;
		// $this->set('projects', $this->Paginator->paginate());
		//
		// Use the Acl Behavior
		    $this->Paginator->settings = array(
		        // 'conditions' => array('Recipe.title LIKE' => 'a%'),
		        'limit' => 10
		    );
		    $this->Project->recursive = 0;
		    $projects = $this->Paginator->paginate();
		    $this->set(compact('projects'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		// TODO: Throw this into the top oif the controller, don't need it in every action
		if (AuthComponent::user('role') != ('admin' || 'author')) {
			throw new ForbiddenException("You must be logged in to do that.");
		}
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__('Invalid project'));
		}
		$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
		$project = $this->Project->find('first', $options);
		if (!($this->Acl->check(array('User' => array('id' => $this->Auth->user('id'))), $project['Project']['name'], 'read'))){
			throw new ForbiddenException("You don't have permission to view that project.");
		} else {
			$this->set('project', $project);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if (AuthComponent::user('role') != 'admin') {
			throw new ForbiddenException("You don't have permission to add projects.");
		}
		if ($this->request->is('post')) {
			$this->Project->create();
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'));
			}
		}
		$this->set(compact('teams'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		// if (AuthComponent::user('role') != 'admin') {
		// 	throw new ForbiddenException("You don't have permission to edit projects.");
		// }
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__('Invalid project'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
			$this->request->data = $this->Project->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (AuthComponent::user('role') != 'admin') {
			throw new ForbiddenException("You don't have permission to delete projects.");
		}
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			throw new NotFoundException(__('Invalid project'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Project->delete()) {
			$this->Session->setFlash(__('The project has been deleted.'));
		} else {
			$this->Session->setFlash(__('The project could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
