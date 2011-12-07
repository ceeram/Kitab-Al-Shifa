<?php
class User extends AppModel
{
	public $actsAs = array('Containable');
	public $useDbConfig = 'joomla';
	public $useTable = 'users';
	public $hasOne = array(
			'Profile' => array(
				'className' => 'Profile',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => '',
				'order' => '')
	);
	var $hasMany = array('Shifts');
	var $displayField = 'name';
	public $order = array('block' => 'ASC');

	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A username is required'
			)
		),
		'password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A password is required'
			)
		),
	);
	
	
	protected function findUser($username, $password) {
		$userModel = $this->settings['userModel'];

		list($plugin, $model) = pluginSplit($userModel);
		$fields = $this->settings['fields'];

		$user = ClassRegistry::init($userModel)->findByUsername($username);
		$parts = explode(':', $user['User']['password']);
		$salt = $parts[1];
		
		$conditions = array(
			$model . '.' . $fields['username'] => $username,
			$model . '.' . $fields['password'] => md5($password . $salt) . ':' . $salt,
		);
		if (!empty($this->settings['scope'])) {
		$conditions = array_merge($conditions, $this->settings['scope']);
		}
		$result = ClassRegistry::init($userModel)->find('first', array(
		'conditions' => $conditions,
		'recursive' => 0
		));
		if (empty($result) || empty($result[$model])) {
		return false;
		}
		unset($result[$model][$fields['password']]);
		return $result[$model];
	}
	
	
}

?>