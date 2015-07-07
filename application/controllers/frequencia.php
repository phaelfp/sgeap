<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frequencia extends CI_Controller {

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
			header('location:../forbidden');exit;
		}
		$head = array();
		$head['title'] = 'Frequência';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('anoletivo_model');
		
		$body = array();
		$body['anoletivo'] = $this->anoletivo_model->getAll();
		$body['action'] = base_url() .'index.php/frequencia/save';
		$body['dt_aula'] = date ("Y-m-d H:i:s");
		if (!empty($msg)):
			if (substr($msg,0,4) === 'Erro'):
				$body['error'] = $msg;
			else:
				$body['success'] = $msg;
			endif;
		endif;
		$this->load->view('frequencia_index', $body);
		$this->load->view('footer');
	}

	public function save()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		$this->load->model('frequencia_model');

		$id_turma = $this->input->post('id_turma');
		$id_disciplina = $this->input->post('id_disciplina');
		$dt_aula = $this->input->post('dt_aula');
		$id_dia_semana = date('w') + 1;
		$alunos = $this->frequencia_model->getAlunoJSON($id_turma);
		$id_aluno = $this->input->post('id_aluno');

		foreach($alunos as $i => $aluno):
			$data = array(
				'id_turma' => $id_turma,
				'id_disciplina' => $id_disciplina,
				'id_dia_semana' => $id_dia_semana,
				'dt_aula' => $dt_aula,
				'id_aluno' => $aluno['id'],
				'is_presente' => in_array($aluno['id'], $id_aluno)?'1':'0',
			);
   			$this->frequencia_model->store($data);
		endforeach;

		$this->index();
	}

	public function getAluno()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		$this->load->model('frequencia_model');
		$id_turma = $this->input->post('id_turma');
		$alunos = $this->frequencia_model->getAlunoJSON($id_turma);
		echo json_encode($alunos);
		exit();
	}
}

