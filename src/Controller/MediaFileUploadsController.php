<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Cache\Cache;
/**
 * MediaFileUploads Controller
 *
 * @property \App\Model\Table\MediaFileUploadsTable $MediaFileUploads
 *
 * @method \App\Model\Entity\MediaFileUpload[] paginate($object = null, array $settings = [])
 */
class MediaFileUploadsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $mediaFileUploads = $this->paginate($this->MediaFileUploads);

        $this->set(compact('mediaFileUploads'));
        $this->set('_serialize', ['mediaFileUploads']);
    }

    /**
     * View method
     *
     * @param string|null $id Media File Upload id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mediaFileUpload = $this->MediaFileUploads->get($id, [
            'contain' => []
        ]);

        $this->set('mediaFileUpload', $mediaFileUpload);
        $this->set('_serialize', ['mediaFileUpload']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mediaFileUpload = $this->MediaFileUploads->newEntity();
        if ($this->request->is('post')) {
            $mediaFileUpload = $this->MediaFileUploads->patchEntity($mediaFileUpload, $this->request->getData());
            
            if ($this->MediaFileUploads->save($mediaFileUpload)) {
                $this->Flash->success(__('The media file upload has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The media file upload could not be saved. Please, try again.'));
        }
        $this->set(compact('mediaFileUpload'));
        $this->set('_serialize', ['mediaFileUpload']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Media File Upload id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mediaFileUpload = $this->MediaFileUploads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mediaFileUpload = $this->MediaFileUploads->patchEntity($mediaFileUpload, $this->request->getData());
            if ($this->MediaFileUploads->save($mediaFileUpload)) {
                $this->Flash->success(__('The media file upload has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The media file upload could not be saved. Please, try again.'));
        }
        $this->set(compact('mediaFileUpload'));
        $this->set('_serialize', ['mediaFileUpload']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Media File Upload id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mediaFileUpload = $this->MediaFileUploads->get($id);
        if ($this->MediaFileUploads->delete($mediaFileUpload)) {
            $this->Flash->success(__('The media file upload has been deleted.'));
        } else {
            $this->Flash->error(__('The media file upload could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
