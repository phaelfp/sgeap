<?php
		
class frequencia_model extends CI_Model {

	public $id;
	public $id_aluno;
	public $id_turma;
	public $id_disciplina;
	public $dt_aula;
	public $id_dia_semana;
	public $is_presente;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'Frequencia';
	}

    public function getAll()
    {
		$dados = array();
		$sql = "SELECT * FROM {$this->table_name}";
		$query = $this->db->query($sql);
		$result = $query->result('frequencia_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field;
			}			
		}
		return $dados;
	}

	public function getDisciplina($id_turma)
	{
		$sql = "SELECT DISTINCT d.id, d.impressao as disciplina FROM Disciplina as d INNER JOIN Frequencia as f ON d.id = f.id_disciplina WHERE f.id_turma = {$id_turma}";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$data = array();
		foreach ($result as $key => $value):
			$value['yearmonth'] = $this->getMesesAno($id_turma,$value['id']);
			$value['students'] = $this->getAlunoJSON($id_turma);
			$data[] = $value;
		endforeach;
		return $data;
	}

	public function getDiaFrequencia($id_turma, $id_disciplina, $mesano)
	{
		$sql = <<<EOF
SELECT DISTINCT DATE_FORMAT(f.dt_aula, '%d') as dia
, dh.n_tempos
FROM Frequencia as f
INNER JOIN DiaHorario as dh
   ON f.id_turma = dh.id_turma
  AND f.id_disciplina = dh.id_disciplina
  AND f.id_dia_semana = dh.id_dia_semana
WHERE f.id_turma = {$id_turma}
  AND f.id_disciplina = {$id_disciplina}
  AND DATE_FORMAT(f.dt_aula, '%Y%m') = '{$mesano}'
EOF;
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function getDiaFrequenciaAluno($id_turma, $id_disciplina, $mesano, $id_aluno)
	{
		$sql = <<<EOF
SELECT f.is_presente
, dh.n_tempos
FROM Frequencia as f
INNER JOIN DiaHorario as dh
   ON f.id_turma = dh.id_turma
  AND f.id_disciplina = dh.id_disciplina
  AND f.id_dia_semana = dh.id_dia_semana
WHERE f.id_turma = {$id_turma}
  AND f.id_disciplina = {$id_disciplina}
  AND f.id_aluno = {$id_aluno}
  AND DATE_FORMAT(f.dt_aula, '%Y%m') = '{$mesano}'
EOF;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getMesesAno($id_turma,$id_disciplina)
	{
		$sql = "select distinct date_format(f.dt_aula, '%Y%m') as dt_ym from Frequencia as f where f.id_turma = {$id_turma} and f.id_disciplina = {$id_disciplina}";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    public function getId($id)
    {
		$sql = "SELECT * FROM {$this->table_name} where id = {$id}";
		$query = $this->db->query($sql);
		$result = $query->result('frequencia_model');
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados = $field;
			}
			return $dados;
		}
		return NULL;
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

	public function store($data)
	{
		$this->db->select('id');
		$this->db->from('Frequencia');
		$this->db->where('id_turma', $data['id_turma']);
		$this->db->where('id_disciplina',$data['id_disciplina']);
		$this->db->where('id_dia_semana',$data['id_dia_semana']);
		$this->db->where('dt_aula',$data['dt_aula']);
		$this->db->where('id_aluno',$data['id_aluno']);
		$query = $this->db->get();
		if ($query->num_rows() > 0):
			$result = $query->result_array();
			$this->id = $result[0]['id'];
			$this->update($data);
		else:
			$this->insert($data);
		endif;
	}

	public function insert($data)
	{
		$this->db->insert($this->table_name, $data);
		if ($this->db->affected_rows()):
			$this->id = $this->db->insert_id();
			$message = "Registro inserido com sucesso!";
		else:
			$message = "Erro: ao inserir o registro.";
		endif;
		return $message;
	}

	public function update()
	{
		$where["id"] = $this->id;
		$data = array(
					'is_presente' => $this->is_presente,
				);
        $this->db->update($this->table_name, $data, $where);
		return ($this->db->affected_rows())?"Registro atualizado com sucesso!":"Erro: ao atualizar o registro.";
	}

}
