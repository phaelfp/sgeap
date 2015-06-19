<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {

	public function index()
	{
		$this->load->view('header');
		$body = array();
		$body['title'] = 'Estudante';
		$body['body'] = "<p><a href=\"". base_url() ."index.php/Student/tuples\">Listar estudantes</a></p>";
		$body['body'] .= "<p><a href=\"". base_url() ."index.php/Student/edit\">Cadastrar estudante</a></p>";
		$this->load->view('body', $body);
		$this->load->view('footer', array('link',''));
	}

	public function tuples()
	{
		$this->load->model('student_model');
		$body = array();
		$body['title'] = 'Estudantes';
		$body['students'] = $this->student_model->getAll();
		$this->load->view('header');
		$this->load->view('student_list', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}

	public function edit($id = null)
	{
		$this->load->model('student_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    $item = $this->student_model->getId($id);
		$body = array();
		$body['title'] = 'Cadastro de estudante';
		$body['action'] = base_url() .'index.php/Student/save';
		$body['fields'] = array();
		$body['fields'][] = array('name'=>'id', 'type'=>'hidden', 'value'=>$item->id);
		$body['fields'][] = array('name'=>'name', 'type'=>'entry', 'label'=>'Nome', 'value'=>$item->name);
		$this->load->view('header');
		$this->load->view('body_form', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );   
	}

	public function save()
	{
		$this->load->model('student_model');
		$body = array();
		$body['title'] = 'Estudante';
		$data = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
		);
		if(empty($data['id'])):
			$body['body'] = $this->student_model->insert($data);
		else:
			$body['body'] = $this->student_model->update($data);
		endif;
		$this->load->view('header');
		$this->load->view('body', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}
}

/* End of file student.php */
/* Location: ./application/controllers/student.php */

