<?php

class report_model extends CI_Model {

	public function getCourses()
	{
		$query = $this->db->get('course');
		$courses = array();
		foreach($query->result_array() as $course):
			$courses[] = $this->addInCourse($course);
		endforeach;
        return $courses;
	}

    public function addInCourse($item)
	{
		$item['students'] = $this->getStudents($item['id']);
		$item['yearmonth'] = $this->getYearMonth($item['id']);
		return $item;
	}

	public function getYearMonth($id)
	{
		$this->db->select('distinct strftime(\'%Y%m\',dt_attendance) as dt_ym');
		$this->db->from('attendance');
		$this->db->join('class', 'class.id = attendance.id_class');
		$this->db->where('class.id_course',$id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getStudents($id)
	{
		$this->db->select('student.id, student.name, class.id as id_class');
		$this->db->from('student');
		$this->db->join('class', 'class.id_student = student.id');
		$this->db->where('class.id_course',$id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAttendance($idClass,$yearmonth)
	{
		$this->db->select('is_attendance');
		$this->db->from('attendance');
		$this->db->where('id_class',$idClass);
		$this->db->where('strftime(\'%Y%m\',dt_attendance)',$yearmonth);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getAttendanceDay($yearmonth, $idcourse)
	{
		$this->db->select('distinct strftime(\'%d\',dt_attendance) as day');
		$this->db->from('attendance');
		$this->db->join('class', 'class.id = attendance.id_class');
		$this->db->where('strftime(\'%Y%m\',attendance.dt_attendance)',$yearmonth);
		$this->db->where('class.id_course',$idcourse);
		$query = $this->db->get();
		$days = array();
		foreach($query->result_array() as $day):
			$days[] = $day['day'];
		endforeach;
        return $days;
	}

	public function getNotas($id_turma, $id_certificacao)
	{
		$this->db->select('Certificacao.media');
		$this->db->from('Certificacao');
		$this->db->where('id_certificacao', $id_certificacao);
		$query = $this->db->get();
		$result = $query->result_array();
		if (isset($result[0]['media'])):
			$agrecate = $result[0]['media'];
		else:
			$agrecate = 'sum';
		endif;
		$this->db->select('Aluno.nm_aluno, Disciplina.impressao as nm_disciplina, Certificacao.descricao as nm_certificacao, '.$agrecate.'(Nota.nota) as nota');
		$this->db->from('Nota');
		$this->db->join('Aluno','Aluno.id = Nota.id_aluno');
		$this->db->join('Disciplina','Disciplina.id = Nota.id_disciplina');
		$this->db->join('Certificacao','Certificacao.id = Nota.id_certificacao');
		$this->db->where('Nota.id_turma', $id_turma);
		$this->db->where('Nota.id_certificacao', $id_certificacao);
		$this->db->group_by(array('Certificacao.descricao','Disciplina.descricao', 'Aluno.nm_aluno'));
		$query = $this->db->get();
		return $result = $query->result();
	}

}
