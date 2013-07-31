<?php
?>
<div id="menuDiv">
    <ul id="menu">
        <li><?php echo($this->Html->link(__("Homepage",TRUE), array('controller'=>'', 'action'=>'index')));?></li>
        <li><?php echo($this->Html->link(__("Projects",TRUE), array('controller'=>'projects', 'action'=>'index')));?></li>
        <li><?php echo($this->Html->link(__("Tasks",TRUE), array('controller'=>'tasks', 'action'=>'index')));?></li>
        <li><?php echo($this->Html->link(__("Timelogs",TRUE), array('controller'=>'timelogs', 'action'=>'index')));?></li>
        <li><?php echo($this->Html->link(__("Users",TRUE), array('controller'=>'users', 'action'=>'index')));?></li>
 
    
        <?php if(isset($userData) and !empty($userData)) {?>
       <li><?php echo($this->Html->link(__("Logout",TRUE), array('controller'=>'users', 'action'=>'logout')));?></li>
       <?php } else { ?>
       <li><?php echo($this->Html->link(__("Login",TRUE), array('controller'=>'users', 'action'=>'login')));?></li>       
       <?php } ?>
    </ul>
    <br class='clearLeft' />
</div>