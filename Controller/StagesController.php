<?php
App::uses('AppController', 'Controller');
/**
 * Stages Controller
 *
 * @property Stage $Stage
 */
class StagesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Stage->recursive = 0;
		$this->set('stages', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Stage->exists($id)) {
			throw new NotFoundException(__('Invalid stage'));
		}
		$options = array('conditions' => array('Stage.' . $this->Stage->primaryKey => $id));
		$this->set('stage', $this->Stage->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Stage->create();
			if ($this->Stage->save($this->request->data)) {
				$this->Session->setFlash(__('The stage has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stage could not be saved. Please, try again.'));
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
		if (!$this->Stage->exists($id)) {
			throw new NotFoundException(__('Invalid stage'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Stage->save($this->request->data)) {
				$this->Session->setFlash(__('The stage has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stage could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Stage.' . $this->Stage->primaryKey => $id));
			$this->request->data = $this->Stage->find('first', $options);
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
		$this->Stage->id = $id;
		if (!$this->Stage->exists()) {
			throw new NotFoundException(__('Invalid stage'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Stage->delete()) {
			$this->Session->setFlash(__('Stage deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Stage was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
