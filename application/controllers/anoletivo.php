<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AnoLetivo extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->registro 	= $this->session->userdata('registro');
		$this->usuario 	 	= strtoupper($this->session->userdata('usuario'));
		if(empty($this->registro) || empty($this->usuario)){
			header('location:../login/logoff');exit;
		}
		$this->load->model('perfil_model');
		$this->menu = $this->perfil_model->getMenu($this->registro);
	}
	

	public function index()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$head = array();
		$head['title'] = 'Ano Letivo';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('anoletivo_model');
		$body = array();
		$body['list'] = $this->anoletivo_model->getAll();
		$this->load->view('anoletivo_list', $body);
		$this->load->view('footer');
	}

	public function edit($id = null)
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$head = array();
		$head['title'] = 'Ano Letivo';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
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
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('anoletivo_model');

		$head = array();
		$head['title'] = 'Ano Letivo';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));

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

