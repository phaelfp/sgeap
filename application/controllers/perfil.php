<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('display_errors',1);
error_reporting(E_ALL);

class Perfil extends CI_Controller {

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
		$head['title'] = 'Perfil';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('perfil_model');
		
		$body = array();
		$body['list'] = $this->perfil_model->getAll();
		$this->load->view('perfil_list', $body);
		$this->load->view('footer');
	}

	public function edit($id = null)
	{
		$head = array();
		$head['title'] = 'Perfil';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('perfil_model');
		$this->load->model('tela_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->perfil_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/perfil/save';
		$body['perfil'] = $item;
		$body['acessa'] = $item->getAcessa();
		$body['tela'] = $this->tela_model->getAll();
		$this->load->view('perfil_form', $body);
		$this->load->view('footer');   
	}

	public function delete()
	{
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

		$head = array();
		$head['title'] = 'Perfil';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');

		$data = array(
			'id' => $this->input->post('id'),
			'descricao' => $this->input->post('descricao'),
		);
		$tela = $this->input->post('tela');
		$body = array();

		if(empty($data['id'])):
			$msg = $this->perfil_model->insert($data, $tela);
		else:
			$msg = $this->perfil_model->update($data, $tela);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;
		
		$body['action'] = base_url() .'index.php/perfil/save';
		$body['perfil'] = $this->perfil_model;
		$this->load->view('perfil_form', $body);
		$this->load->view('footer');   
	}
}

