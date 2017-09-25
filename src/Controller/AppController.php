<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
  public function isAuthorized($user)
  {
    return true;
  }

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
      parent::initialize();

      $this->loadComponent('RequestHandler');
      $this->loadComponent('Flash');
      $this->loadComponent('Auth', [
        'authorize' => 'Controller',
        'unauthorizedRedirect' => [
        'controller' => 'Users',
        'action' => 'login'
        ],
        'authError' => 'You should not be peeking around here'
        ]);
        
        $this->Auth->allow([ 'winner','activeChallenge','triviaWinner','winnerPage','responseSubmitted','challengeWinners','postWinner']);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
      }

      public function beforeFilter(Event $event)
      {
        $user = $this->Auth->user();
        if(!empty($user) && isset($user['role'])){  
          $sideNavData = ['id'=>$user['id'],'first_name' => $user['name'],'last_name' => '','role_name' => $user['role']['name'],];
          $this->set('sideNavData', $sideNavData);
        }
      }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */

    public function beforeRender(Event $event)
    {
      // Note: These defaults are just to get started quickly with development
      // and should not be used in production. You should instead set "_serialize"
      // in each action as required.
      if($this->response->getStatusCode() == 200) {
        $user = $this->Auth->user();
        $this->viewBuilder()->theme('InspiniaTheme');
        $title = "Trivia Game";
        if($user['role']['name'] == 'superAdmin'){
          $menu = Configure::read('Menu.Admin');
        }else{
          $menu = Configure::read('Menu.StaffAdmin');
        }
        if($menu){
          $nav = $this->checkLink($menu, $user['role']['name']); 
          // pr($nav); die;     
          $this->set('sideNav',$nav['children']);
        }
        $this->set(compact('title'));
      }

      if (!array_key_exists('_serialize', $this->viewVars) &&
        in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
        $this->set('_serialize', true);
    }
  }

  public function checkLink($nav = [], $role = false){
    $currentLink = [
    'controller' => $this->request->params['controller'],
    'action' => $this->request->params['action']
    ];
    $check = 0;
    foreach($nav as $key => &$value){
            // pr($value);
            //Figure out active class
      if($value['link'] == '#'){
        $response = $this->checkLink($value['children'], $role);
        $value['children'] = $response['children'];
        $value['active'] = $response['active'];
      } else {
        $value['active'] = empty(array_diff($currentLink, $value['link'])) ? 1 : 0;
      }

      if(isset($value['active']) && $value['active']){
        $check = 1;
      }
            //Figure out whether to show or not
      if($role){
        $show = 0;
                //role is not in show_to_roles
        if(empty($value['show_to_roles'])) {
          $show = 1;
        } elseif (in_array($role, $value['show_to_roles'])) {
          $show = 1;
        } 
        if($show){
          if(empty($value['hide_from_roles'])) {
            $show = 1;
          } elseif (in_array($role, $value['hide_from_roles'])) {
            $show = 0;
          }   
        }
        $value['show'] = $show;
      } else {
        $value['show'] = 1;
      }
    }
    return ['children' => $nav, 'active' => $check];
  }


}
