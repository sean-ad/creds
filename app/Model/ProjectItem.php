<?php
App::uses('AppModel', 'Model');
/**
 * ProjectItem Model
 *
 * @property Project $Project
 */
class ProjectItem extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'projectItems';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

public function beforeSave($options = array())
  {
    // Encrypt the password for storage
    if (isset($this->data[$this->alias]['password']) && !empty($this->data[$this->alias]['password']))
    {
        $newpass = Security::rijndael($this->data[$this->alias]['password'], Configure::read('Security.key'), 'encrypt');
        $this->data[$this->alias]['password'] = $newpass;
    }
    return true;
  }

public function afterFind($results, $primary = false) {
      // Decrypt the password for display
      foreach ($results as $key => $val) {
          if (isset($val['ProjectItem']['password'])) {
              $results[$key]['ProjectItem']['password'] = Security::rijndael($results[$key]['ProjectItem']['password'], Configure::read('Security.key'), 'decrypt');
          }
      }
    return $results;
}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
