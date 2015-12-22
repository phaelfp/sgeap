<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nota extends CI_Controller {

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
		$head['title'] = 'Nota';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));

		$this->load->model('anoletivo_model');
		$this->load->model('certificacao_model');

		$body = array();
		$body['anoletivo'] = $this->anoletivo_model->getAll();
		$body['certificacao'] = $this->certificacao_model->getAll();
		$body['action'] = base_url() .'index.php/nota/save';
		$body['dt_aula'] = date ("Y-m-d H:i:s");
		if (!empty($msg)):
			if (substr($msg,0,4) === 'Erro'):
				$body['error'] = $msg;
			else:
				$body['success'] = $msg;
			endif;
		endif;
		$this->load->view('nota_index', $body);
		$this->load->view('footer');
	}

	public function save()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('nota_model');
		$id_turma = $this->input->post('id_turma');
		$id_disciplina = $this->input->post('id_disciplina');
		$id_certificacao = $this->input->post('id_certificacao');
		$notas = $this->input->post('nota');

		foreach($notas as $id_aluno => $nota):
			$data = array(
				'id_turma' => $id_turma,
				'id_disciplina' => $id_disciplina,
				'id_certificacao' => $id_certificacao,
				'id_aluno' => $id_aluno,
				'nota' => $nota,
			);
			if (!empty($nota))
   			$this->nota_model->store($data);
		endforeach;

		$this->index();
	}

	public function getAluno()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('nota_model');
		$id_turma = $this->input->post('id_turma');
		$alunos = $this->nota_model->getAlunoJSON($id_turma);
		echo json_encode($alunos);
		exit();
	}
}
