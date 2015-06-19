<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frequencia extends CI_Controller {

	public function index($msg = null)
	{
		$head = array();
		$head['title'] = 'Frequência';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('anoletivo_model');
		
		$body = array();
		$body['anoletivo'] = $this->anoletivo_model->getAll();
		$body['action'] = base_url() .'index.php/Frequencia/save';
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
		$this->load->model('frequencia_model');

		$id_turma = $this->input->post('id_turma');
		$id_disciplina = $this->input->post('id_disciplina');
		$id_dia_semana = date('w') + 1;
		$dt_aula = date('Y-m-d H:m:s');
		$id_aluno = $this->input->post('id_aluno');

		foreach($id_aluno as $i => $id):
			$data = array(
				'id_turma' => $id_turma,
				'id_disciplina' => $id_disciplina,
				'id_dia_semana' => $id_dia_semana,
				'dt_aula' => $dt_aula,
				'id_aluno' => $id,
				'is_presente' => '1',
			);
			$this->frequencia_model->insert($data);
		endforeach;

		$this->index();
	}

	public function getAluno()
	{
		$this->load->model('frequencia_model');
		$id_turma = $this->input->post('id_turma');
		$alunos = $this->frequencia_model->getAlunoJSON($id_turma);
		echo json_encode($alunos);
		exit();
	}
}
