<?php

$this->extend('/Common/admin_view');
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Ingredients'), h($ingredient['Ingredient']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Ingredients'), array('action' => 'index'));

if (isset($ingredient['Ingredient']['name'])):
	$this->Html->addCrumb($ingredient['Ingredient']['name'], '/' . $this->request->url);
endif;

$this->set('title', __d('croogo', 'Ingredient'));

$this->append('actions');
	echo $this->Croogo->adminAction(__d('croogo', 'Edit Ingredient'), array(
		'action' => 'edit',
		$ingredient['Ingredient']['id'],
	), array(
		'button' => 'default',
	));
	echo $this->Croogo->adminAction(__d('croogo', 'Delete Ingredient'), array(
		'action' => 'delete', $ingredient['Ingredient']['id'],
	), array(
		'method' => 'post',
		'button' => 'danger',
		'escapeTitle' => true,
		'escape' => false,
	),
	__d('croogo', 'Are you sure you want to delete # %s?', $ingredient['Ingredient']['id'])
	);
	echo $this->Croogo->adminAction(__d('croogo', 'List Ingredients'), array('action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Ingredient'), array('action' => 'add'), array('button' => 'success'));
$this->end();

$this->append('main');
?>
<div class="ingredients view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($ingredient['Ingredient']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($ingredient['Ingredient']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Dimension'); ?></dt>
		<dd>
			<?php echo h($ingredient['Ingredient']['dimension']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php $this->end(); ?>