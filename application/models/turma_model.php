<?php
		
class turma_model extends CI_Model {

	public $id;
	public $id_anoletivo;
	public $id_curso;
	public $id_serie;
    public $descricao;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'Turma';
	}

	public function getCursoJSON($id_anoletivo)
	{
		$cursos = array();
		$this->db->distinct();
		$this->db->select('Curso.*');
		$this->db->from('Turma');
		$this->db->join('Curso','Turma.id_curso = Curso.id');
        $this->db->where('Turma.id_anoletivo',$id_anoletivo);
		$query = $this->db->get();
		$result = $query->result_array();
		foreach($result as $key => $row):
			$cursos[] = $row;
		endforeach;
		return $cursos;
	}

	public function getSerieJSON($id_anoletivo,$id_curso)
	{
		$series = array();
		$this->db->distinct();
		$this->db->select('Serie.*');
		$this->db->from('Turma');
		$this->db->join('Serie','Turma.id_serie = Serie.id');
        $this->db->where('Turma.id_anoletivo',$id_anoletivo);
        $this->db->where('Turma.id_curso',$id_curso);
		$query = $this->db->get();
		$result = $query->result_array();
		foreach($result as $key => $row):
			$series[] = $row;
		endforeach;
		return $series;
	}

	public function getTurmaJSON($id_anoletivo,$id_curso,$id_serie)
	{
		$turmas = array();
		$this->db->distinct();
		$this->db->select('*');
		$this->db->from('Turma');
        $this->db->where('id_anoletivo',$id_anoletivo);
        $this->db->where('id_curso',$id_curso);
        $this->db->where('id_serie',$id_serie);
		$query = $this->db->get();
		$result = $query->result_array();
		foreach($result as $key => $row):
			$turmas[] = $row;
		endforeach;
		return $turmas;
	}

	public function get_anoletivo()
	{                               
		$sql = "SELECT * FROM AnoLetivo WHERE id = {$this->id_anoletivo}";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0):
			$anoletivo = $query->first_row();
			return $anoletivo->ano;
		endif;
		return '';
	}
	
	public function get_curso()
	{
		$sql = "SELECT * FROM Curso WHERE id = {$this->id_curso}";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0):
			$curso = $query->first_row();
			return $curso->descricao;
		endif;
		return '';
	}

	public function get_serie()
	{
		$sql = "SELECT * FROM Serie WHERE id = {$this->id_serie}";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0):
			$serie = $query->first_row();
			return $serie->descricao;
		endif;
		return '';
	}

    public function getAll()
    {
		$dados = array();
		$sql = "SELECT * FROM {$this->table_name}";
		$query = $this->db->query($sql);
		$result = $query->result('turma_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field;
			}			
		}
		return $dados;
    }
	
	public function getCombo()
    {
		$dados = array();
		$sql = "SELECT t.*, c.descricao as curso, a.ano as anoletivo";
	    $sql .= " , s.descricao as serie FROM {$this->table_name} t ";
		$sql .= "inner join curso c on t.id_curso = c.id ";
		$sql .= "inner join anoletivo a on t.id_anoletivo = a.id ";
		$sql .= "inner join serie s on t.id_serie = s.id ";
		$sql .= "order by a.ano,c.descricao,s.descricao ";
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[$field->id] = "{$field->anoletivo} / {$field->curso} / {$field->serie}";
			}			
		}
		return $dados;
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
			$this->id = $dados->id;
			$this->id_anoletivo = $dados->id_anoletivo;
			$this->id_serie = $dados->id_serie;
			$this->id_curso = $dados->id_curso;
			$this->descricao = $dados->descricao;
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

	public function update($data)
	{
		$where = array();
		$where["id" ] = array_shift($data);
        $this->db->update($this->table_name, $data, $where);
		return ($this->db->affected_rows())?"Registro atualizado com sucesso!":"Erro: ao atualizar o registro.";
	}

}
