<?php
$this->viewVars['title_for_layout'] = __d('default', 'Recipes');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('default', 'Recipes'), array('action' => 'index'));

$this->set('tableClass', 'table table-striped');

$this->append('table-heading');
	$tableHeaders = $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('name'),
		$this->Paginator->sort('user_id'),
		$this->Paginator->sort('created'),
		$this->Paginator->sort('updated'),
		array(__d('croogo', 'Actions') => array('class' => 'actions')),
	));
	echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
	$rows = array();
	foreach ($recipes as $recipe):
		$row = array();
		$row[] = h($recipe['Recipe']['id']);
		$row[] = h($recipe['Recipe']['name']);
		$row[] = h($recipe['Recipe']['user_id']);
		$row[] = h($recipe['Recipe']['created']);
		$row[] = h($recipe['Recipe']['updated']);
		$row[] = array($this->Croogo->adminRowActions($recipe['Recipe']['id']), array(
			'class' => 'item-actions',
		));
		$row[] = $this->Croogo->adminRowAction('', array(
			'action' => 'view', $recipe['Recipe']['id']
	), array(
			'icon' => 'eye-open',
		));
		$row[] = $this->Croogo->adminRowAction('', array(
			'action' => 'edit',
			$recipe['Recipe']['id'],
		), array(
			'icon' => 'pencil',
		));
		$row[] = $this->Croogo->adminRowAction('', array(
			'action' => 'delete',
			$recipe['Recipe']['id'],
		), array(
			'icon' => 'trash',
			'escape' => true,
		),
		__d('croogo', 'Are you sure you want to delete # %s?', $recipe['Recipe']['id'])
		);
		$rows[] = $this->Html->tableCells($row);
	endforeach;
	echo $this->Html->tag('tbody', implode('', $rows));
$this->end();
