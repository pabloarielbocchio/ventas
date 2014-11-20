<?php
App::uses('AppModel', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Tag Model
 *
 * @property Company $Company
 * @property Campaign $Campaign
 */
class Venta extends AppModel {

    
    public $recursive = -1;

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
       
    );

     
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        
    );
       //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'VentaProducto' => array(
            'className' => 'VentaProducto',
            'foreignKey' => 'venta_id',
        ),
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
    );
    
}