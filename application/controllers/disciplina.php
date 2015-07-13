<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disciplina extends CI_Controller {

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
		$head['title'] = 'Disciplina';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('disciplina_model');
		$page = $this->uri->segment(3);
		if (empty($page))
			$page=1;
		$size = $this->disciplina_model->getCount();
		$pages = (int) $size/20;
		if ($size%20) $pages++;
		$body = array();
		$body['list'] = $this->disciplina_model->getAll($page);
		$body['pages'] = $pages;
		$body['page'] = $page;
		$body['edit'] = $this->perfil_model->verifica_acesso($this->registro,'Disciplina::edit');
		$this->load->view('disciplina_list', $body);
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
		$head['title'] = 'Disciplina';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('disciplina_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->disciplina_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/disciplina/save';
		$body['disciplina'] = $item;
		$this->load->view('disciplina_form', $body);
		$this->load->view('footer');   
	}

	public function save()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('disciplina_model');

		$head = array();
		$head['title'] = 'Disciplina';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));

		$data = array(
			'id' => $this->input->post('id'),
			'descricao' => $this->input->post('descricao'),
			'impressao' => $this->input->post('impressao'),
			'ementa' => $this->input->post('ementa'),
		);
		$body = array();

		if(empty($data['id'])):
			$msg = $this->disciplina_model->insert($data);
		else:
			$msg = $this->disciplina_model->update($data);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;

		$body['action'] = base_url() .'index.php/disciplina/save';
		$body['disciplina'] = (object)$data;
		$this->load->view('disciplina_form', $body);
		$this->load->view('footer');   

	}
}

