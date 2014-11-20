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
class VentaProducto extends AppModel {

    
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
        'Producto' => array(
            'className' => 'Producto',
            'foreignKey' => 'producto_id',
        ),
        'Venta' => array(
            'className' => 'Venta',
            'foreignKey' => 'venta_id',
        )
    );
       //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(

    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
    );
    
}