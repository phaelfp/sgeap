<?php
		
class attendance_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'attendance';
    }

	public function insert($data)
	{
        $this->db->insert($this->table_name, $data);
		return (bool)($this->db->affected_rows());
	}

	public function update($data)
	{
		$update = array('is_attendance' => $data['is_attendance'], 'dt_attendance' => $data['dt_attendance']);
		$where = "id_class = {$data['id_class']} AND date(dt_attendance) = '" . substr($data['dt_attendance'],0,10) . "'";
		$this->db->query($this->db->update_string($this->table_name, $update, $where));
		return (bool)($this->db->affected_rows());
	}

    public function getData($course)
    {
        $sql = "SELECT a.id_class, a.is_attendance ";
        $sql .= "FROM attendance as a INNER JOIN class as c ";
        $sql .= "ON c.id = a.id_class ";
        $sql .= "WHERE date(a.dt_attendance) = '". date("Y-m-d") . "' ";
        $sql .= "AND c.id_course = {$course}";

        $return = $this->db->query($sql);
        $data = array();
        if($return->num_rows()>0):
            foreach($return->result() as $row):
                $data[$row->id_class] = $row->is_attendance;
            endforeach;
        endif;
        return $data;
	}

	public function getCSV($course = null)
	{
		$sql = <<<SQL
SELECT co.description as course, s.name, a.dt_attendance, a.is_attendance
FROM attendance as a INNER JOIN class as c
ON a.id_class = c.id
INNER JOIN student as s
ON c.id_student = s.id
INNER JOIN course as co
ON c.id_course = co.id

SQL;
		if ($course != null)
			$sql .= "WHERE c.id_course = {$course}\n";

		$sql .= "ORDER BY 1,3,2";

        $return = $this->db->query($sql);
		if($return->num_rows()>0):
			$data = $return->result_array();
		else:
			$data = array();
        endif;
        return $data;
	}

}
