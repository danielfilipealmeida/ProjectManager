<?php
App::uses('AppController', 'Controller');
/**
 * Tasks Controller
 *
 * @property Task $Task
 */
class TasksController extends AppController {


    
    
    function getStagesData($addEmptyValue=false) {	
        /*
        $sql="SELECT * FROM stages";
        $stages = $this->Task->query($sql);
        debug ($stages);
	//$stages = $this->Task->Stage->find('list');
	if ($addEmptyValue==true) array_unshift($stages, "[NOT SET]");
	$this->set('stages', $stages);
        debug($stages);
         * 
         */
    }
        
         
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Task->recursive = 0;
		$this->set('tasks', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Task->exists($id)) {
			throw new NotFoundException(__('Invalid task'));
		}
		$options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
		$this->set('task', $this->Task->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Task->create();
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		}
                //$this->getStagesData();
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Task->exists($id)) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
			$this->request->data = $this->Task->find('first', $options);
                        
                        // set the task in the session 
                        $this->Session->write("Task", $this->request->data['Task']);
		}
                $this->getStagesData();
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Task->delete()) {
			$this->Session->setFlash(__('Task deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Task was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        
    // AJAX
        
        
    public function getTaskUsers($id = null) {
            
            $this->Task->id = $id;
            if (!$this->Task->exists()) {
		throw new NotFoundException(__('Invalid project'));
                exit();
            }
            $sqlQuery =" SELECT users.id as user_id, users.username as username, users.avatar as avatar FROM users LEFT JOIN tasks_users ON tasks_users.user_id = users.id WHERE tasks_users.task_id = '".$id."'";
            //echo($sqlQuery);exit();
            $result = $this->Task->query($sqlQuery);
            //debug($result);  
            echo(json_encode($result));
            exit();
   
        }
        
        
        public function searchUsersNotInTask($id = null, $searchString = "") {
            // optem os dados da task
            $this->Task->id = $id;
            if (!$this->Task->exists()) {
		throw new NotFoundException(__('Invalid project'));
                exit();
            }
            $options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
	    $taskData = $this->Task->find('first', $options);
            
            //debug($taskData); exit();
            
            
            // obtem todos os utilizadores que correspondem à descrição
            $sqlQuery =" SELECT users.id as user_id, users.username as username, users.avatar as avatar FROM users WHERE users.username LIKE '%".$searchString."%'";
            
            $users = $this->Task->query($sqlQuery);
            //debug($users);  exit();
            
            
            
            // retira os utilizadores que fazem parte do projecto
            $result = array();
            foreach($users as $user) {
                $sqlQuery = "SELECT count(projects_users.id) as nregs FROM projects_users  WHERE projects_users.user_id = '".$user['users']['user_id']."' AND projects_users.project_id = '".$taskData['Task']['project_id']."'";
                //echo($sqlQuery);
                $count = $this->Task->query($sqlQuery);
                if ($count[0][0]['nregs'] == 0)  $result[] = $user;
            
            }
            
            // retira os utilizadores que fazem parte da task
            
            foreach($users as $user) {
                $sqlQuery = "SELECT count(tasks_users.id) as nregs FROM tasks_users  WHERE tasks_users.user_id = '".$user['users']['user_id']."' AND tasks_users.task_id = '".$taskData['Task']['id']."'";
                //echo($sqlQuery);
                $count = $this->Task->query($sqlQuery);
                if ($count[0][0]['nregs'] == 0)  $result[] = $user;
            
            }
            
            // returns data in json
            echo(json_encode($result));
            exit();
           
        }
        
        function addUserToTask($id = null, $user_id=null) {   
            // first check if there is already a record added
            $sqlQuery = "SELECT count(id) as nregs FROM tasks_users WHERE task_id='".$id."' AND user_id='".$user_id."'";
            
            $res = $this->Task->query($sqlQuery);
            //debug($res);
            if ($res[0][0]['nregs']==0) {
                $sqlQuery = "INSERT INTO tasks_users(task_id, user_id) VALUES('".$id."', '".$user_id."')";
                //echo($sqlQuery);
                echo(json_encode($this->Task->query($sqlQuery)));
            }
            exit();
        }
        
        public function removeUserFromTask($id = null, $user_id=null) {

            
            $sqlQuery = "DELETE FROM tasks_users WHERE task_id = '".$id."' AND user_id='".$user_id."'";
            //echo($sqlQuery);
            echo(json_encode($this->Task->query($sqlQuery)));
            exit();
        }
}
