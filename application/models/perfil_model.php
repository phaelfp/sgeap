<?php
		
class perfil_model extends CI_Model {

	public $id;
	public $descricao;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'Perfil';
	}

    public function getAll()
    {
		$dados = array();
		$sql = "SELECT * FROM {$this->table_name}";
		$query = $this->db->query($sql);
		$result = $query->result('perfil_model');
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
		$result = $query->result('perfil_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados = $field;
			}
			return $dados;
		}
		return NULL;
	}

	public function insert($data, $tela = array())
	{
		array_shift($data);
		$this->db->insert($this->table_name, $data);
		$this->id = $this->db->insert_id;
		$this->setTela($tela);
		return ($this->db->affected_rows())?"Registro inserido com sucesso!":"Erro: ao inserir o registro.";
	}

	public function insert_getid($data)
	{
		array_shift($data);
        $this->db->insert($this->table_name, $data);
		return ($this->db->affected_rows())?$this->db->insert_id():-1;
	}

	public function update($data, $tela = array())
	{
		$where = array();
		$where["id" ] = array_shift($data);
        $this->db->update($this->table_name, $data, $where);
		$this->setTela($tela);
		return ($this->db->affected_rows())?"Registro atualizado com sucesso!":"Erro: ao atualizar o registro.";
	}

	public function delete($id)
	{
		$sql = "DELETE FROM Acessa WHERE id_perfil = {$this->id}";
		$this->db->query($sql);
		$where["id" ] = $id;
        $this->db->delete($this->table_name, $where);
		return ($this->db->affected_rows())?"Registro excluido com sucesso!":"Erro: ao excluir o registro.";
	}

	public function getAcessa($id = null)
	{
		if (empty($id))
			$id = $this->id;
		$sql = "SELECT id_tela FROM Acessa WHERE id_perfil = {$id}";
		$dados = array();
		$result = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field->id_tela;
			}			
		}
		$this->acessa = $dados;
		return $dados;
	}

	public function getTela($id = null)
	{
		if (empty($id))
			$id = $this->id;
		$sql = "SELECT t.* FROM Tela as t inner join Acessa as a on t.id = a.id_tela WHERE a.id_perfil = {$id}";
		$dados = array();
		$result = $this->db->query($sql);
		$result = $query->result('tela_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field;
			}			
		}
		$this->tela = $dados;
		return $dados;
	}

	public function setTela($tela = array())
	{
		$sql = "DELETE FROM Acessa WHERE id_perfil = {$this->id}";
		$this->db->query($sql);
		foreach($tela as $key => $value):
			$this->db->insert('Acessa', array("id_perfil"=>$this->id, "id_tela"=>$value));
		endforeach;
	}
}
