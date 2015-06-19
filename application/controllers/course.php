<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller {

	public function index()
	{
		$this->load->view('header');
		$body = array();
		$body['title'] = 'Disciplina';
		$body['body'] = "<p><a href=\"". base_url() ."index.php/Course/tuples\">Listar disciplinas</a></p>";
		$body['body'] .= "<p><a href=\"". base_url() ."index.php/Course/edit\">Cadastrar disciplina</a></p>";
		$this->load->view('body', $body);
		$this->load->view('footer', array('link',''));
	}

	public function tuples()
	{
		$this->load->model('course_model');
		$body = array();
		$body['title'] = 'Disciplinas';
		$body['courses'] = $this->course_model->getAll();
		$this->load->view('header');
		$this->load->view('course_list', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}

	public function edit($id = null)
	{
		$this->load->model('course_model');
		if (empty($id)):
			$id=0 ;
		endif;
	    $item = $this->course_model->getId($id);
		$body = array();
		$body['title'] = 'Cadastro de disciplina';
		$body['action'] = base_url() .'index.php/Course/save';
		$body['fields'] = array();
		$body['fields'][] = array('name'=>'id', 'type'=>'hidden', 'value'=>$item->id);
		$body['fields'][] = array('name'=>'description', 'type'=>'entry', 'label'=>'Descrição', 'value'=>$item->description);
		$this->load->view('header');
		$this->load->view('body_form', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );   
	}

	public function save()
	{
		$this->load->model('course_model');
		$body = array();
		$body['title'] = 'Disciplina';
		$data = array(
			'id' => $this->input->post('id'),
			'description' => $this->input->post('description'),
		);
		if(empty($data['id'])):
			$body['body'] = $this->course_model->insert($data);
		else:
			$body['body'] = $this->course_model->update($data);
		endif;
		$this->load->view('header');
		$this->load->view('body', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}

	public function students($id)
	{
		$this->load->model('course_model');
	    $item = $this->course_model->getId($id);
		$body = array();
		$body['title'] = 'Estudantes da disciplina ' . $item->description;
		$body['students'] = $this->course_model->getStudents($id);
		$body['course'] = $item;
		$this->load->view('header');
		$this->load->view('course_student_list', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}

	public function remove($id,$id_student)
	{
	    $this->load->model('course_model');
		$body = array();
		$body['title'] = 'Disciplina';
   		$body['body'] = $this->course_model->DelStudent($id,$id_student);
		$this->load->view('header');
		$this->load->view('body', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}

	public function add($id)
	{
	    $this->load->model('course_model');
		$item = $this->course_model->getId($id);
		$body = array();
		$body['title'] = 'Adicionar estudante na disciplina ' . $item->description;
		$body['action'] = base_url() .'index.php/Course/savestudent';
		$students = $this->course_model->getNotStudents($id);
		$items = array();
		foreach($students as $student):
			$items[] = array(
					'value' => $student->id,
					'label' => $student->name,
			);
		endforeach;
		$body['fields'] = array();
		$body['fields'][] = array('name'=>'id_course', 'type'=>'hidden', 'value'=>$item->id);
		$body['fields'][] = array('name'=>'id_student', 'type'=>'select', 'label'=>'Estudante', 'value'=>'', 'items'=>$items);

		$this->load->view('header');
		$this->load->view('body_form', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}

	public function savestudent()
	{
		$this->load->model('course_model');
		$body = array();
		$body['title'] = 'Disciplina';
		$data = array(
			'id_course' => $this->input->post('id_course'),
			'id_student' => $this->input->post('id_student'),
		);
		$body['body'] = $this->course_model->addStudent($data);
		$this->load->view('header');
		$this->load->view('body', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}
}

/* End of file course.php */
/* Location: ./application/controllers/course.php */

