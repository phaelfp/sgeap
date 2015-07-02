<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Certificacao extends CI_Controller {

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
		$head['title'] = 'Certificação';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('certificacao_model');
		$body = array();
		$body['list'] = $this->certificacao_model->getAll();
		$this->load->view('certificacao_list', $body);
		$this->load->view('footer');
	}

	public function edit($id = null)
	{
		$head = array();
		$head['title'] = 'Certificação';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('certificacao_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->certificacao_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/certificacao/save';
		$body['certificacao'] = $item;
		$body['certificacoes'] = $this->certificacao_model->getAll();
		$this->load->view('certificacao_form', $body);
		$this->load->view('footer');   
	}

	public function save()
	{
		$this->load->model('certificacao_model');

		$head = array();
		$head['title'] = 'Certificação';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');

		$data = array(
			'id' => $this->input->post('id'),
			'descricao' => $this->input->post('descricao'),
			'media' => $this->input->post('media'),
			'id_certificacao' => $this->input->post('id_certificacao'),
		);
		$body = array();

		if(empty($data['id'])):
			$msg = $this->certificacao_model->insert($data);
		else:
			$msg = $this->certificacao_model->update($data);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;

		$body['action'] = base_url() .'index.php/certificacao/save';
		$body['certificacao'] = (object)$data;
		$this->load->view('certificacao_form', $body);
		$this->load->view('footer');   

	}
}

