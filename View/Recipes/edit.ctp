<div class="col-md-6">



<div class="panel panel-default">
    <div class="panel-heading">





<?php
echo $this->Form->create('Recipe');
echo $this->Form->input('name', array(
    'label' => false,
    'placeholder' => 'Name',
    'div' => 'form-group input-group text_inline',
    'class'=>'form-control text_inline',
));
echo $this->Html->link('Back', array('action'=>'index'), array('class'=>'btn btn-default pull-right'));
echo $this->Form->input('Save' ,array('label'=>false, 'type'=>'submit',  'div' => 'form-group input-group text_inline pull-right', 'class'=>'btn btn-default'));
?>
    </div>
    <div class="panel-body">
<?php

echo '<div>';
 foreach ($this->request->data['RecipeIngredient'] as $key=>$ingred):?>
    <dl class="dl-horizontal">
        <dt><?php echo $ingred['Ingredient']['name'];?></dt>
        <dd>
            <div class="form-group input-group">
            <?php
                echo $this->Form->input('RecipeIngredient.'.$key.'.quantity',array('label'=>false,
                                                                                   'div'=>'',
                                                                                   'type'=>'text',
                                                                                   'class'=>'form-control',
                                                                                   'value'=> $this->request->data['RecipeIngredient'][$key]['quantity'],
                ));
                echo '<span class="input-group-addon">';
                echo $ingred['Ingredient']['dimension'];
                echo '</span>';
                echo $this->Form->input('RecipeIngredient.'.$key.'.id',array('type'=>'hidden', 'value'=> $this->request->data['RecipeIngredient'][$key]['id']));
//                echo '<span class="input-group-addon btn btn-default">';
                echo $this->Html->link('X',array('controller'=>'Recipes',
                                                 'action'=>'del_ingredient',
                                                 $this->request->data['Recipe']['id'],
                                                 $this->request->data['RecipeIngredient'][$key]['id']),
                                                 array('class'=>'input-group-addon btn btn-default delete',
                                                      'escape'=>false, 'confirm'=>'Are you sure, you want to delete this user?'
                                                 )
                );
//                echo '</span>';
            ?>
<!--             <a href="" class="input-group-addon btn btn-default" >X</a> 'escape'=>false, 'confirm'=>'Are you sure, you want to delete this user?')-->
            </div>
        </dd>
    </dl>
<?php endforeach;
echo '</div>';
echo $this->Form->end();
?>

<?php

echo $this->Form->create('RecipeIngredient', array('url'=>array('controller'=>'Recipes','action'=>'add_ingredient')));
echo $this->Form->input('recipe_id', array('type'=>'hidden', 'value'=>$this->request->data['Recipe']['id']));
echo $this->Form->input('ingredient_id', array('label' => false,'options' => $Ingredient,'type'=>'select','div'=>array('class'=>'form-group text_inline'), 'class'=>'form-control', 'default'=>''));
echo $this->Form->input('quantity',array('label' => false,'type'=>'text', 'placeholder'=>__('quantity'), 'div'=>array('class'=>'form-group text_inline'), 'class'=>'form-control'));
echo $this->Form->end(array('label'=>'Add', 'div'=>array('class'=>'form-group text_inline'), 'class'=>'btn btn-default'));

?>


    </div>
<!--    <div class="panel-footer">-->
<!--        Panel Footer-->
<!--    </div>-->
</div>
</div>

<style>
    .text_inline { display: inline-block;
                   margin-bottom: 0px;}
    label { display: flex;}
</style>



