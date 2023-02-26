<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
    }


	public function login_get()
	{
        $un = $this->input->get('un');
        $pwd = $this->input->get('pwd');
        $check=$this->Users_model->login($un,$pwd); 
        if($check['status']==1){
            echo $this->response(array("status"=>"OK", "data"=>$check['data'], "msg"=>"Success"), 200);
        }else if($check['status']==2){
            echo $this->response(array("status"=>"NOK", "data"=>"no data", "msg"=>$check['msg']), 200);
        }else{
            echo $this->response(array("status"=>"NOK", "data"=>"no data", "msg"=>$check['msg']), 200);
        }
	}
}
