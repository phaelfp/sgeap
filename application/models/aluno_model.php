<?php

class aluno_model extends CI_Model {

	public $id;
	public $nm_aluno;
	public $cpf;
	public $banco;
  public $agencia;
	public $c_corrente;
	public $is_ativo;
	public $is_trancado;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'Aluno';
	}

	public function getCount()
	{
		$sql = "SELECT COUNT(*) as size FROM {$this->table_name}";
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0 )
			return $result[0]->size;
		return 0;
	}

    public function getAll($page=0)
    {
		$dados = array();
		$sql = "SELECT * FROM {$this->table_name}";
		if ($page>0)
			$sql .= " LIMIT 20 OFFSET ". (($page-1)*20);
		$query = $this->db->query($sql);
		$result = $query->result('aluno_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field;
			}
		}
		return $dados;
    }

    public function get_ativos($key = null)
    {
		$sql = "SELECT id,nm_aluno FROM {$this->table_name} WHERE is_ativo = 0";
		if ($key !== null)
			$sql .= " AND nm_aluno like '%$key%'";
		$query = $this->db->query($sql);
		return json_encode($query->result());
    }

    public function get_matriculados($id_turma)
    {
		$sql = "SELECT * FROM {$this->table_name} WHERE id IN (SELECT id_aluno FROM Matricula WHERE id_turma = {$id_turma})";
		$query = $this->db->query($sql);
		return $query->result();
    }

	public function getCombo()
    {
		$dados = array();
		$sql = "SELECT id, nm_aluno";
	    $sql .= " FROM {$this->table_name} ";
		$sql .= "order by 2 ";
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[$field->id] = "{$field->nm_aluno}";
			}
		}
		return $dados;
	}

    public function getId($id)
    {
		$sql = "SELECT * FROM {$this->table_name} where id = {$id}";
		$query = $this->db->query($sql);
		$result = $query->result('aluno_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados = $field;
			}
			return $dados;
		}
		return NULL;
	}

	public function insert($data)
	{
		array_shift($data);
        $this->db->insert($this->table_name, $data);
		return ($this->db->affected_rows())?"Registro inserido com sucesso!":"Erro: ao inserir o registro.";
	}

	public function insert_getid($data)
	{
		array_shift($data);
        $this->db->insert($this->table_name, $data);
		return ($this->db->affected_rows())?$this->db->insert_id():-1;
	}

	public function update($data)
	{
		$where = array();
		$where["id" ] = array_shift($data);
        $this->db->update($this->table_name, $data, $where);
		return ($this->db->affected_rows())?"Registro atualizado com sucesso!":"Erro: ao atualizar o registro.";
	}

	public function delete($id)
	{
		$where["id" ] = $id;
        $this->db->delete($this->table_name, $where);
		return ($this->db->affected_rows())?"Registro excluido com sucesso!":"Erro: ao excluir o registro.";
	}

}
