<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance extends CI_Controller {

	public function index()
	{
		$this->load->model('course_model');

		$body = array();
		$body['title'] = 'Disciplinas';
		$body['courses'] = $this->course_model->getAll();
		$this->load->view('header');
		$this->load->view('attendance_course_list', $body);
		$this->load->view('footer', array('link'=>''));
	}

	public function form($id)
	{
		$this->load->model('course_model');
		$this->load->model('attendance_model');
        $students = $this->course_model->getStudents($id);
		$attendances = $this->attendance_model->getData($id);
		$items = array();
		foreach($students as $student):
			$items[] = array(
				'label'=>$student->name,
				'value'=>$student->id_class,
			);
		endforeach;
		$body = array();
		$body['title'] = 'Chamada';
	    $body['action'] = base_url() .'index.php/Attendance/save';
		$body['fields'] = array();
		$body['fields'][] = array('name'=>'id_course', 'type'=>'hidden', 'value'=> $id);
		$body['fields'][] = array('name'=>'is_new', 'type'=>'hidden', 'value'=> (count($attendances)>0)?0:1);
		$body['fields'][] = array('name'=>'is_attendance[]', 'type'=>'check', 'label'=>'Alunos', 'value'=> $attendances, 'items' => $items);

		$this->load->view('header');
		$this->load->view('body_form', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}

	public function csv($id)
	{
		$this->load->model('attendance_model');
        $csv = $this->attendance_model->getCSV($id);
		$fp = fopen('attendance.csv', 'w');

		foreach ($csv as $row) {
		    fputcsv($fp, $row);
		}
		fclose($fp);
		$body['body'] = 'Arquivo Criado';
		$this->load->view('header');
		$this->load->view('body', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}

	public function csvall()
	{
		$this->load->model('attendance_model');
        $csv = $this->attendance_model->getCSV();
		$fp = fopen('attendance.csv', 'w');

		foreach ($csv as $row) {
		    fputcsv($fp, $row);
		}
		fclose($fp);
		$body['body'] = 'Arquivo Criado';
		$this->load->view('header');
		$this->load->view('body', $body);
		$this->load->view('footer', array('link','') );
	}

	public function save()
	{
		$body = array();
		$this->load->model('course_model');
		$this->load->model('attendance_model');
        $students = $this->course_model->getStudents($this->input->post('id_course'));
		$is_attendance = $this->input->post('is_attendance');
		$body['title'] = 'Chamada';
		$body['body'] = '';
		foreach($students as $student):
			$data = array(
				'dt_attendance'=>date("Y-m-d H:i:s"),
				'id_class'=>$student->id_class,
				'is_attendance' =>(in_array($student->id_class, $is_attendance))?1:0,
			);
			$text = (in_array($student->id_class, $is_attendance))?'Presente':'Ausente';
            $method = ($this->input->post('is_new'))?'insert':'update';
			if ($this->attendance_model->$method($data)):
				$body['body'] .= "<p>{$student->name} - {$text}</p>";
			else:
				$body['body'] .= "<p>{$student->name} - ERRO</p>";
			endif;   
		endforeach;
		$this->load->view('header');
		$this->load->view('body', $body);
		$this->load->view('footer', array('link'=>$this->uri->segment(1) ) );
	}
}

