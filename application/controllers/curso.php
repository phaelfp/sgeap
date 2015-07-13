<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Curso extends CI_Controller {

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
		$head['title'] = 'Curso';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('curso_model');
		$page = $this->uri->segment(3);
		if (empty($page))
			$page=1;
		$size = $this->curso_model->getCount();
		$pages = (int) $size/20;
		if ($size%20) $pages++;
		$body = array();
		$body['list'] = $this->curso_model->getAll($page);
		$body['pages'] = $pages;
		$body['page'] = $page;
		$body['edit'] = $this->perfil_model->verifica_acesso($this->registro,'Curso::edit');
		$this->load->view('curso_list', $body);
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
		$head['title'] = 'Curso';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('curso_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->curso_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/curso/save';
		$body['curso'] = $item;
		$this->load->view('curso_form', $body);
		$this->load->view('footer');   
	}

	public function save()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('curso_model');

		$head = array();
		$head['title'] = 'Curso';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));

		$data = array(
			'id' => $this->input->post('id'),
			'descricao' => $this->input->post('descricao'),
		);
		$body = array();

		if(empty($data['id'])):
			$msg = $this->curso_model->insert($data);
		else:
			$msg = $this->curso_model->update($data);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;

		$body['action'] = base_url() .'index.php/curso/save';
		$body['curso'] = (object)$data;
		$this->load->view('curso_form', $body);
		$this->load->view('footer');   

	}

	public function getCurso()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('turma_model');
		$id_anoletivo = $this->input->post('id_anoletivo');
		$array = $this->turma_model->getCursoJSON($id_anoletivo);
		echo json_encode($array);
		exit();
	}
}

