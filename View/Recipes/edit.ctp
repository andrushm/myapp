<?php
echo $this->Form->create('Recipe');

	echo $this->Form->input('id');
	echo $this->Form->input('name', array(
		'label' => 'Name',
	));

//    echo $this->request->data['User']['name'];
//    echo $this->Form->input('user_id',array('type'=>'hidden', 'value'=> $this->request->data['User']['id']));

 foreach ($this->request->data['RecipeIngredient'] as $key=>$ingred):?>
    <dl class="dl-horizontal">
        <dt><?php echo $ingred['Ingredient']['name'];?></dt>
        <dd>
            <?php
                echo $this->Form->input('RecipeIngredient.'.$key.'.quantity',array('type'=>'text', 'value'=> $this->request->data['RecipeIngredient'][$key]['quantity']));
                echo $this->Form->input('RecipeIngredient.'.$key.'.id',array('type'=>'hidden', 'value'=> $this->request->data['RecipeIngredient'][$key]['id']));
            ?>
        </dd>
<!--        <dd>--><?php //echo $ingred['quantity'].' ('.$ingred['Ingredient']['dimension'].')'; ?><!--</dd>-->
    </dl>
<?php endforeach;



echo $this->Form->end(array('label'=>'edit'));
