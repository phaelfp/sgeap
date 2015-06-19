<?php
		
class oferecimento_model extends CI_Model {

	public $id;
	public $id_turma;
	public $id_disciplina;
	public $is_ativa;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'Oferecimento';
	}

    public function getAll()
    {
		$dados = array();
		$sql = "SELECT * FROM {$this->table_name}";
		$query = $this->db->query($sql);
		$result = $query->result('oferecimento_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field;
			}			
		}
		return $dados;
    }
	
	public function get_enabled($id_turma)
    {
		$dados = array();
		$sql = "SELECT o.id_disciplina";
	    $sql .= " FROM {$this->table_name} o ";
		$sql .= "WHERE o.is_ativa = 1 ";
		$sql .= "AND o.id_turma = {$id_turma} ";
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field->id_disciplina;
			}			
		}
		return $dados;
	}

	public function set_disabled($id_turma)
	{
		$sql = "UPDATE {$this->table_name} SET is_ativa = 0 WHERE id_turma = {$id_turma}";
		$query = $this->db->query($sql);
	}

    public function getId($id)
    {
		$sql = "SELECT * FROM {$this->table_name} where id = {$id}";
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados = $field;
			}
			return $dados;
		}
		return NULL;
	}

    private function get_update($id_turma,$id_disciplina)
    {
		$field = null;
		$sql = "SELECT * FROM {$this->table_name}";
		$sql .= " WHERE id_turma = {$id_turma} AND id_disciplina = {$id_disciplina}";
		$query = $this->db->query($sql);
		$result = $query->result('oferecimento_model');
		if ($query->num_rows() > 0)
		{
			$field = $query->row();
		}
		return $field;
    }

	public function save($data)
	{
		$obj = $this->get_update($data['id_turma'],$data['id_disciplina']);
		if (empty($obj)):
			$this->id_disciplina = $data['id_disciplina'];
			$this->id_turma = $data['id_turma'];
			$this->insert();
		else:
			$obj->update();
		endif;
	}
	
	public function insert()
	{
		$data = array(
					'id_disciplina' => $this->id_disciplina,
					'id_turma' => $this->id_turma,
					'is_ativa' => 1,
				);
        $this->db->insert($this->table_name, $data);
		return ($this->db->affected_rows())?"Registro inserido com sucesso!":"Erro: ao inserir o registro.";
	}

	public function update()
	{
		$where = array();
		$where["id"] = $this->id;
		$data = array(
					'is_ativa' => 1,
				);
        $this->db->update($this->table_name, $data, $where);
		return ($this->db->affected_rows())?"Registro atualizado com sucesso!":"Erro: ao atualizar o registro.";
	}

	public function getDisciplinaJSON($id_turma)
	{
		$disciplinas = array();
		$this->db->distinct();
		$this->db->select('Disciplina.*');
		$this->db->from('Oferecimento');
		$this->db->join('Disciplina','Oferecimento.id_disciplina = Disciplina.id');
        $this->db->where('Oferecimento.id_turma',$id_turma);
        $this->db->where('Oferecimento.is_ativa',1);
		$query = $this->db->get();
		$result = $query->result_array();
		foreach($result as $key => $row):
			$disciplinas[] = $row;
		endforeach;
		return $disciplinas;
	}

}
