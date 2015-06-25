<?php
		
class pessoa_model extends CI_Model {

	public $id;
	public $nome;
	public $login;
	public $password;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'Pessoa';
	}

    public function getAll()
    {
		$dados = array();
		$sql = "SELECT * FROM {$this->table_name}";
		$query = $this->db->query($sql);
		$result = $query->result('pessoa_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field;
			}			
		}
		return $dados;
    }
	
	public function getAcesso($id = null)
	{
		if (empty($id))
			$id = $this->id;
		$dados = array();
		$sql = "SELECT t.nome FROM Tela as t inner join Acessa as a on t.id = a.id_tela";
		$sql .= " inner join Possui as p on a.id_perfil = p.id_perfil where p.id_pessoa = {$id}";
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field->nome;
			}			
		}
		return $dados;
	}

	public function getPossui($id = null)
	{
		if (empty($id))
			$id = $this->id;
		$dados = array();
		$sql = "SELECT id_perfil FROM Possui WHERE id_pessoa = {$id}";
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field->id_perfil;
			}			
		}
		return $dados;
	}

	public function getPerfil($id = null)
	{
		if (empty($id))
			$id = $this->id;
		$dados = array();
		$sql = "SELECT pf.* FROM Perfil as pf inner join Possui as ps on pf.id = ps.id_perfil where ps.id_pessoa = {$id}";
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field;
			}			
		}
		$this->perfil = $dados;
		return $dados;
	}

    public function getId($id)
    {
		$sql = "SELECT * FROM {$this->table_name} where id = {$id}";
		$query = $this->db->query($sql);
		$result = $query->result('pessoa_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados = $field;
			}
			$dados->getPerfil();
			return $dados;
		}
		return NULL;
	}

	public function insert($data, $perfil = array())
	{
		array_shift($data);
		$this->db->insert($this->table_name, $data);
		$this->id = $this->db->insert_id;
		$this->setPerfil($perfil);
		return ($this->db->affected_rows())?"Registro inserido com sucesso!":"Erro: ao inserir o registro.";
	}

	public function insert_getid($data)
	{
		array_shift($data);
        $this->db->insert($this->table_name, $data);
		return ($this->db->affected_rows())?$this->db->insert_id():-1;
	}

	public function setPerfil($perfil = array())
	{
		$sql = "DELETE FROM Possui Where id_pessoa = {$this->id}";
		$this->db->query($sql);
		foreach($perfil as $key => $value):
			$this->db->insert('Possui', array('id_perfil'=>$value,'id_pessoa'=>$this->id));
		endforeach;
	}

	public function update($data, $perfil = array())
	{
		$where = array();
		$this->id = $where["id" ] = array_shift($data);
        $this->db->update($this->table_name, $data, $where);
		$this->setPerfil($perfil);
		return ($this->db->affected_rows())?"Registro atualizado com sucesso!":"Erro: ao atualizar o registro.";
	}

	public function delete($id)
	{
		$this->id = $where["id" ] = $id;
		$this->setPerfil();
        $this->db->delete($this->table_name, $where);
		return ($this->db->affected_rows())?"Registro excluido com sucesso!":"Erro: ao excluir o registro.";
	}

}
