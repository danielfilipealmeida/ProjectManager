<?php
$this->Html->addCrumb('Tasks', '/tasks');
$this->Html->addCrumb('Edit Task', '');


echo $this->Html->scriptBlock(
    '
    $(function() {
        $("#TaskEnd").datepicker({ dateFormat: "yy-mm-dd" });
        //$("#TaskStart").datepicker({ dateFormat: "yy-mm-dd" });
   });       
    ',
    array('inline' => true)
);
?>
<div class="tasks form">
<?php echo $this->Form->create('Task'); ?>
	<fieldset>
		<legend><?php echo __('Edit Task'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		//echo $this->Form->input('start');
                echo $this->Form->input('start', array('type'=>'text', 'disabled'=>true));
		//echo $this->Form->input('end');
                echo $this->Form->input('end', array('type'=>'text', 'minYear'=>date('Y')-5, 'maxYear'=>date('Y')+10, 'dateFormat' => 'YMD'));
		echo $this->Form->input('percentage_complete');
		echo $this->Form->input('parent_task_id');
                
                
                $usersInterfaceData = array(
                    'task_id' => $this->request->data['Task']['id']
                );
                $this->FormElements->drawTaskUserSelectionInterface($usersInterfaceData); 
                
                
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Task.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Task.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Tasks'), array('action' => 'index')); ?></li>
	</ul>
</div>
