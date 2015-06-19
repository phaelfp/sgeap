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

}

