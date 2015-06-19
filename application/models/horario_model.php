<?php
		
class horario_model extends CI_Model {

	public $id;
	public $id_turma;
	public $id_disciplina;
	public $id_dia_semana;
	public $id_horario;
	public $n_tempos;

	private $horarios;
	private $dias;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'DiaHorario';
		$this->horarios = array(1=>'18h00','18h40','19h35','20h15','20h55','21h35');
		$this->dias = array(2=>'Segunda-Feira','Terça-Feira','Quarta-Feira','Quinta-Feira','Sexta-Feira','Sábado');
	}

    public function getAll()
    {
		$dados = array();
		$sql = "SELECT * FROM {$this->table_name}";
		$query = $this->db->query($sql);
		$result = $query->result('horario_model');
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
		$result = $query->result('horario_model');
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
        $this->db->insert($this->table_name, $data);
		return ($this->db->affected_rows())?"Registro inserido com sucesso!":"Erro: ao inserir o registro.";
	}

	public function delete()
	{
		$where["id"] = $this->id;
        $this->db->delete($this->table_name, $where);
		return ($this->db->affected_rows())?"Registro excluido com sucesso!":"Erro: ao excluir o registro.";
	}

	public function update()
	{
		$where["id"] = $this->id;
		$data = array(
					'id_turma' => $this->id_turma,
					'id_disciplina' => $this->id_disciplina,
					'id_dia_semana' => $this->id_dia_semana,
					'id_horario' => $this->id_horario,
					'n_tempos' => $this->n_tempos,
				);
        $this->db->update($this->table_name, $data, $where);
		return ($this->db->affected_rows())?"Registro atualizado com sucesso!":"Erro: ao atualizar o registro.";
	}

	public function getHorarioJSON($id_turma,$id_disciplina)
	{
		$horarios = array();
		$this->db->select('*');
		$this->db->from('DiaHorario');
        $this->db->where('id_turma',$id_turma);
        $this->db->where('id_disciplina',$id_disciplina);
		$query = $this->db->get();
		$result = $query->result_array();
		foreach($result as $key => $row):
			$row['horario'] = $this->horarios[$row['id_horario']];
			$row['dia'] = $this->dias[$row['id_dia_semana']];
			$horarios[] = $row;
		endforeach;
		return $horarios;
	}

}
