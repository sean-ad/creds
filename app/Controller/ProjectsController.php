<?php
App::uses('AppController', 'Controller', 'Project', 'User');
/**
 * Projects Controller
 *
 * @property Project $Project
 * @property PaginatorComponent $Paginator
 */
class ProjectsController extends AppController {

public $actsAs = array('Acl' => array('type' => 'controlled'));
public $uses = array('Project', 'User');

public function parentNode() {
    return null;
}

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Acl', 'RequestHandler');

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
		$projects = $this->Project->find('all', array('order' => array('Project.name ASC')));
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
			// This is a test of how we call a custom find method - to be eventually used when we want to check access to a certain project
			//$access = $this->Project->find('hasaccess', array('1'=>'a'));
			$this->set('project', $project);
			// For now, enumerate the users with access to this project by looping (See /projects/index and /users/view also)
			$users = $this->User->find('all', array('order' => array('User.username ASC')));
			$allowed_users = array();
			$disallowed_users = array();
			foreach ($users as $user){
				if ($this->Acl->check(array('User' => array('id' => $user['User']['id'])), $project['Project']['name'], 'read')){
					$allowed_users[] = $user;
				} else {
					$disallowed_users[] = $user;
				}
			}
			$this->set('users', $allowed_users);
			$this->set('disallowedusers', $disallowed_users);
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
				// Set up the new project in the permissions table
				$this->Acl->Aco->create(array(
						'parent_id' => null,
						'model' => 'Project',
						'alias' => $this->request->data['Project']['name']
					));
				$this->Acl->Aco->save();
				// Allow all admins to access this new project
				// TODO: Make this work retroactively and be removable
				$users = $this->User->find('all', array('conditions'=> array('role'=>'admin')));
			 	foreach ($users as $user){
			 		$this->Acl->allow($user, $this->request->data['Project']['name']);
			 	}

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
		//$this->request->onlyAllow('post', 'delete');
		if ($this->Project->delete()) {
			$this->Session->setFlash(__('The project has been deleted.'));
		} else {
			$this->Session->setFlash(__('The project could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
/**
 * permissions method
 *
 * @throws NotFoundException
 * @param int $projectid, int userId, string permission
 * @return void
 */
	public function permissions($projectid = null, $userId = null, $permission = 'allow') {
		if (AuthComponent::user('role') != 'admin') {
			throw new ForbiddenException("You don't have permission to do that");
		}
		if($permission!='allow' && $permission !='deny') {
			throw new ForbiddenException("Invalid parameter");
		}
		// One-off grants and denys
		if ( (!empty($projectid)) && (!empty($userId)) ){
			$user = $this->User->findById($userId);
			$this->User->id = $user['User']['id'];
			$project = $this->Project->findById($projectid);
			if($this->Acl->$permission($this->User, $project['Project']['name'])) {
				CakeLog::info(AuthComponent::user('username') . ' changed permissions for Project: ' . $project['Project']['name'] . ': ' . $this->user['username'] . ', ' . $permission);
					$this->Session->setFlash(__('Permissions applied'), 'flash_success');
					$this->redirect($this->referer());
			}
		} else {
			// a group of users to grant all at once
			if ($this->request->is('post') && !empty($this->data['Project']['users_to_allow'])){
				foreach ($this->data['Project']['users_to_allow'] as $newuser){
					if (!empty($newuser)){
						$user = $this->User->findById($newuser);
						$this->User->id = $user['User']['id'];
						$project = $this->Project->findById($this->data['Project']['id']);
						if($this->Acl->$permission($this->User, $project['Project']['name'])) {
							CakeLog::info(AuthComponent::user('username') . ' changed permissions for Project: ' . $project['Project']['name'] . ': ' . $user['User']['username'] . ', ' . $permission);
						}
					}
				}
				/* TODO: Catch errors where one element of the array fails : wrap in a transaction?*/
				$this->Session->setFlash(__('Permissions applied'), 'flash_success');
				$this->redirect($this->referer());
			}
		}
	}


}











