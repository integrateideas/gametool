<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Client;
use Cake\Network\Exception\BadRequestException;
use Cake\Log\Log;
use Cake\Core\Configure;
use Firebase\JWT\JWT;
use Cake\Collection\Collection;
use Cake\Utility\Security;
use Cake\Cache\Cache;

class FbGraphApiComponent extends Component{
  private  $_fb = null;
  private $_uniqueVar = null;
  public $components = ['Auth'];
  public function initialize(array $config){
    $this->_fb = new \Facebook\Facebook([
      'app_id' => Configure::read('application.fbAppId'),
      'app_secret' =>Configure::read('application.fbAppSecret'),
      'default_graph_version' => 'v2.9',
    ]);
    // $components = array('Auth');
    $this->_uniqueVar  = $this->Auth->user('id');


  }
  public function getFbLoginUrl(){

    $helper = $this->_fb->getRedirectLoginHelper();
    // pr($this->request);die;
    $permissions = ['email','manage_pages','publish_pages','pages_show_list'];
    $loginUrl = $helper->getLoginUrl(Configure::read('application.baseUrl').'/users/login', $permissions);
    return ['status'=>true,'response'=>$loginUrl];
  }
  public function getAccessToken(){
    if (!(isset($_GET['state'])) && !Cache::read('f_u_t'.$this->_uniqueVar)){
      $loginUrl = $this->getFbLoginUrl();
      header("Location: ".$loginUrl['response']);
      die('hello');
    }
    $helper = $this->_fb->getRedirectLoginHelper();
    if (isset($_GET['state'])) {
      $helper->getPersistentDataHandler()->set('state', $_GET['state']);
    }
    $accessToken = null;
    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      return ['status'=>false,'response'=>$e->getMessage()];
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      return ['status'=>false,'response'=>$e->getMessage()];
    }
    if ($accessToken) {
      $oAuth2Client = $this->_fb->getOAuth2Client();

      // Get the access token metadata from /debug_token
      $tokenMetadata = $oAuth2Client->debugToken($accessToken);
      $tokenMetadata->validateAppId(Configure::read('application.fbAppId'));
      // If you know the user ID this access token belongs to, you can validate it here
      $tokenMetadata->validateExpiration();

      if (! $accessToken->isLongLived()) {
        // Exchanges a short-lived access token for a long-lived one
        try {
          $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
          return ['status'=>false,'response'=>$e->getMessage()];
        }
      }
      Cache::write('f_u_t'.$this->_uniqueVar,$accessToken->getValue());
      return ['status'=>true,'response'=>$accessToken->getValue()];
    } else {
      return ['status'=>false,'response'=>$helper->getError()];
    }
  }
  private function _getAccessToken(){
    if(Cache::read('f_u_t'.$this->_uniqueVar)){
      return Cache::read('f_u_t'.$this->_uniqueVar);
    }else{
      $token = $this->getAccessToken();
      return $token['response'];
    }
  }

  public function getMe(){
    $accessToken = $this->_getAccessToken();
    $response = $this->_fb->get('/me?fields=id,name,email', $accessToken);
    $response = $response->getGraphUser();
    return ['status'=>true,'response'=>json_decode($response->asJson())] ;
  }

  public function getPages($refreshList =false){
    if(!Cache::read('f_u_p'.$this->_uniqueVar)  ||  $refreshList){
      $accessToken = $this->_getAccessToken();
      $response = $this->_fb->get('/me/accounts?limit=1000', $accessToken);
      $response = $response->getGraphEdge();
      Cache::write('f_u_p'.$this->_uniqueVar,$response->asJson());
    }
    $fbPageList = json_decode(Cache::read('f_u_p'.$this->_uniqueVar));
    $fbPageTokenMap = [];
    if($fbPageList){
      foreach ($fbPageList as $key => $value) {
        $fbPageTokenMap[$value->id] = $value->access_token;
      }
      Cache::write('f_p_t'.$this->_uniqueVar,serialize($fbPageTokenMap));
      $fbPageTokenMap = [];
      foreach ($fbPageList as $key => $value) {
        $fbPageTokenMap[$value->id] = $value->name;
      }
      Cache::write('f_p_n'.$this->_uniqueVar,serialize($fbPageTokenMap));
    }
    return ['status'=>true,'response'=>($fbPageList)] ;
  }

  public function postOnFb($pageId,$message,$link,$pageAccessToken,$scheduledPublishTime = false ){
    $url = "/$pageId/feed";
    $data = [
      'message'=>$message,
    ];
    if($link){
      $data['link'] = $link;
    }
    if($scheduledPublishTime){
      $data['scheduled_publish_time'] = $scheduledPublishTime;
      $data['published'] = false;
    }
    $response =  $this->_fb->post($url,$data, $pageAccessToken);
    if($response){
      return ['status'=>true,'response'=>json_decode($response->getBody())] ;
    }else{
      return ['status'=>false,'error'=>$response->getBody()] ;
    }
  }

  public function postPhotoStory($pageId,$message,$imageUrl,$pageAccessToken,$scheduledPublishTime){
    $url = "/$pageId/photos";
    $data = [
      'caption'=>$message,
    ];
    if($scheduledPublishTime){
      $data['scheduled_publish_time'] = $scheduledPublishTime;
      $data['published'] = false;
    }
    if($imageUrl){
      $data['url'] = $imageUrl;
    }
    $response =  $this->_fb->post($url,$data, $pageAccessToken);
    if($response){
      return ['status'=>true,'response'=>json_decode($response->getBody())] ;
    }else{
      return ['status'=>false,'error'=>$response->getBody()] ;
    }
  }

  public function deletePost($postId,$pageAccessToken){
    $response = $this->_fb->delete("/$postId",[],$pageAccessToken);
    return ['status'=>true,'response'=>json_decode($response->getBody())] ;
  }

  public function readComments($postId,$pageAccessToken){
    $response = $this->_fb->get("/$postId/comments?limit=1000", $pageAccessToken);
    $response = $response->getGraphEdge();
    return ['status'=>true,'response'=>$response->asJson()] ;
  }

  public function postComment($objectId,$message,$pageAccessToken){
    $response = $this->_fb->post("/$objectId/comments",['message'=>$message], $pageAccessToken);

    return ['status'=>true,'response'=>$response->getBody()] ;
  }

  public function likeObject($objectId,$pageAccessToken){
    $response = $this->_fb->post("/$objectId/likes?limit=1000", [],$pageAccessToken);
    return ['status'=>true,'response'=>$response->getBody()] ;
  }
  public function deleteComment($objectId,$pageAccessToken){
    $response = $this->_fb->delete("/$objectId/likes", $pageAccessToken);
    $response = $response->getGraphEdge();
    return ['status'=>true,'response'=>$response->asJson()] ;
  }


}
?>
