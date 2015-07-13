<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfil extends CI_Controller {

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
		$head['title'] = 'Perfil';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('perfil_model');
		$page = $this->uri->segment(3);
		if (empty($page))
			$page=1;
		$size = $this->perfil_model->getCount();
		$pages = ceil($size/20);
		$body = array();
		$body['list'] = $this->perfil_model->getAll($page);
		$body['pages'] = $pages;
		$body['page'] = $page;
		$body['edit'] = $this->perfil_model->verifica_acesso($this->registro,'Perfil::edit');
		$this->load->view('perfil_list', $body);
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
		$head['title'] = 'Perfil';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('perfil_model');
		$this->load->model('tela_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->perfil_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/perfil/save';
		$body['perfil'] = $item;
		$body['acessa'] = empty($item)?array():$item->getAcessa();
		$body['tela'] = $this->tela_model->getAll();
		$this->load->view('perfil_form', $body);
		$this->load->view('footer');   
	}

	public function delete()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('perfil_model');
		$id = $this->input->post('id');
		$msg = $this->perfil_model->delete($id);

		if (substr($msg,0,4) === 'Erro'){
			echo <<<TXT
   <div role="alert" class="alert alert-danger alert-dismissible fade in">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<strong>{$msg}</strong>
	</div>
TXT;
		} else {
			echo <<<TXT
   <div role="alert" class="alert alert-success alert-dismissible fade in">
		<button aria-label="Close" data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<strong>Sucesso: </strong>{$msg}
	</div>
TXT;
		}

		exit();
	}

	public function save()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('perfil_model');

		$head = array();
		$head['title'] = 'Perfil';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));

		$data = array(
			'id' => $this->input->post('id'),
			'descricao' => $this->input->post('descricao'),
		);
		$tela = $this->input->post('tela');
		$body = array();

		if(empty($data['id'])):
			$msg = $this->perfil_model->insert($data, $tela);
			$data['id'] = $this->perfil_model->id;
		else:
			$msg = $this->perfil_model->update($data, $tela);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;
		
		$body['action'] = base_url() .'index.php/perfil/save';
		$body['perfil'] = (object)$data;
		$this->load->view('perfil_form', $body);
		$this->load->view('footer');   
	}
}

