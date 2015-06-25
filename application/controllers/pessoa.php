<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pessoa extends CI_Controller {

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
		$head['title'] = 'Pessoa';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('pessoa_model');
		
		$body = array();
		$body['list'] = $this->pessoa_model->getAll();
		$this->load->view('pessoa_list', $body);
		$this->load->view('footer');
	}

	public function edit($id = null)
	{
		$head = array();
		$head['title'] = 'Pessoa';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('pessoa_model');
		$this->load->model('perfil_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->pessoa_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/pessoa/save';
		$body['pessoa'] = $item;
		$body['possui'] = $item->getPossui();
		$body['perfil'] = $this->perfil_model->getAll();
		$this->load->view('pessoa_form', $body);
		$this->load->view('footer');   
	}

	public function delete()
	{
		$this->load->model('pessoa_model');
		$id = $this->input->post('id');
		$msg = $this->pessoa_model->delete($id);

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
		$this->load->model('pessoa_model');

		$head = array();
		$head['title'] = 'Pessoa';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');

		$data = array(
			'id' => $this->input->post('id'),
			'nome' => $this->input->post('nome'),
			'login' => $this->input->post('login'),
		);
		$password = $this->input->post('password');
		$perfil = $this->input->post('perfil');
		if (!empty($password))
			$data['password'] = sha1($password);
		$body = array();

		if(empty($data['id'])):
			$msg = $this->pessoa_model->insert($data,$perfil);
		else:
			$msg = $this->pessoa_model->update($data,$perfil);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;

		$body['action'] = base_url() .'index.php/pessoa/save';
		$body['pessoa'] = $this->pessoa_model;
		$this->load->view('pessoa_form', $body);
		$this->load->view('footer');   
	}
}

