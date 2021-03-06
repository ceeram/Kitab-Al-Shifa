<?php
/**
 * Calendar Model
 *
 * @property Group $Group
 */
class Calendar extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $order = array('start_date' => 'DESC');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'usergroups_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a calendar name',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'start_date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'end_date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'published' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Usergroup' => array(
			'className' => 'Usergroup',
			'foreignKey' => 'usergroups_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Get list of calendars
	 */
	function getList() {
		return $this->find('list', array(
			'fields' => array('Calendar.start_date', 'Calendar.name', 'Calendar.id'),
			'order'=>array('Calendar.start_date DESC')));
	}
	/**
	 * Last update of a shift in the calendar
	 * @calendar int
	 */
	function lastUpdated($id) {
		App::uses('Shift', 'Model');
		$this->Shift = new Shift();
		$calendar = $this->findById($id, array(
				'start_date', 'end_date'));
		$lastUpdated = $this->Shift->find('first', array(
				'fields' => array('Shift.updated'),
				'conditions' => array(
						'Shift.date >=' => $calendar['Calendar']['start_date'],
						'Shift.date <=' => $calendar['Calendar']['end_date'],
				),
				'order' => array(
						'Shift.updated' => 'DESC',
				)
		));
		return $lastUpdated['Shift']['updated'];
	}
	/*
	 * needsUpdate method
	 * @id int calendar ID
	 */
	public function needsUpdate($id) {
		App::uses('File', 'Utility');
		$calendar = $this->findById($id, array(
				'start_date'));
		$lastUpdated = $this->lastUpdated($id);
		$file = new File(WWW_ROOT ."pdf/EMA_Schedule-".$id."-".$calendar['Calendar']['start_date'].".pdf");
		$lastChanged = $file->lastChange();
		if ($lastChanged && strtotime($lastUpdated) < $lastChanged) {
			return false;
		}
		return true;
	}
}
?>