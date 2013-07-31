<div class="timelogs form">
<?php echo $this->Form->create('Timelog'); ?>
	<fieldset>
		<legend><?php echo __('Add Timelog'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Timelogs'), array('action' => 'index')); ?></li>
	</ul>
</div>
