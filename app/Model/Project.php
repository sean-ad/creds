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

}
