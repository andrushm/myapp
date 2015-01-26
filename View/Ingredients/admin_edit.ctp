<?php
$this->viewVars['title_for_layout'] = __d('default', 'Ingredients');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('default', 'Ingredients'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->request->data['Ingredient']['name'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Ingredients: ' . $this->request->data['Ingredient']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

$this->append('form-start', $this->Form->create('Ingredient'));

$this->append('tab-heading');
	echo $this->Croogo->adminTab(__d('default', 'Ingredient'), '#ingredient');
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');
	echo $this->Form->input('id');
	echo $this->Form->input('name', array(
		'label' => 'Name',
	));
	echo $this->Form->input('dimension', array(
		'label' => 'Dimension',
	));
	echo $this->Croogo->adminTabs();
$this->end();

$this->append('panels');
	echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
		$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
		$this->Form->button(__d('croogo', 'Save'), array('button' => 'primary')) .
		$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('button' => 'danger'));
	echo $this->Html->endBox();

	echo $this->Croogo->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
