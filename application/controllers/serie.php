<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Serie extends CI_Controller {

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
			header('location:../forbidden');exit;
		}
		$head = array();
		$head['title'] = 'Serie';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('serie_model');
		$body = array();
		$body['list'] = $this->serie_model->getAll();
		$this->load->view('serie_list', $body);
		$this->load->view('footer');
	}

	public function edit($id = null)
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		$head = array();
		$head['title'] = 'Serie';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('serie_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->serie_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/serie/save';
		$body['serie'] = $item;
		$body['series'] = $this->serie_model->getAll();
		$this->load->view('serie_form', $body);
		$this->load->view('footer');   
	}

	public function save()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		$this->load->model('serie_model');

		$head = array();
		$head['title'] = 'Serie';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));

		$data = array(
			'id' => $this->input->post('id'),
			'descricao' => $this->input->post('descricao'),
		);
		$body = array();

		if(empty($data['id'])):
			$msg = $this->serie_model->insert($data);
		else:
			$msg = $this->serie_model->update($data);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;

		$body['action'] = base_url() .'index.php/serie/save';
		$body['serie'] = (object)$data;
		$body['series'] = $this->serie_model->getAll();
		$this->load->view('serie_form', $body);
		$this->load->view('footer');   

	}

	public function getSerie()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		$this->load->model('turma_model');
		$id_anoletivo = $this->input->post('id_anoletivo');
		$id_curso = $this->input->post('id_curso');
		$array = $this->turma_model->getSerieJSON($id_anoletivo,$id_curso);
		echo json_encode($array);
		exit();
	}

}

