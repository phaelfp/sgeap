<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aluno extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->registro 	= $this->session->userdata('registro');
		$this->usuario 	 	= strtoupper($this->session->userdata('usuario'));
		$this->menu 	 	= str_replace('|','"',$this->session->userdata('menu'));
		if(empty($this->registro) || empty($this->usuario)){
			header('location:../login/logoff');exit;
		}
	}
	
	public function index()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		$head = array();
		$head['title'] = 'Aluno';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('aluno_model');
		
		$body = array();
		$body['list'] = $this->aluno_model->getAll();
		$this->load->view('aluno_list', $body);
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
		$head['title'] = 'Aluno';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('aluno_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->aluno_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/aluno/save';
		$body['aluno'] = $item;
		$this->load->view('aluno_form', $body);
		$this->load->view('footer');   
	}

	public function delete()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		$this->load->model('aluno_model');
		$id = $this->input->post('id');
		$msg = $this->aluno_model->delete($id);

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
			header('location:../forbidden');exit;
		}
		$this->load->model('aluno_model');

		$head = array();
		$head['title'] = 'Aluno';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));

		$data = array(
			'id' => $this->input->post('id'),
			'nm_aluno' => $this->input->post('nm_aluno'),
			'cpf' => $this->input->post('cpf'),
			'banco' => $this->input->post('banco'),
			'agencia' => $this->input->post('agencia'),
			'c_corrente' => $this->input->post('c_corrente'),
			'is_ativo' => $this->input->post('is_ativo'),
			'is_trancado' => $this->input->post('is_trancado'),
		);
		$body = array();

		if(empty($data['id'])):
			$msg = $this->aluno_model->insert($data);
		else:
			$msg = $this->aluno_model->update($data);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;

		$body['action'] = base_url() .'index.php/aluno/save';
		$body['aluno'] = (object)$data;
		$this->load->view('aluno_form', $body);
		$this->load->view('footer');   

	}
}

