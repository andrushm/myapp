<?php
App::uses('RecipeIngredient', 'Model');

/**
 * RecipeIngredient Test Case
 *
 */
class RecipeIngredientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.recipe_ingredient',
		'app.recipe',
		'app.user',
		'app.ingredient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RecipeIngredient = ClassRegistry::init('RecipeIngredient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RecipeIngredient);

		parent::tearDown();
	}

}
