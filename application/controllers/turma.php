<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Turma extends CI_Controller {

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
		$head['title'] = 'Turma';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('turma_model');
		
		$body = array();
		$body['list'] = $this->turma_model->getAll();
		$this->load->view('turma_list', $body);
		$this->load->view('footer');
	}

	public function add($id)
	{
		$head = array();
		$head['title'] = 'Turma';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('turma_model');
		$this->load->model('oferecimento_model');
		$this->load->model('disciplina_model');
	    $item = $this->turma_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/turma/update';
		$body['turma'] = $item;
		$body['oferecimento'] = $this->oferecimento_model->get_enabled($id);
		$body['disciplinas'] = $this->disciplina_model->getAll();
		$this->load->view('turma_form_add', $body);
		$this->load->view('footer');   
	}
	
	public function update()
	{
		$this->load->model('turma_model');
		$this->load->model('oferecimento_model');

		$id = $this->input->post('id_turma');
		$id_disciplina = $this->input->post('id_disciplina');

		$this->oferecimento_model->set_disabled($id);

		foreach($id_disciplina as $key => $item):
			$data = array('id_turma'=> $id, 'id_disciplina'=>$item);
			$this->oferecimento_model->save($data);
		endforeach;

		$this->index();
	}

	public function edit($id = null)
	{
		$head = array();
		$head['title'] = 'Turma';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');
		
		$this->load->model('turma_model');
		$this->load->model('serie_model');
		$this->load->model('curso_model');
		$this->load->model('anoletivo_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    	$item = $this->turma_model->getId($id);
		$body = array();
		$body['action'] = base_url() .'index.php/turma/save';
		$body['turma'] = $item;
		$body['anoletivo'] = $this->anoletivo_model->getCombo();
		$body['serie'] = $this->serie_model->getCombo();
		$body['curso'] = $this->curso_model->getCombo();
		$this->load->view('turma_form', $body);
		$this->load->view('footer');   
	}

	public function save()
	{
		$this->load->model('turma_model');
		$this->load->model('serie_model');
		$this->load->model('curso_model');
		$this->load->model('anoletivo_model');

		$head = array();
		$head['title'] = 'Turma';
		$this->load->view('header', $head);
		$this->load->view('nav_menu');

		$data = array(
			'id' => $this->input->post('id'),
			'id_curso' => $this->input->post('id_curso'),
			'id_serie' => $this->input->post('id_serie'),
			'id_anoletivo' => $this->input->post('id_anoletivo'),
			'descricao' => $this->input->post('descricao'),
		);
		$body = array();

		if(empty($data['id'])):
			$msg = $this->turma_model->insert($data);
		else:
			$msg = $this->turma_model->update($data);
		endif;

		if (substr($msg,0,4) === 'Erro'):
			$body['error'] = $msg;
		else:
			$body['success'] = $msg;
		endif;

		$body['action'] = base_url() .'index.php/turma/save';
		$body['turma'] = (object)$data;
		$body['anoletivo'] = $this->anoletivo_model->getCombo();
		$body['serie'] = $this->serie_model->getCombo();
		$body['curso'] = $this->curso_model->getCombo();
		$this->load->view('turma_form', $body);
		$this->load->view('footer');   

	}

	public function getTurma()
	{
   		$this->load->model('turma_model');
		$id_anoletivo = $this->input->post('id_anoletivo');
		$id_curso = $this->input->post('id_curso');
		$id_serie = $this->input->post('id_serie');
		$array = $this->turma_model->getTurmaJSON($id_anoletivo,$id_curso,$id_serie);
		echo json_encode($array);
		exit();
   	}
}

