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
		$this->load->model('login_model');
			
		$login 	= $this->input->post('username',true);
		$pass 	= $this->input->post('password',true);
		
		$ok = $this->login_model->verfica_login($login,$pass);

		if($ok){
			$vars_session = array('registro'=>$ok->login,'usuario'=>$ok->nome);
			$this->session->set_userdata($vars_session);
			$dados  = array("error" => '');
			echo json_encode((object)$dados);
			exit();
		}
		else{	
			$dados = array("error" =>'Matr&iacute;cula ou senha inv&aacute;lida');
			echo json_encode((object)$dados);
			exit();
		}		
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
