<?php
class Kcontrol extends Controller{

    function index(){
        $this->load->library('klout', array(
                'api_key' => '', // Enter Klout API key here (http://developer.klout.com/member/register)
        ));
       
            // Score Method
            $info = $this->klout->get('klout', array('users' => 'tbrandonbeasley'), 'json');
            $this->print_code($info);

            //Users Method
            $info = $this->klout->get('users/show', array('users' => 'tbrandonbeasley'), 'json');
            $this->print_code($info);

            // Influence Method
            $info = $this->klout->get('soi/influenced_by', array('users' => 'tbrandonbeasley'), 'json');
            $this->print_code($info);
            
            // Topic Method
            $info = $this->klout->get('topics/search', array('topic' => 'seo'), 'json');
            $this->print_code($info);

           
            // Legacy Methods and POST are not supported at this time

         
    }

    function print_code($code_var){
        echo "<pre>";
        print_r($code_var);
        echo "</pre><hr>";
     }
}

