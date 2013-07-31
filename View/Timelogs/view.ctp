<div class="timelogs view">
<h2><?php  echo __('Timelog'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($timelog['Timelog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Task Id'); ?></dt>
		<dd>
			<?php echo h($timelog['Timelog']['task_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($timelog['Timelog']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($timelog['Timelog']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Worktime'); ?></dt>
		<dd>
			<?php echo h($timelog['Timelog']['worktime']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Timelog'), array('action' => 'edit', $timelog['Timelog']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Timelog'), array('action' => 'delete', $timelog['Timelog']['id']), null, __('Are you sure you want to delete # %s?', $timelog['Timelog']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Timelogs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Timelog'), array('action' => 'add')); ?> </li>
	</ul>
</div>
