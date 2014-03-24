<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 * @property ProjectItem $ProjectItem
 * @property Team $Team
 */
class Project extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	// to integrate with acl checks on projects
	public $findMethods = array('available' =>  true, 'hasaccess'=>true);


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ProjectItem' => array(
			'className' => 'ProjectItem',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);



protected function _findHasAccess($state, $query, $results = array()) {
   //if (!($this->Acl->check(array('User' => array('id' => $this->Auth->user('id'))), $projectItem['Project']['name'], 'read'))){ }
    if ($state === 'before') {
    	// change query conditions if you need to before it runs
        return $query;
        }
        $query['joins'] = array(
            //array of required joins
        );
        return $results;
    }



}
