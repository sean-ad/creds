<?php
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel
{
  public $name = 'User';
  public $actsAs = array('Acl' => array('type' => 'requester'));
  public function parentNode() {
      return null;
  }
  public function beforeSave($options = array())
  {
    if (isset($this->data[$this->alias]['password']) && !empty($this->data[$this->alias]['password']))
    {
      $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    }
    return true;
  }

  public $validate = array(
    'username' => array(
      array(
        'rule' => array('notEmpty'),
        'message' => 'A username is required.'
        ),
      array(
        'rule' => 'isUnique',
        'message' => 'This user already exists (1).'
        )
      ),
    'email' => array(
      array(
        'rule' => array('email'),
        'message' => 'Invalid email.'
        ),
      array(
        'rule' => 'isUnique',
        'message' => 'This user already exists (2).'
        )
      ),
    'password' => array(
        // 'rule'    => '$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$',
        // 'message' => 'Requires at least 8 characters in a mix of upper & lowercase, special characters, & numbers'
    ),
    'role' => array(
      'valid' => array(
        'rule' => array('inList', array('admin', 'author')),
        'message' => 'Please enter a valid role',
        'allowEmpty' => false
        )
      )
    );

  public function valid_pass($candidate) {
      if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $candidate))
          return FALSE;
      return TRUE;
  }

  public function generateHashChangePassword()
  {
    $salt = Configure::read('Security.salt');
    $salt_v2 = Configure::read('Security.cipherSeed');
    $rand = mt_rand(1,999999999);
    $rand_v2 = mt_rand(1,999999999);

    $hash = hash('sha256',$salt.$rand.$salt_v2.$rand_v2);

    return $hash;
  }

  public function getUsername($email)
  {
    $username = $this->findByEmail($email,'username');
    if(empty($username)){
      throw new InternalErrorException(__('Invalid username or password, try again'));
    }
    return $username['User']['username'];
  }
}
?>
