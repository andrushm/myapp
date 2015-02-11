<?php
echo $this->Form->create('Recipe', array('action'=>'add'));
	echo $this->Form->input('id');
	echo $this->Form->input('name', array(
		'label' => 'Name',
	));

echo $this->Form->end(array('label'=>'Add'));
?>