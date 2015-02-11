<?php
App::uses('AppModel', 'Model');
/**
 * Recipe Model
 *
 */
class Recipe extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'recipe';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    public $belongsTo = array('User' => array('className' => 'User',
        'foreignKey' => 'user_id',
        'conditions' => '',
        'fields' => array('User.id', 'User.name'),
        'order' => '')
    );

    public $hasMany = array('RecipeIngredient' => array('className' => 'RecipeIngredient',
                                                        ));

}
