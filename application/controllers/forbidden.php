<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forbidden extends CI_Controller {

	public function index($msg = null)
	{
		$head = array();
		$head['title'] = 'Acesso Proibido';
		$this->load->view('header', $head);
		$this->load->view('forbidden_index');
		$this->load->view('footer');
	}
}	
