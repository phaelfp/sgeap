<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Curso extends CI_Controller {

	public function index()
	{
		$head = array();
		$head['title'] = 'Curso';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('curso_model');
		$body = array();
		$body['list'] = $this->curso_model->getAll();
		$this->load->view('curso_list', $body);
		$this->load->view('footer');
	}

	public function edit($id = null)
	{
		$head = array();
		$head['title'] = 'Curso';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('curso_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->curso_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/curso/save';
		$body['curso'] = $item;
		$this->load->view('curso_form', $body);
		$this->load->view('footer');   
	}

	public function save()
	{
		$this->load->model('curso_model');

		$head = array();
		$head['title'] = 'Curso';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');

		$data = array(
			'id' => $this->input->post('id'),
			'descricao' => $this->input->post('descricao'),
		);
		$body = array();

		if(empty($data['id'])):
			$msg = $this->curso_model->insert($data);
		else:
			$msg = $this->curso_model->update($data);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;

		$body['action'] = base_url() .'index.php/curso/save';
		$body['curso'] = (object)$data;
		$this->load->view('curso_form', $body);
		$this->load->view('footer');   

	}

	public function getCurso()
	{
		$this->load->model('turma_model');
		$id_anoletivo = $this->input->post('id_anoletivo');
		$array = $this->turma_model->getCursoJSON($id_anoletivo);
		echo json_encode($array);
		exit();
	}
}

