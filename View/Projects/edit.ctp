<?php
$this->Html->addCrumb('Projects', '/projects');
$this->Html->addCrumb('Edit Project', '');


echo $this->Html->scriptBlock(
    '
    $(function() {
        $("#ProjectEnd").datepicker({ dateFormat: "yy-mm-dd" });
        //$("#ProjectEnd").datepicker({ dateFormat: "yy-mm-dd" });
   });       
    ',
    array('inline' => true)
);
?>
<div class="projects form">
<?php echo $this->Form->create('Project'); ?>
	<fieldset>
		<legend><?php echo __('Edit Project'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('user_id', array('options'=>$users, 'label' => 'Owner'));
		echo $this->Form->input('percentage_complete');
		echo $this->Form->input('end', array('type'=>'text', 'minYear'=>date('Y')-5, 'maxYear'=>date('Y')+10, 'dateFormat' => 'YMD'));
                
                
                $usersInterfaceData = array(
                    'project_id' => $this->request->data['Project']['id']
                );
                $this->FormElements->drawProjectUserSelectionInterface($usersInterfaceData); 
                
                $projectTasksData = array(
                    'project_id' => $this->request->data['Project']['id']
                );
                $this->FormElements->drawProjectTasksInterface($projectTasksData);
                
        ?>
                
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Project.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Project.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Projects'), array('action' => 'index')); ?></li>
	</ul>
</div>
