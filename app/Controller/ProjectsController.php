<?php
App::uses('AppController', 'Controller');
/**
 * Projects Controller
 *
 * @property Project $Project
 * @property PaginatorComponent $Paginator
 */
class ProjectsController extends AppController {

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
		$this->Auth->allow('initDB');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		// TODO:
		// Only retrieve the projects they have permission to view anyway, and paginate.
		// Original paginated view saved as index_paginated.
		// Wish this could be done in the model but then we don't have
		// access to the Acl or Auth components.
		//
		// Original
		// $this->Project->recursive = 0;
		// $this->set('projects', $this->Paginator->paginate());
		//
		$this->Project->recursive = 0;
		$projects = $this->Project->find('all');
		// we only want to display the allowed projects
		$allowed_projects = array();
		foreach ($projects as $project){
			if ($this->Acl->check(array('User' => array('id' => $this->Auth->user('id'))), $project['Project']['name'], 'read')){
				$allowed_projects[] = $project;
			}
		}
		// send differently depending on whether we were a requestAction or a regular controller call
        	if ($this->request->is('requested')) {
           	 return $allowed_projects;
        	} else {
			$this->set('projects', $allowed_projects);
		}
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
			CakeLog::info('The user '.AuthComponent::user('username').' (ID: '.AuthComponent::user('id').') tried to view the '.  $project['Project']['name'] .' project: (ID: '.$project['Project']['id'].')','users');
			$this->Session->setFlash(__('The project could not be viewed.', 'flash_fail'));
			$this->redirect(array('action' => 'index'));
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
		if (AuthComponent::user('role') != 'admin') {
			//throw new ForbiddenException("You can't perform that action.");
			CakeLog::info('The user '.AuthComponent::user('username').' (ID: '.AuthComponent::user('id').') tried to edit a project: (ID: '.$id.')','users');
			$this->Session->setFlash(__('The project could not be edited.', 'flash_fail'));
			$this->redirect(array('action' => 'index'));
		}
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

			/*

			TODO:

			make it easy to quickly assign users to a project
			and see who is already assigned


			 */
			//print_r($this->request->data );
			//data doesn't have enough info to know who has permissions
			// have to interrogate the aros_acos table
			// or use a built-in checker?

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
