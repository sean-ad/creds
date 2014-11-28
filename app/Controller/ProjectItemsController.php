<?php
App::uses('AppController', 'Controller');
/**
 * ProjectItems Controller
 *
 * @property ProjectItem $ProjectItem
 * @property PaginatorComponent $Paginator
 */
class ProjectItemsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter() {
		parent::beforeFilter();
		// $this->Auth->allow('index');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		if (AuthComponent::user('role') != 'admin') {
			throw new ForbiddenException("You don't have permission to do that.");
		}
		$this->ProjectItem->recursive = 0;
		$this->set('projectItems', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (AuthComponent::user('role') != ('admin' || 'author')) {
			throw new ForbiddenException("You don't have permission to do that.");
		}
		if (!$this->ProjectItem->exists($id)) {
			throw new NotFoundException(__('Invalid project item'));
		}
		$options = array('conditions' => array('ProjectItem.' . $this->ProjectItem->primaryKey => $id));
		$projectItem = $this->ProjectItem->find('first', $options);
		if (!($this->Acl->check(array('User' => array('id' => $this->Auth->user('id'))), $projectItem['Project']['name'], 'read'))){
			//throw new ForbiddenException("You don't have permission to view that project.");
			CakeLog::info('The user '.AuthComponent::user('username').' (ID: '.AuthComponent::user('id').') tried to view the '.  $projectItem['Project']['name'] .' project: (ID: '.$projectItem['Project']['id'].')','users');
			$this->Session->setFlash(__('The project could not be viewed.', 'flash_fail'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->set('projectItem', $projectItem);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if (AuthComponent::user('role') != 'admin') {
			throw new ForbiddenException("You don't have permission to do that.");
		}
		if ($this->request->is('post')) {
			$this->ProjectItem->create();
			$projectId = $this->request->data['ProjectItem']['project_id'];
			if ($this->ProjectItem->save($this->request->data)) {
				$this->Session->setFlash(__('The project item has been saved.'), 'flash_success');
				// return $this->redirect(array('action' => 'index'));
				return $this->redirect(array('controller'=>'projects', 'action' => 'view', $projectId));
			} else {
				$this->Session->setFlash(__('The project item could not be saved. Please, try again.'));
			}
		}
		$parent_project = $this->params['named']['project'];
		$project = $this->ProjectItem->Project->findById($this->params['named']['project']);
		$this->set(compact('project'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (AuthComponent::user('role') != 'admin') {
			throw new ForbiddenException("You don't have permission to do that.");
		}
		if (!$this->ProjectItem->exists($id)) {
			throw new NotFoundException(__('Invalid project item'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$projectId = $this->data['ProjectItem']['project_id'];
			if ($this->ProjectItem->save($this->request->data)) {
				$this->Session->setFlash(__('The credentials have been saved.'),  'flash_success');
				return $this->redirect(array('controller'=>'projects', 'action' => 'view', $projectId));
			} else {
				$this->Session->setFlash(__('The credentials could not be saved. Please, try again.'),  'flash_fail');
			}
		} else {
			$options = array('conditions' => array('ProjectItem.' . $this->ProjectItem->primaryKey => $id));
			$this->request->data = $this->ProjectItem->find('first', $options);
		}
		$projects = $this->ProjectItem->Project->find('list');
		$this->set(compact('projects'));
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
			throw new ForbiddenException("You don't have permission to do that.");
		}
		$this->ProjectItem->id = $id;
		if (!$this->ProjectItem->exists()) {
			throw new NotFoundException(__('Invalid project item'));
		}
		//$this->request->onlyAllow('post', 'delete');
		if ($this->ProjectItem->delete()) {
			$this->Session->setFlash(__('The project item has been deleted.'), 'flash_success');
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('The project item could not be deleted. Please, try again.'),  'flash_fail');
		}
		return $this->redirect(array('action' => 'index'));
	}}
