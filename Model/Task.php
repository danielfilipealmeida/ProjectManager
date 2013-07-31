<?php
App::uses('AppModel', 'Model');
/**
 * Task Model
 *
 */
class Task extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

        /* fix this. there is no Stage table any more */
        /*
    public $belongsTo = array (
        'Stage' => array(
            'className' =>'Stage',
            'foreignKey' =>'stage_id'
        )
    );
         * 
         * 
         */
}
