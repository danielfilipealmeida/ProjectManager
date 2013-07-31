<?php
//$editCurrentUserLink = ;
//debug($userData['User']);

//debug($this->Session->read("Project"));
//debug($this->Session->read("Project2"));

// user link
$userLink = $this->Html->link(String::wrap($userData['User']['username'],30), array("controller"=>"users", "action"=>"edit", $userData['User']['id']));

// project link
if ($this->Session->read("Project")==null) {
    $projectLink = "<i>Not Set</i>";
}
else  {
    $projectData=$this->Session->read("Project");
    $projectLink = $this->Html->link(String::wrap($projectData['title'],30), array("controller"=>"projects", "action"=>"edit", $projectData['id'])); 
}

// task link

if ($this->Session->read("Task")==null) {
    $taskLink = "<i>Not Set</i>";
}
else 
{
    $projectData=$this->Session->read("Task");
    $taskLink = $this->Html->link($projectData['title'], array("controller"=>"tasks", "action"=>"edit", $projectData['id'])); 
}

?>
<div id='infoDiv'> 
        <p>User: <?php echo $userLink;?></p>
        <p>Project: <?php echo $projectLink;?></p>
        <p>Task: <?php echo $taskLink;?></p>
        </dd></dd>
    </dl>
</div>