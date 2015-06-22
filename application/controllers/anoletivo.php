<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AnoLetivo extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->registro 	= $this->session->userdata('registro');
		$this->usuario 	 	= strtoupper($this->session->userdata('usuario'));		
		if(empty($this->registro) || empty($this->usuario)){
			header('location:../login/logoff');exit;
		}
	}
	

	public function index()
	{
		$head = array();
		$head['title'] = 'Ano Letivo';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('anoletivo_model');
		$body = array();
		$body['list'] = $this->anoletivo_model->getAll();
		$this->load->view('anoletivo_list', $body);
		$this->load->view('footer');
	}

	public function edit($id = null)
	{
		$head = array();
		$head['title'] = 'Ano Letivo';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('anoletivo_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->anoletivo_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/anoletivo/save';
		$body['anoletivo'] = $item;
		$this->load->view('anoletivo_form', $body);
		$this->load->view('footer');   
	}

	public function save()
	{
		$this->load->model('anoletivo_model');

		$head = array();
		$head['title'] = 'Ano Letivo';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');

		$data = array(
			'id' => $this->input->post('id'),
			'ano' => $this->input->post('ano'),
			'is_ativo' => $this->input->post('is_ativo'),
			'dt_inicio' => $this->input->post('dt_inicio'),
			'dt_termino' => $this->input->post('dt_termino'),
		);
		$body = array();

		if(empty($data['id'])):
			$msg = $this->anoletivo_model->insert($data);
		else:
			$msg = $this->anoletivo_model->update($data);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
			$data['id'] = $this->anoletivo_model->getInsertId();
		endif;

		$body['action'] = base_url() .'index.php/anoletivo/save';
		$body['anoletivo'] = (object)$data;
		$this->load->view('anoletivo_form', $body);
		$this->load->view('footer');   

	}
}

