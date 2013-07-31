<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
    
       public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        )
    );
       
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }
    
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $loginData = $this->request->data['User'];
                
                $userData = $this->User->find('first', array(
                    'conditions' => array('username' =>  $loginData['username'])
                ));

                $this->Session->write("userData", $userData);
                
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
    }

    public function logout() {
        $this->Session->delete("userData");
        $this->redirect($this->Auth->logout());
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        public function beforeSave($options = array()) {
            if (isset($this->data[$this->alias]['password'])) {
                $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
            }
            return true;
        }
        
        
        ////////////////////////
        // AJAX FUNCTIONS
        ////////////////////////
        
        public function ajax_getUserProjects($id = null) {
            $sqlQuery ="SELECT projects.id as id, projects.title as title, projects.percentage_complete as percentage_complete, projects.created as created FROM projects LEFT JOIN projects_users ON projects_users.project_id = projects.id WHERE projects_users.user_id='".$id."'";
            echo(json_encode($this->User->query($sqlQuery)));
            exit();
        }
        

        public function ajax_getUserTasks($id = null) {
            $sqlQuery ="SELECT tasks.id as id, tasks.title as title, tasks.percentage_complete as percentage_complete, tasks.created as created FROM tasks LEFT JOIN tasks_users ON tasks_users.task_id = tasks.id WHERE tasks_users.user_id='".$id."'";
            echo(json_encode($this->User->query($sqlQuery)));
            exit();
        }

}
