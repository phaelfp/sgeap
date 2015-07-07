<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Horario extends CI_Controller {

	function __construct()
	{
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
		$head['title'] = 'Horário';
		$this->load->view('header', $head);
		$this->load->view('nav_menu', array('menu'=>$this->menu));
		
		$this->load->model('anoletivo_model');
		
		$body = array();
		$body['anoletivo'] = $this->anoletivo_model->getAll();
		$body['action'] = base_url() .'index.php/horario/save';
		if (!empty($msg)):
			if (substr($msg,0,4) === 'Erro'):
				$body['error'] = $msg;
			else:
				$body['success'] = $msg;
			endif;
		endif;
		$this->load->view('horario_index', $body);
		$this->load->view('footer');
	}

	public function save()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		//$this->load->model('diahorario_model');

		$body = array();

		$this->index();
	}

	public function salvarHorario()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		$this->load->model('horario_model');
		$data = array(
			'id_turma' => $this->input->post('id_turma'),
			'id_disciplina' => $this->input->post('id_disciplina'),
			'id_dia_semana' => $this->input->post('id_dia_semana'),
			'id_horario' => $this->input->post('id_horario'),
			'n_tempos' => $this->input->post('n_tempos'),
		);
		$resposta = $this->horario_model->insert($data);
		$array = array('resposta'=>$resposta);
		echo json_encode((object) $array);
		exit;
	}

	public function deletarHorario($id)
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
		$this->load->model('horario_model');
		$horario = $this->horario_model->getId($id);
		$resposta = $horario->delete();
		echo $resposta;
		exit;
	}

	public function getHorario()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
   		$this->load->model('horario_model');
		$id_turma = $this->input->post('id_turma');
		$id_disciplina = $this->input->post('id_disciplina');
		$array = $this->horario_model->getHorarioJSON($id_turma,$id_disciplina);
		echo json_encode($array);
		exit();
   	}

	public function getDisciplina()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:../forbidden');exit;
		}
   		$this->load->model('oferecimento_model');
		$id_turma = $this->input->post('id_turma');
		$array = $this->oferecimento_model->getDisciplinaJSON($id_turma);
		echo json_encode($array);
		exit();
   	}
}

