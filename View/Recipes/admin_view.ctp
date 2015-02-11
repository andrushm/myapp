<?php

$this->extend('/Common/admin_view');
$this->viewVars['title_for_layout'] = sprintf('%s: %s', __d('croogo', 'Recipes'), h($recipe['Recipe']['name']));

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Recipes'), array('action' => 'index'));

if (isset($recipe['Recipe']['name'])):
	$this->Html->addCrumb($recipe['Recipe']['name'], '/' . $this->request->url);
endif;

$this->set('title', __d('croogo', 'Recipe'));

$this->append('actions');
	echo $this->Croogo->adminAction(__d('croogo', 'Edit Recipe'), array(
		'action' => 'edit',
		$recipe['Recipe']['id'],
	), array(
		'button' => 'default',
	));
	echo $this->Croogo->adminAction(__d('croogo', 'Delete Recipe'), array(
		'action' => 'delete', $recipe['Recipe']['id'],
	), array(
		'method' => 'post',
		'button' => 'danger',
		'escapeTitle' => true,
		'escape' => false,
	),
	__d('croogo', 'Are you sure you want to delete # %s?', $recipe['Recipe']['id'])
	);
	echo $this->Croogo->adminAction(__d('croogo', 'List Recipes'), array('action' => 'index'));
	echo $this->Croogo->adminAction(__d('croogo', 'New Recipe'), array('action' => 'add'), array('button' => 'success'));
$this->end();

$this->append('main');
?>
<div class="recipes view">
	<dl class="inline">
		<dt><?php echo __d('croogo', 'Id'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Name'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'User Id'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Created'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('croogo', 'Updated'); ?></dt>
		<dd>
			<?php echo h($recipe['Recipe']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php $this->end(); ?>