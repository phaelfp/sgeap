<?php

class nota_model extends CI_Model {

	public $id;
	public $id_aluno;
	public $id_turma;
	public $id_disciplina;
	public $id_certificacao;
	public $nota;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'Nota';
	}

    public function getAll()
    {
		$dados = array();
		$sql = "SELECT * FROM {$this->table_name}";
		$query = $this->db->query($sql);
		$result = $query->result('nota_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field;
			}
		}
		return $dados;
    }

    public function getId($id)
    {
		$sql = "SELECT * FROM {$this->table_name} where id = {$id}";
		$query = $this->db->query($sql);
		$result = $query->result('nota_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados = $field;
			}
			return $dados;
		}
		return NULL;
	}

	public function store($data, $perfil = array())
	{
		$this->db->insert($this->table_name, $data);
		$this->id = $this->db->insert_id();
		return ($this->db->affected_rows())?"Registro inserido com sucesso!":"Erro: ao inserir o registro.";
	}

	public function insert($data, $perfil = array())
	{
		array_shift($data);
		$this->db->insert($this->table_name, $data);
		$this->id = $this->db->insert_id();
		return ($this->db->affected_rows())?"Registro inserido com sucesso!":"Erro: ao inserir o registro.";
	}

	public function insert_getid($data)
	{
		array_shift($data);
        $this->db->insert($this->table_name, $data);
		return ($this->db->affected_rows())?$this->db->insert_id():-1;
	}

	public function update($data, $perfil = array())
	{
		$where = array();
		$this->id = $where["id" ] = array_shift($data);
        $this->db->update($this->table_name, $data, $where);
		return ($this->db->affected_rows())?"Registro atualizado com sucesso!":"Erro: ao atualizar o registro.";
	}

	public function delete($id)
	{
		$this->id = $where["id" ] = $id;
        $this->db->delete($this->table_name, $where);
		return ($this->db->affected_rows())?"Registro excluido com sucesso!":"Erro: ao excluir o registro.";
	}

	public function getAlunoJSON($id_turma)
	{
		$this->db->select('Aluno.*');
		$this->db->from('Matricula');
		$this->db->join('Aluno','Aluno.id = Matricula.id_aluno');
		$this->db->where('Matricula.id_turma',$id_turma);
		$query = $this->db->get();
		return $result = $query->result_array();
	}

}
