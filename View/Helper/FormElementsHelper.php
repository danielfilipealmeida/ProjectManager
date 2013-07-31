<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class FormElementsHelper extends AppHelper {
    public $helpers = array('Html', 'Js', 'Form');

    function drawUsersSelectionInterface($data) {
        if ($data['mode'] == "project") {
            $controller = "projects";
            $idField = "project_id";
            $getter = "getProjectUsers";
            $searcher = "searchUsersNotInProject";
            $adder = 'addUserToProject';
            $remover ='removeUserFromProject';
        }
        if ($data['mode'] == "task") {
            $controller="tasks";
            $idField = "task_id";
            $getter = "getTaskUsers";
            $searcher = "searchUsersNotInTask";
            $adder = 'addUserToTask';
            $remover ='removeUserFromTask';
        }
        ?>
<div id='usersSelection'>
    <?php echo $this->Html->image('loading.gif', array('alt' => 'loading data...'));?> Getting data
</div>


        <?php
         echo $this->Form->input('Add a new User', array('id'=>'userSelectorInput', 'after' => 'type a user name.'));
       ?>

<div id='usersList'>
</div>

        <?php
      
        // jquery code to handle the users selection interface
        //$this->Js->JqueryEngine->jQueryObject = '$j';
        echo $this->Html->scriptBlock(
            '
                // possible modes: add, remove
                function renderUserCell(data, mode) {
                    var user_id = data[0].users.user_id;
                    var user_name = data[0].users.username;
                    var user_image;
                    if (data[0].users.avatar=="" || data[0].users.avatar==null) user_image = "'.Router::url('/').'/img/avatars/default-small.gif";
                    else user_image = "/img/avatars/"+data[0].users.avatar;
                    var html = "<div class=\"userCell\">";
                    html+="    <img src=\""+user_image+"\" />";
                    html+="    <p>"+user_name+"</p>";
                    html+="<center>";
                    if (mode == "add") {
                        html+="<button type=\"button\" class=\"AddUserButton\" userID=\""+user_id+"\">Add</button>";
                    } else {
                        html+="<button type=\"button\" class=\"RemoveUserButton\" userID=\""+user_id+"\">Remove</button>";
                    }
                    html+="</center>";
                    html+="</div>";
                    return html;
                    //console.log(data);
                    //console.log(data);
                }
                function renderAllUsersCells(data) {
                    var html="";
                    $.each(data, function() {
                        html+=renderUserCell($(this, "remove"));
                    });
                   
                   if (html!="") {
                        //html+="eeere<br style=\"clear:both\">";
                        $(document).on("click", ".RemoveUserButton", function() {
                            
                            var user_id = $(this).attr("userid");
                            var url = "'.Router::url('/').$controller.'/'.$remover.'/'.$data[$idField].'/"+user_id;
                                console.log(url);
                                
                            $.getJSON(url, function(data) {
                                //renderAllUsersCells(data);
                                getUsers();                         
                            });
                        });
                   }
                   $("#usersSelection").html(html);
                }
                function getUsers() {
                    var url = "'.Router::url('/').$controller.'/'.$getter.'/'.$data[$idField].'";
                    console.log(url);
                    
                    $.getJSON(url, function(response) {
                        renderAllUsersCells(response);
                    });
                }
                $(document).ready(function() {
                    getUsers();
                    
                });
                
                function handleUserSelectorInput() {
                    var input = $("#userSelectorInput").val();
                    
                    if (input.length>1) {
                        // get all members not in this project
                        var url = "'.Router::url('/').$controller.'/'.$searcher.'/'.$data[$idField].'/"+input;
                          console.log(url);
                          
                        $.getJSON(url, function (data) {
                            //console.log(data);
                            var html="";
                            $.each(data,function() {
                                html+=renderUserCell($(this),"add");
                            });
                            
                            if (html!="") {
                                html+="<br style=\"clear:both\">";
                                $(document).on("click", ".AddUserButton", function() {
                                    var user_id = $(this).attr("userid");
                                    var url = "'.Router::url('/').$controller.'/'.$adder.'/'.$data[$idField].'/"+user_id;
                                     console.log(url);
                                    $.getJSON(url, function(response) {
                                        //console.log(response);
                                        getUsers();
                                        $("#usersList").html("");
                                        $("#userSelectorInput").val("");
                                    });
                                    
                                    
                                });
                            }
                            $("#usersList").html(html);
                        });
                    }
                }
            ',
            array('inline' => true)
        );

        //$this->Js->get('#usersSelection')->event('click','alert("#34");');
        $this->Js->get('#userSelectorInput')->event('keyup','handleUserSelectorInput()');
        
    }
    
    function drawProjectUserSelectionInterface($data) {

        
        echo('<h3>Project Users</h3>');
        $data['mode'] = "project";
        $this->drawUsersSelectionInterface($data);
    }
    
    
    
    function drawProjectTasksInterface($data) {
        $controller = "projects";
        $getter = "getProjectTasks";
        ?>
<h3>Project Tasks</h3>
<div id='projectTasksTable'></div>
        <?php
         echo $this->Html->scriptBlock('
            function renderTaskRow(data) {
                var html = "<tr>";
                console.log(data[0].tasks);
                var link = "'.Router::url('/').'tasks/edit/"+data[0].tasks.id;
                var createdDate;
                
                if (typeof data[0].tasks.created !="null") createdDate=data[0].tasks.created; else createdDate="<i>Not Set</i>";
                html+="<td><a href=\""+link+"\">"+data[0].tasks.title+"</a></td>";
                html+="<td>"+data[0].tasks.percentage_complete+"</td>";
                html+="<td>"+createdDate+"</td>";
                html+="</tr>";
                
                return html;
            }

            function renderProjectTasksTable(data) {
                var html = "<table id=\"taskTable\" class=\"editPageTable\">";
                html+="<tr><td>Title</td><td>% Completed</td><td>Created</td></tr>\n";
                $.each(data,function() {
                    html+=renderTaskRow($(this));
                });
                html+="</table>";
                return html;
            }
            
            function handleProjectTasksTable() {
               
            }
            
            $(document).ready(function(){
                handleProjectTasksTable();
                var url = "'.Router::url('/').$controller.'/'.$getter.'/'.$data['project_id'].'";
                    console.log(url);
                                
                            $.getJSON(url, function(data) {
                                html = renderProjectTasksTable(data);
                                $("#projectTasksTable").html(html);
                            });
            }); 
        ',array('inline' => true));
        //$this->Js->event('ready', 'handleProjectTasksTable()');
    }
    
    
    function drawTaskUserSelectionInterface($data) {
        echo('<h3>Task Users</h3>');
        $data['mode'] = "task";
        $this->drawUsersSelectionInterface($data);
    }
    
    
}


?>
