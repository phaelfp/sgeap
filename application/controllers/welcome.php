<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->registro 	= $this->session->userdata('registro');
		$this->usuario 	 	= strtoupper($this->session->userdata('usuario'));
		$this->menu 	 	= $this->session->userdata('menu');
		if(empty($this->registro) || empty($this->usuario)){
			header('location:../login/logoff');exit;
		}
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}
}
