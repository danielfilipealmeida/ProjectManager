<div id='ProjectsList' class='homepageCell'>
    <h3><?php echo(_('Projects'));?></h3>
    
    <?php
        echo $this->Html->scriptBlock('
            function renderUserProjectsTableEntry(data) {
                
                var html = "<tr>";
                console.log(data[0]);
                
                var link = "'.Router::url('/').'projects/edit/"+data[0].projects.id;
                   
                var createdDate;
                
                if (data[0].projects.created !="null") createdDate=data[0].projects.created; else createdDate="<i>Not Set</i>";
                

                html+="<td><a href=\""+link+"\">"+data[0].projects.title+"</a></td>";
                html+="<td>"+data[0].projects.percentage_complete+"</td>";
                html+="<td>"+createdDate+"</td>";
                html+="</tr>";
                
                return html;
                
            }
            

            function renderUserProjectsTable(data) {
                var html = "<table id=\"taskTable\" class=\"editPageTable\">";
                html+="<tr><td>Title</td><td>% Completed</td><td>Created</td></tr>\n";
                $.each(data,function() {
                    html+=renderUserProjectsTableEntry($(this));
                });
                html+="</table>";
                return html;
            }

            
            $(document).ready(function(){
                var url = "'.Router::url('/').'users/ajax_getUserProjects/'.$userData['User']['id'].'";
                //console.log(url);
                
                $.getJSON(url, function(data) {
                    html = renderUserProjectsTable(data);
                    $("#ProjectsList>.list").html(html);
                });
                
            }); 
        ',array('inline' => true));
     ?>
        
    <div class='list'>
        <?php echo $this->Html->image('loading.gif', array('alt' => 'loading...'));?>
    </div>
</div>