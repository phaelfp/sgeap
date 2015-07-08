<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Matricula extends CI_Controller {

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
	

	public function index($msg = null)
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$head = array();
		$head['title'] = 'Matrícula';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('anoletivo_model');
		
		$body = array();
		$body['anoletivo'] = $this->anoletivo_model->getAll();
		$body['action'] = base_url() .'index.php/matricula/save';
		if (!empty($msg)):
			if (substr($msg,0,4) === 'Erro'):
				$body['error'] = $msg;
			else:
				$body['success'] = $msg;
			endif;
		endif;
		$this->load->view('matricula_form', $body);
		$this->load->view('footer');
	}

	public function save()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('aluno_model');
		$this->load->model('matricula_model');

		$data_aluno = array(
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
			$id_aluno = $this->aluno_model->insert_getid($data_aluno);
		else:
			$id_aluno = $data_aluno['id'];
			$this->aluno_model->update($data_aluno);
		endif;

		$data = array(
			'id' => '',
			'id_aluno' => $id_aluno,
			'id_turma' => $this->input->post('id_turma'),
		);

		$msg = $this->matricula_model->insert($data);

		$this->index($msg);
	}
}

