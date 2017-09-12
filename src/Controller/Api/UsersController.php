<?php
namespace App\Controller\Api
;

use App\Controller\Api\ApiController;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\InternalErrorException;
use Cake\Collection\Collection;
use Cake\Log\Log;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 *
 * @method \App\Model\Entity\Project[] paginate($object = null, array $settings = [])
 */
class UsersController extends ApiController
{

    
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('FbGraphApi');
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    
    public function syncFbPages(){

        $getFbPages = $this->FbGraphApi->getPages(true);
        $patch = [];
        $newData = [];
        $pages = [];
        $patchEntities = [];
        if(!empty($getFbPages)){           
            foreach ($getFbPages['response'] as $key => $value) {
             
                $pages[$value->id] = $value;
            }
            $pageIds = array_keys($pages);

            $this->loadModel('FbPracticeInformation');
            $savedData = $this->FbPracticeInformation->find()->where(['page_id IN' => $pageIds])->all()->toArray();
            foreach ($savedData as $key => $savedValue) {
                
                $patch[$savedValue->page_id] = [
                                    'id' => $savedValue->id,
                                    'page_token' => $pages[$savedValue->page_id]->access_token,
                                    'page_name' => $pages[$savedValue->page_id]->name
                                ];

            }
            $getPatchIds = array_keys($patch);
            $newIds = array_diff($pageIds,$getPatchIds);

            if(!empty($newIds)){

                foreach ($newIds as $key => $newId) {
                    $newData[] = [
                                    'page_id' => $pages[$newId]->id,
                                    'page_name' => $pages[$newId]->name,
                                    'page_token' => $pages[$newId]->access_token,
                                    'user_id' => $this->Auth->User('id'),
                                    'status' => 1
                                ];
                }
                $newEntities = $this->FbPracticeInformation->newEntities($newData);
                $patchEntities = $this->FbPracticeInformation->patchEntities($newEntities,$newData);
            }

            if(!empty($patch)){

                $updateData = $this->FbPracticeInformation->patchEntities($savedData,$patch);
            }
            $data = array_merge($patchEntities,$updateData);
            if($this->FbPracticeInformation->saveMany($data)){
                $this->set('data',$data);
                $this->set('_serialize', 'data');
            }else{
                Log::config('error', $this->error());
            }
        }else{
          throw new BadRequestException(__('Something went wrong.'));
        }
    }
}
