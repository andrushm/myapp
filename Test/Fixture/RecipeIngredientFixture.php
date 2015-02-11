<?php
/**
 * RecipeIngredientFixture
 *
 */
class RecipeIngredientFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'recipe_ingredient';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'recipe_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'ingredient_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'quantity' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '11,3', 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'recipe_id' => array('column' => 'recipe_id', 'unique' => 0),
			'ingredient_id' => array('column' => 'ingredient_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'recipe_id' => 1,
			'ingredient_id' => 1,
			'quantity' => ''
		),
	);

}
