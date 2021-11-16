<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyController extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library(['session']);
    $this->load->helper('url');
    if($this->session->userdata('site_lang') != ""){
        $this->lang->load("labels",$this->session->userdata('site_lang'));
    }else{
        $this->lang->load("labels","english");
    }

  }

  public function change_language($language = ""){
      $language = ($language != "") ? $language : "english";
      $this->session->set_userdata('site_lang', $language);
      redirect(base_url());
  }

}
