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
	public $hasAndBelongsToMany = array(
		'Usergroup' =>
			array(
				'className'				=> 'Usergroup',
				'joinTable'				=> 'user_usergroup_map',
				'foreignKey'			=> 'user_id',
				'associationForeignKey'	=> 'group_id',
				'unique'				=> true,
				'conditions'			=> '',
				'fields'				=> '',
				'order'					=> '',
				'limit'					=> '',
				'offset'				=> '',
				'finderQuery'			=> '',
				'deleteQuery'			=> '',
				'insertQuery'			=> ''
			)
	);
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
}

?>