<?php
		
class perfil_model extends CI_Model {

	public $id;
	public $descricao;

	public function __construct()
    {
        parent::__construct();
		$this->table_name = 'Perfil';
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

    public function getAll($page = 0)
    {
		$dados = array();
		$sql = "SELECT * FROM {$this->table_name}";
		if ($page > 0)
			$sql .= " LIMIT 20 OFFSET ". (($page-1)*20);
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
		$this->id = $this->db->insert_id();
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
		$this->id = $where["id" ] = array_shift($data);
        $this->db->update($this->table_name, $data, $where);
		$this->setTela($tela);
		return ($this->db->affected_rows())?"Registro atualizado com sucesso!":"Erro: ao atualizar o registro.";
	}

	public function delete($id)
	{
		$this->id = $where["id" ] = $id;
		$sql = "DELETE FROM Acessa WHERE id_perfil = {$this->id}";
		$this->db->query($sql);
        $this->db->delete($this->table_name, $where);
		return ($this->db->affected_rows())?"Registro excluido com sucesso!":"Erro: ao excluir o registro.";
	}

	public function getAcessa($id = null)
	{
		if (empty($id))
			$id = $this->id;
		$sql = "SELECT id_tela FROM Acessa WHERE id_perfil = {$id}";
		$dados = array();
		$query = $this->db->query($sql);
		$result = $query->result();
		if ($query->num_rows() > 0)
		{
			foreach ($result as $key => $field){
				$dados[] = $field->id_tela;
			}			
		}
		return $dados;
	}

	public function verifica_acesso($usuario, $nome_tela)
	{
		$tela = trim(strtolower(str_replace('::','/',$nome_tela)));
		$sql = <<<EOF
SELECT count(1) as acessa 
FROM Tela as t
INNER JOIN Acessa as a
   ON t.id = a.id_tela
INNER JOIN Possui as p
   ON a.id_perfil = p.id_perfil
INNER JOIN Pessoa as u
   ON p.id_pessoa = u.id
WHERE u.login = '{$usuario}'
  AND t.nome = '{$tela}'
EOF;
		$query = $this->db->query($sql);
		$result = $query->result();
		return (bool)($result[0]->acessa>0);
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

	function getMenu($registro)
	{
		$base_url = base_url();
		$menu = <<<EOF
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <a class="navbar-brand" href="{$base_url}">SGEAP</a>
    </div>    
    <div class="collapse navbar-collapse" id="bs-navbar-collapse">
	  <ul class="nav navbar-nav">
EOF;
		$admin = array();
        if ($this->verifica_acesso($registro,'pessoa/index'))
			$admin[] = '<li><a href="'.$base_url.'index.php/pessoa">Pessoa</a></li>';

        if ($this->verifica_acesso($registro,'perfil/index'))
			$admin[] = '<li><a href="'.$base_url.'index.php/perfil">Perfil</a></li>';
		
        if ($this->verifica_acesso($registro,'tela/index'))
			$admin[] = '<li><a href="'.$base_url.'index.php/tela">Tela</a></li>';

		if (count($admin)>0):
			$admin = implode("\n",$admin);
			$menu .= <<<EOF
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administra&ccedil;&atilde;o<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			{$admin}
          </ul>
		</li>
EOF;
		endif;

		$cad = array();
		if ($this->verifica_acesso($registro,'anoletivo/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/anoletivo">Ano Letivo</a></li>';

		if ($this->verifica_acesso($registro,'serie/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/serie">S&eacute;rie</a></li>';
			
		if ($this->verifica_acesso($registro,'curso/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/curso">Curso</a></li>';
			
		if ($this->verifica_acesso($registro,'certificacao/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/certificacao">Certifica&ccedil;&atilde;o</a></li>';

		if (count($cad)>0)
			$cad[] = '<li class="divider"></li>';
			
		if ($this->verifica_acesso($registro,'disciplina/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/disciplina">Disciplina</a></li>';

		if ($this->verifica_acesso($registro,'turma/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/turma">Turma</a></li>';

		if ($this->verifica_acesso($registro,'horario/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/horario">Hor&aacute;rio</a></li>';

		if (count($cad)>3)
			$cad[] = '<li class="divider"></li>';
			
		if ($this->verifica_acesso($registro,'aluno/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/aluno">Aluno</a></li>';

		if ($this->verifica_acesso($registro,'pessoa/changepass'))
			$cad[] = '<li><a href="'.$base_url.'index.php/pessoa/changepass">Alterar Senha</a></li>';

		if (count($cad)>0):
			$cad = implode("\n",$cad);
			$menu .= <<<EOF
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cadastro<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			{$cad}
		  </ul>
		</li>
EOF;
		endif;

		$rel = array();
		if ($this->verifica_acesso($registro,'turma/listaPresenca'))
			$rel[] = '<li><a href="'.$base_url.'index.php/turma/listaPresenca">Lista de Presen&ccedil;a</a></li>';

		if ($this->verifica_acesso($registro,'turma/listaFrequencia'))
			$rel[] = '<li><a href="'.$base_url.'index.php/turma/listaFrequencia">Frequencia (Diario)</a></li>';

		if ($this->verifica_acesso($registro,'horario/listaHorario'))
			$rel[] = '<li><a href="'.$base_url.'index.php/horario/listaHorario">Horários</a></li>';


		if (count($rel)>0):
			$rel = implode("\n",$rel);
			$menu .= <<<EOF
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Relat&oacute;rios<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			{$rel}
          </ul>
		</li>
EOF;
		endif;
	
		if ($this->verifica_acesso($registro,'matricula/index')):
			$menu .= <<<EOF
        <li class="dropdown">
			<a href="{$base_url}index.php/matricula">Matr&iacute;cula</a>
        </li>
EOF;
		endif;

		if ($this->verifica_acesso($registro,'frequencia/index')):
			$menu .= <<<EOF
        <li class="dropdown">
			<a href="{$base_url}index.php/frequencia">Frequ&ecirc;ncia</a>
        </li>
EOF;
		endif;

		$menu .= <<<EOF
        <li class="dropdown">
			<a href="{$base_url}index.php/login/logoff">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
EOF;
		return $menu;
	}

}
