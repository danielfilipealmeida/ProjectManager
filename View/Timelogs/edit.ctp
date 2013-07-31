<div class="timelogs form">
<?php echo $this->Form->create('Timelog'); ?>
	<fieldset>
		<legend><?php echo __('Edit Timelog'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('task_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('date');
		echo $this->Form->input('worktime');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Timelog.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Timelog.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Timelogs'), array('action' => 'index')); ?></li>
	</ul>
</div>
