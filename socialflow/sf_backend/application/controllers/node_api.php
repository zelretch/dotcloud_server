<?php  defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
  
class Node_api extends REST_Controller {  
    function tweet_post(){
		
		$data = $this->post();
		
		$klout = new Kcontrol();
		$klout->set_key('8y9vnq9eqgrtq67zxsxajk8b');
		
		//$data = array();
		$result = array();
		
		foreach ($data as $tweet){
			$score_tuple =array();
			$user = $tweet['user'];
			$name = $user['screen_name'];
			
			$ks = $klout->score($name);
			
			
			
			$media_score = 0;
			if (isset($tweet['entities'])){
				$entities = $tweet['entities'];
				if (!empty($entities['media'])){
					$media_score += 1;
				}
				if (!empty($entities['urls'])){
					$media_score += 1;
				}
				
			}
			$text  = $tweet['text'];
			$pos = strpos($text,'? ');
			$last = substr($text,-1);
			$question_score=0;
			if ($pos !== false){
				$question_score =1;
			}
			else if($last == '?'){
				$question_score =1;
			}
			$score_tuple['id'] = $tweet['id'];
			$score_tuple['score'] = intval($ks + 25*$media_score + 15*$question_score);
			$result[] = $score_tuple;
			
		}
		$this->response(json_encode($result),200);
		
		
	}
  

  
 
} 
class Kcontrol extends CI_Controller{

   public function set_key($key){
		$this->load->library('klout', array(
               'api_key' => $key)
        );
   }
	
    public function score($screenName){
        

        
        //Score Method
        
		
	$info = $this->klout->get_id('identity', array('screenName'=>$screenName), 'json');
		
	if(is_object($info)){
		$result = $this->klout->get_score('user',$info->id,'json');
		return $result->score;
	}
	else{
		return 0;
	}
		
		
        
		

           
            

    }    
}

