<?php
$this->viewVars['title_for_layout'] = __d('default', 'Ingredients');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('default', 'Ingredients'), array('action' => 'index'));

$this->set('tableClass', 'table table-striped');

$this->append('table-heading');
	$tableHeaders = $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('name'),
		$this->Paginator->sort('dimension'),
		array(__d('croogo', 'Actions') => array('class' => 'actions')),
	));
	echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
	$rows = array();
	foreach ($ingredients as $ingredient):
		$row = array();
		$row[] = h($ingredient['Ingredient']['id']);
		$row[] = h($ingredient['Ingredient']['name']);
		$row[] = h($ingredient['Ingredient']['dimension']);
		$row[] = array($this->Croogo->adminRowActions($ingredient['Ingredient']['id']), array(
			'class' => 'item-actions',
		));
		$row[] = $this->Croogo->adminRowAction('', array(
			'action' => 'view', $ingredient['Ingredient']['id']
	), array(
			'icon' => 'eye-open',
		));
		$row[] = $this->Croogo->adminRowAction('', array(
			'action' => 'edit',
			$ingredient['Ingredient']['id'],
		), array(
			'icon' => 'pencil',
		));
		$row[] = $this->Croogo->adminRowAction('', array(
			'action' => 'delete',
			$ingredient['Ingredient']['id'],
		), array(
			'icon' => 'trash',
			'escape' => true,
		),
		__d('croogo', 'Are you sure you want to delete # %s?', $ingredient['Ingredient']['id'])
		);
		$rows[] = $this->Html->tableCells($row);
	endforeach;
	echo $this->Html->tag('tbody', implode('', $rows));
$this->end();
