<?php
App::uses('AppController', 'Controller');
/**
 * Timelogs Controller
 *
 * @property Timelog $Timelog
 */
class TimelogsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Timelog->recursive = 0;
		$this->set('timelogs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Timelog->exists($id)) {
			throw new NotFoundException(__('Invalid timelog'));
		}
		$options = array('conditions' => array('Timelog.' . $this->Timelog->primaryKey => $id));
		$this->set('timelog', $this->Timelog->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Timelog->create();
			if ($this->Timelog->save($this->request->data)) {
				$this->Session->setFlash(__('The timelog has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The timelog could not be saved. Please, try again.'));
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
		if (!$this->Timelog->exists($id)) {
			throw new NotFoundException(__('Invalid timelog'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Timelog->save($this->request->data)) {
				$this->Session->setFlash(__('The timelog has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The timelog could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Timelog.' . $this->Timelog->primaryKey => $id));
			$this->request->data = $this->Timelog->find('first', $options);
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
		$this->Timelog->id = $id;
		if (!$this->Timelog->exists()) {
			throw new NotFoundException(__('Invalid timelog'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Timelog->delete()) {
			$this->Session->setFlash(__('Timelog deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Timelog was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
