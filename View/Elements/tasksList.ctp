<div id='TasksList' class='homepageCell'>
    <h3><?php echo(_('Tasks'));?></h3>
    
    <?php
        echo $this->Html->scriptBlock('
            function renderUserTasksTableEntry(data) {
                
                var html = "<tr>";
                console.log(data[0]);
                
                var link = "'.Router::url('/').'tasks/edit/"+data[0].tasks.id;
                   
                var createdDate;
                
                if (data[0].tasks.created !="null") createdDate=data[0].tasks.created; else createdDate="<i>Not Set</i>";
                

                html+="<td><a href=\""+link+"\">"+data[0].tasks.title+"</a></td>";
                html+="<td>"+data[0].tasks.percentage_complete+"</td>";
                html+="<td>"+createdDate+"</td>";
                html+="</tr>";
                
                return html;
                
            }
            

            function renderUserTasksTable(data) {
                var html = "<table id=\"taskTable\" class=\"editPageTable\">";
                html+="<tr><td>Title</td><td>% Completed</td><td>Created</td></tr>\n";
                $.each(data,function() {
                    html+=renderUserTasksTableEntry($(this));
                });
                html+="</table>";
                return html;
            }

            
            $(document).ready(function(){
                var url = "'.Router::url('/').'users/ajax_getUserTasks/'.$userData['User']['id'].'";
                //console.log(url);
                
                $.getJSON(url, function(data) {
                    html = renderUserTasksTable(data);
                    $("#TasksList>.list").html(html);
                });
                
            }); 
        ',array('inline' => true));
     ?>
        
    <div class='list'>
        <?php echo $this->Html->image('loading.gif', array('alt' => 'loading...'));?>
    </div>
</div>