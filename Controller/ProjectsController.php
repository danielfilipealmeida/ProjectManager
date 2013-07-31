<?php
App::uses('AppController', 'Controller');
/**
 * Projects Controller
 *
 * @property Project $Project
 */
class ProjectsController extends AppController {

    public $helpers = array('FormElements' ,'Js' => array('Jquery'));
    
    
    public $paginate = array(
        'limit' => 25,
        'order' => array('Project.created' => 'desc', 'Project.id' => 'desc')
    );
        
        
/**
 * index method
 *
 * @return void
 */
	public function index() {
            
             //debug($this->Project->Users);
            $userID=0;
            //debug($this->Session);
		$this->Project->recursive = 0;

                //$this->Project->bindModel(array('hasAndBelongsToMany '=> array('Users')), false);  
		$this->set('projects', $this->paginate());
                $this->getUsersData();
                
               
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__('Invalid project'));
		}
		$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
		$this->set('project', $this->Project->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Project->create();
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The project has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
                
                
            
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__('Invalid project'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The project has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
			$this->request->data = $this->Project->find('first', $options);
                        
                        // set the project in the session 
                        //debug($this->request->data);
                        $this->Session->write("Project", $this->request->data['Project']);
		}
                $this->getUsersData();
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			throw new NotFoundException(__('Invalid project'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Project->delete()) {
			$this->Session->setFlash(__('Project deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Project was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        public function getUsersData($addEmptyValue=false) {	        
	    $users = $this->Project->Users->find('list');
	    if ($addEmptyValue==true) array_unshift($users, "[NOT SET]");
            $this->set('users', $users);
            
	}
        
        
        public function getProjectUsers($id = null) {
            $this->Project->id = $id;
            if (!$this->Project->exists()) {
		throw new NotFoundException(__('Invalid project'));
                exit();
            }
            
            $sqlQuery =" SELECT users.id as user_id, users.username as username, users.avatar as avatar FROM users LEFT JOIN projects_users ON projects_users.user_id = users.id WHERE projects_users.project_id = '".$id."'";
            //echo($sqlQuery);
            $result = $this->Project->query($sqlQuery);
            //debug($result);  
            echo(json_encode($result));
            exit();
        }
        
        public function searchUsersNotInProject($id = null, $searchString = "") {
            $this->Project->id = $id;
            if (!$this->Project->exists()) {
		throw new NotFoundException(__('Invalid project'));
                exit();
            }
            
            // obtem todos os utilizadores que correspondem à descrição
            $sqlQuery =" SELECT users.id as user_id, users.username as username, users.avatar as avatar FROM users WHERE users.username LIKE '%".$searchString."%'";
            
            $users = $this->Project->query($sqlQuery);
            //debug($result);  
            
            // retira os utilizadores que fazem parte do projecto
            $result = array();
            foreach($users as $user) {
                $sqlQuery = "SELECT count(projects_users.id) as nregs FROM projects_users WHERE projects_users.user_id = '".$user['users']['user_id']."' AND projects_users.project_id = '".$id."'";
                $count = $this->Project->query($sqlQuery);
                if ($count[0][0]['nregs'] == 0)  $result[] = $user;
            
            }
            echo(json_encode($result));
            exit();
           
        }
        
        public function removeUserFromProject($id = null, $user_id=null) {
            // check if the user is the owner of the project and only delete if not.
            $sqlQuery = "SELECT user_id FROM projects WHERE id = '".$id."'";
            $res = $this->Project->query($sqlQuery);
            if ($res[0]['projects']['user_id'] == $user_id)exit();
            
            $sqlQuery = "DELETE FROM projects_users WHERE project_id = '".$id."' AND user_id='".$user_id."'";
            //echo($sqlQuery);
            echo(json_encode($this->Project->query($sqlQuery)));
            exit();
        }
        
        public function addUserToProject($id = null, $user_id=null) {   
            // first check if there is already a record added
            $sqlQuery = "SELECT count(id) as nregs FROM projects_users WHERE project_id='".$id."' AND user_id='".$user_id."'";
            
            $res = $this->Project->query($sqlQuery);
            //debug($res);
            if ($res[0][0]['nregs']==0) {
                $sqlQuery = "INSERT INTO projects_users(project_id, user_id) VALUES('".$id."', '".$user_id."')";
                //echo($sqlQuery);
                echo(json_encode($this->Project->query($sqlQuery)));
            }
            exit();
        }
        
        public function getProjectTasks($id = null) {
            $sqlQuery ="SELECT * FROM tasks WHERE project_id='".$id."'";
            echo(json_encode($this->Project->query($sqlQuery)));
            exit();
        }
}
