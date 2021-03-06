<?php

class certificacao_model extends CI_Model {

	public $id;
	public $descricao;
	public $media;
	public $id_certificacao_anterior;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'Certificacao';
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
		$result = $query->result('certificacao_model');
		if ($query->num_rows() > 0)
		{
			return $result;
		}
		return $dados;
    }

    public function getId($id)
    {
		$sql = "SELECT * FROM {$this->table_name} where id = {$id}";
		$query = $this->db->query($sql);
		$result = $query->result('certificacao_model');
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
		$this->id = $this->db->insert_id();
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

}
