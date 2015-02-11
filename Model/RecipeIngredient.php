<?php
App::uses('AppModel', 'Model');
/**
 * RecipeIngredient Model
 *
 * @property Recipe $Recipe
 * @property Ingredient $Ingredient
 */
class RecipeIngredient extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'recipe_ingredient';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'quantity';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
//		'Recipe' => array(
//			'className' => 'Recipe',
//			'foreignKey' => 'recipe_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
		'Ingredient' => array(
			'className' => 'Ingredient',
			'foreignKey' => 'ingredient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
