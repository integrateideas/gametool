<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Network\Session;
use Cake\I18n\Time;
use Cake\Cache\Cache;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
const USER_LABEL='user';
    public function initialize()
    {
        parent::initialize();
         $this->loadComponent('FbGraphApi');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->Auth->allow(['add','logout', 'login','index']);
    }
     public function isAuthorized($user)
  {
    if($user['role']->name === self::USER_LABEL){
      return true;
    }
    return parent::isAuthorized($user);
  }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // $response = $this->FbGraphApi->postOnFb('2523215881152447','hello dj sdfsd',null,'EAADqlEo5enwBAOWc5VprS2G1yhp8mF2vsQ01KvFuKyfe0O8NBiGKzlcGdVVCLKlMmRDhbkg12LW4rhfahZAkiB8hxCCaScZBHzbTgE1FgTc8YXCvXIsWOsdTEb3CaG7bCTeiIISjyJG8Sv7PadbSqpZB0u3jcwQOJySU99OVX2iqmG7FsAn',false);
        
        $this->paginate = [
        'contain' => ['Roles']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'UserChallengeResponses']
            ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function login()
    {
        $this->viewBuilder()->layout('login-admin');
        if (!isset($_GET['state'])) {
            $resp = $this->FbGraphApi->getFbLoginUrl();
            $this->set('fbLoginUrl', $resp['response']);
            return;
        }else{
            $user = $this->_getUser();
            if($user){
              $this->loadModel('Roles');
              $user['role']=$query = $this->Roles->find('RolesById',['role' =>$user['role_id']])->select(['name','label'])->first();
              $this->Auth->setUser($user);
              if( !empty($query) && $query->name == self::USER_LABEL){
                $this->redirect(['controller' => 'Users',
                    'action' => 'index'
                    ]);
                return;
            }else{
              return $this->redirect($this->Auth->logout());
          }
      }else{
        $this->Flash->error('Unable to identify you.');
        $this->redirect(['controller' => 'Users','action' => 'login']);
    }
    }
}
private function _getUser(){
  $resp = $this->FbGraphApi->getAccessToken();
  if(!$resp['status']){
    return false;
  }
  return $this->_checkIsUserRegisterd($this->FbGraphApi->getMe());
}
private function _checkIsUserRegisterd($resp){
  if(!$resp['status']){
    return false;
  }
  $this->loadModel('UserSocialConnections');
  $userData = $resp['response'];
  $user = $this->UserSocialConnections->find()->contain(['Users'])->where(['social_connection_identifier'=>$userData->id,'social_connection_id'=>1])->first();
  if(!$user){
    $user = array();
    $user['name']=$userData->name;
    if(isset($userData->email) && !empty($userData->email)){
      $user['email']=$userData->email;
      $user['username']=$userData->email;
    }else{
      $user['username'] = $this->_suggestUserName($userData->name);
    }
    $user['password']= $this->_cryptographicString();
    $user['role_id']= 2;
    $user['user_social_connections'][]=['social_connection_identifier'=>$userData->id,'social_connection_id'=>1];

    $user = $this->Users->patchEntity($this->Users->newEntity($user), $user);
    if(!$this->Users->save($user)){
      return false;
    }
  }else{
    $user = $user->user;
  }
  return $user;
}
private function _suggestUserName($name){
  $count = $this->Users->find()->where(['username'=>$name])->count();
  return ($count)?$name.$count:$name;
}
public function logout()
{
    $id = $this->Auth->user('id');
  Cache::delete('f_u_t'.$id);
  Cache::delete('f_u_p'.$id);
  Cache::delete('f_p_t'.$id);
  Cache::delete('f_p_n'.$id);
  $this->Flash->success('You are now logged out.');
  $this->redirect($this->Auth->logout());
}

protected function _fireEvent($name, $data){
    $name = 'Triviagame.'.$name;
    $event = new Event($name, $this, [
        $name => $data
        ]);
    $this->eventManager()->dispatch($event);
}
private function _cryptographicString( $type = 'alnum', $length = 8 )
{
  switch ( $type ) {
    case 'alnum':
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    break;
    case 'alpha':
    $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    break;
    case 'hexdec':
    $pool = '0123456789abcdef';
    break;
    case 'numeric':
    $pool = '0123456789';
    break;
    case 'nozero':
    $pool = '123456789';
    break;
    case 'distinct':
    $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
    break;
    default:
    $pool = (string) $type;
    break;
  }

  $crypto_rand_secure = function ( $min, $max ) {
    $range = $max - $min;
    if ( $range < 0 ) return $min; // not so random...
    $log    = log( $range, 2 );
    $bytes  = (int) ( $log / 8 ) + 1; // length in bytes
    $bits   = (int) $log + 1; // length in bits
    $filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
    do {
      $rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
      $rnd = $rnd & $filter; // discard irrelevant bits
    } while ( $rnd >= $range );
    return $min + $rnd;
  };

  $token = "";
  $max   = strlen( $pool );
  for ( $i = 0; $i < $length; $i++ ) {
    $token .= $pool[$crypto_rand_secure( 0, $max )];
  }
  return $token;
}
}
