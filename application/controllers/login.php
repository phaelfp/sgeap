<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller{

	function index($msg_erro=false){
		$this->load->helper(array('form','url'));
		$vars = array();
		$vars['title'] 	= "Autenticação - Usuário";
		$this->load->view('header',$vars);
		$vars = array();
		if ($msg_erro !== false)
			$vars['error']	= $msg_erro;
		$this->load->view('login',$vars);	
		$this->load->view('footer');	
			
		
	}
	function validar(){
		header("Access-Control-Allow-Origin: *");
		$this->load->model('login_model');
			
		$login 	= $this->input->post('username',true);
		$pass 	= $this->input->post('password',true);
		
		$ok = $this->login_model->verfica_login($login,$pass);

		if($ok){
			$vars_session = array('registro'=>$ok->login,'usuario'=>$ok->nome, 'menu'=>$this->get_menu($ok->login));
			$this->session->set_userdata($vars_session);
			$dados  = array("error" => '');
			echo json_encode($dados);
			exit();
		}
		else{	
			$dados = array("error" =>'Matr&iacute;cula ou senha inv&aacute;lida');
			echo json_encode($dados);
			exit();
		}		
	}
	function get_menu($registro)
	{
		$base_url = base_url();
		$this->load->model('perfil_model');
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
        if ($this->perfil_model->verifica_acesso($registro,'pessoa/index'))
			$admin[] = '<li><a href="'.$base_url.'index.php/pessoa">Pessoa</a></li>';

        if ($this->perfil_model->verifica_acesso($registro,'perfil/index'))
			$admin[] = '<li><a href="'.$base_url.'index.php/perfil">Perfil</a></li>';
		
        if ($this->perfil_model->verifica_acesso($registro,'tela/index'))
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
		if ($this->perfil_model->verifica_acesso($registro,'anoletivo/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/anoletivo">Ano Letivo</a></li>';

		if ($this->perfil_model->verifica_acesso($registro,'serie/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/serie">S&eacute;rie</a></li>';
			
		if ($this->perfil_model->verifica_acesso($registro,'curso/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/curso">Curso</a></li>';
			
		if ($this->perfil_model->verifica_acesso($registro,'certificacao/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/certificacao">Certifica&ccedil;&atilde;o</a></li>';

		if (count($cad)>0)
			$cad[] = '<li class="divider"></li>';
			
		if ($this->perfil_model->verifica_acesso($registro,'disciplina/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/disciplina">Disciplina</a></li>';

		if ($this->perfil_model->verifica_acesso($registro,'turma/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/turma">Turma</a></li>';

		if ($this->perfil_model->verifica_acesso($registro,'horario/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/horario">Hor&aacute;rio</a></li>';

		if (count($cad)>3)
			$cad[] = '<li class="divider"></li>';
			
		if ($this->perfil_model->verifica_acesso($registro,'aluno/index'))
			$cad[] = '<li><a href="'.$base_url.'index.php/aluno">Aluno</a></li>';

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
		if ($this->perfil_model->verifica_acesso($registro,'turma/listaPresenca'))
			$rel[] = '<li><a href="'.$base_url.'index.php/turma/listaPresenca">Lista de Presen&ccedil;a</a></li>';

		if ($this->perfil_model->verifica_acesso($registro,'turma/listaFrequencia'))
			$rel[] = '<li><a href="'.$base_url.'index.php/turma/listaFrequencia">Frequencia (Diario)</a></li>';


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
	
		if ($this->perfil_model->verifica_acesso($registro,'matricula/index')):
			$menu .= <<<EOF
        <li class="dropdown">
			<a href="{$base_url}index.php/matricula">Matr&iacute;cula</a>
        </li>
EOF;
		endif;

		if ($this->perfil_model->verifica_acesso($registro,'frequencia/index')):
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
		return str_replace('"','|',$menu);
	}
	function error(){
		$msg_erro = "Usu&aacute;rio ou Senha inv&aacute;lido";	
		$this->index($msg_erro);
	}
	function logoff(){
		$this->session->sess_destroy();
		$this->index();
	}
}
