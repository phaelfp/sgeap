<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Matricula extends CI_Controller {

	public function index($msg = null)
	{
		$head = array();
		$head['title'] = 'Matrícula';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('anoletivo_model');
		
		$body = array();
		$body['anoletivo'] = $this->anoletivo_model->getAll();
		$body['action'] = base_url() .'index.php/Matricula/save';
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

