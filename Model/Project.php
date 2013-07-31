<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 */
class Project extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

        
        public $hasAndBelongsToMany = array(
            'Users' =>
                array(
                    'className'              => 'User',
                    'joinTable'              => 'projects_users',
                    'foreignKey'             => 'user_id',
                    'associationForeignKey'  => 'project_id',
                    'unique'                 => true,
                    'conditions'             => '',
                    'fields'                 => '',
                    'order'                  => '',
                    'limit'                  => '',
                    'offset'                 => '',
                    'finderQuery'            => '',
                    'deleteQuery'            => '',
                    'insertQuery'            => ''
                )
        
        );
        
        public $belongsTo = array(
            'User' => array(
                'className'    => 'User',
                'foreignKey'   => 'user_id'
            )
        );
        
}
