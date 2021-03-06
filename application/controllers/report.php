<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->registro 	= $this->session->userdata('registro');
		$this->usuario 	 	= strtoupper($this->session->userdata('usuario'));
		if(empty($this->registro) || empty($this->usuario)){
			header('location:../login/logoff');exit;
		}
	}

	public function index()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('report_model');
        $this->load->library('Fpdf');
		$courses = $this->report_model->getCourses();

		$pdf = new pdf();
		foreach( $courses as $course):
			if (count($course['yearmonth'])):
				foreach($course['yearmonth'] as $yearmonth):
					$pdf->SetFont('Arial','',10);
					$pdf->AddPage('P');
					$pdf->Rect( 10, 10, 116, 21, 'D');
					$pdf->Text( 28, 16, utf8_decode("ANOTAÇÃO DA FREQUÊNCIA ÀS AULAS DADAS"));
					$pdf->Rect(126, 10,  33, 21, 'D');
					$pdf->Text(133, 22, utf8_decode("AFERIÇÕES"));
					$pdf->RoundedRect(22, 21.5, 35, 8, 1);
					$pdf->Text( 14, 27, utf8_decode("MÊS"));
					$pdf->RoundedRect(87, 21.5, 35, 8, 1);
					$pdf->Text( 66, 27, utf8_decode("DISCIPLINA"));

					$pdf->Text( 89, 27, $course['description']);
					$pdf->Text( 24, 27, $this->getMes(substr($yearmonth['dt_ym'],4,2)));
					$pdf->SetXY(10,31);

					/*
					 * Primeira linha para os dias e aferições
					 */

					$pdf->Rect(  10,  31, 5, 5.5);
					$pdf->Rect(  15,  31, 5, 5.5);
					$pdf->Rect(  20,  31, 5, 5.5);
					$pdf->Rect(  25,  31, 5, 5.5);
					$pdf->Rect(  30,  31, 5, 5.5);
					$pdf->Rect(  35,  31, 5, 5.5);
					$pdf->Rect(  40,  31, 5, 5.5);
					$pdf->Rect(  45,  31, 5, 5.5);
					$pdf->Rect(  50,  31, 5, 5.5);
					$pdf->Rect(  55,  31, 5, 5.5);
					$pdf->Rect(  60,  31, 5, 5.5);
					$pdf->Rect(  65,  31, 5, 5.5);
					$pdf->Rect(  70,  31, 5, 5.5);
					$pdf->Rect(  75,  31, 5, 5.5);
					$pdf->Rect(  80,  31, 5, 5.5);
					$pdf->Rect(  85,  31, 5, 5.5);
					$pdf->Rect(  90,  31, 5, 5.5);
					$pdf->Rect(  95,  31, 5, 5.5);
					$pdf->Rect( 100,  31, 5, 5.5);
					$pdf->Rect( 105,  31, 5, 5.5);
					$pdf->Rect( 110,  31, 5, 5.5);
					$pdf->Rect( 115,  31, 5, 5.5);
					$pdf->Rect( 120,  31, 6, 5.5);
					$pdf->Rect( 126,  31,11, 5.5);
					$pdf->Rect( 137,  31,11, 5.5);
					$pdf->Rect( 148,  31,11, 5.5);

					//$pdf->Cell(30, 5,"{$course['description']}",0,0);
					//$pdf->Cell( 0, 5, $this->getMes(substr($yearmonth['dt_ym'],4,2)) . " / " . substr($yearmonth['dt_ym'],0,4),0,1);

					$pdf->Cell(5,5.5,utf8_decode("Nº"),0,0);
					foreach($this->report_model->getAttendanceDay($yearmonth['dt_ym'], $course['id']) as $day):
						$pdf->Cell(5,5.5,"{$day}",0,0,'C');
						$pdf->Cell(5,5.5,"{$day}",0,0,'C');
					endforeach;
					$pdf->Ln(5.5);
					foreach($course['students'] as $i => $student):
                    	$py = $pdf->GetY();
						$pdf->Cell(5, 5.5,$i+1,1,0);
   		 				$pdf->Rect(  15, $py, 5, 5.5);
						$pdf->Rect(  20, $py, 5, 5.5);
						$pdf->Rect(  25, $py, 5, 5.5);
						$pdf->Rect(  30, $py, 5, 5.5);
						$pdf->Rect(  35, $py, 5, 5.5);
						$pdf->Rect(  40, $py, 5, 5.5);
						$pdf->Rect(  45, $py, 5, 5.5);
						$pdf->Rect(  50, $py, 5, 5.5);
						$pdf->Rect(  55, $py, 5, 5.5);
						$pdf->Rect(  60, $py, 5, 5.5);
						$pdf->Rect(  65, $py, 5, 5.5);
						$pdf->Rect(  70, $py, 5, 5.5);
						$pdf->Rect(  75, $py, 5, 5.5);
						$pdf->Rect(  80, $py, 5, 5.5);
						$pdf->Rect(  85, $py, 5, 5.5);
						$pdf->Rect(  90, $py, 5, 5.5);
						$pdf->Rect(  95, $py, 5, 5.5);
						$pdf->Rect( 100, $py, 5, 5.5);
						$pdf->Rect( 105, $py, 5, 5.5);
						$pdf->Rect( 110, $py, 5, 5.5);
						$pdf->Rect( 115, $py, 5, 5.5);
						$pdf->Rect( 120, $py, 6, 5.5);
						$pdf->Rect( 126, $py,11, 5.5);
						$pdf->Rect( 137, $py,11, 5.5);
						$pdf->Rect( 148, $py,11, 5.5);
						foreach($this->report_model->getAttendance($student['id_class'],$yearmonth['dt_ym']) as $day):
                            $label = ($day['is_attendance'])?"·":"F";
							$pdf->Cell(5, 5.5, utf8_decode($label),0,0,'C');
							$pdf->Cell(5, 5.5, utf8_decode($label),0,0,'C');
						endforeach;
                        $pdf->Ln(5.5);
					endforeach;
				endforeach;
			endif;
		endforeach;
        $pdf->Output('attendance.pdf','F');
		exit();
	}

	private function getMes($monthNum)
	{
		$month = array(
                	'01' => 'Janeiro',
                	'02' => 'Fevereiro',
                	'03' => 'Março',
                	'04' => 'Abril',
                	'05' => 'Maio',
                	'06' => 'Junho',
                	'07' => 'Julho',
                	'08' => 'Agosto',
                	'09' => 'Setembro',
                	'10' => 'Outubro',
                	'11' => 'Novembro',
                	'12' => 'Dezembro',
			);
		return utf8_decode($month[$monthNum]);
	}

	public function listaPresenca()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
        $this->load->library('pdf');

		$this->load->model('turma_model');
		$this->load->model('serie_model');
		$this->load->model('curso_model');
		$this->load->model('anoletivo_model');
		$this->load->model('frequencia_model');
		$id_turma = $this->input->post('id_turma');
		$alunos = $this->frequencia_model->getAlunoJSON($id_turma);

		 $data = array(
			'id' => $this->input->post('id_turma'),
			'id_curso' => $this->input->post('id_curso'),
			'id_serie' => $this->input->post('id_serie'),
			'id_anoletivo' => $this->input->post('id_anoletivo'),
		);

		$anoletivo = $this->anoletivo_model->getId($data['id_anoletivo']);
		$serie     = $this->serie_model->getId($data['id_serie']);
		$curso = $this->curso_model->getId($data['id_curso']);
		$turma = $this->turma_model->getId($data['id']);

		$pdf = new pdf();
		$pdf->SetFont('Arial','',10);
		$pdf->AddPage('P');
		$pdf->Cell(0,5,$anoletivo->ano,0,1,'C');
		$text = "{$serie->descricao} / {$curso->descricao}";
		$pdf->Cell(0,5,utf8_decode($text),0,1,'C');
		$pdf->Cell(0,5,utf8_decode($turma->descricao),0,1,'C');

		$pdf->Cell(100,5,"NOME",1,0,'C');
		$pdf->Cell(  0,5,"ASSINATURA",1,1,'C');

		foreach ($alunos as $ids => $aluno):
	  		$pdf->Cell(100,5,utf8_decode($aluno['nm_aluno']),1,0,'L');
			$pdf->Cell(  0,5,"",1,1);
	  	endforeach;

        $pdf->Output();
		exit();
	}

	public function listaHorario()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('horario_model');
        $this->load->library('pdf');
		$id_anoletivo = $this->input->post('id_anoletivo');
		$horarios = $this->horario_model->getListaHorario($id_anoletivo);
		$pdf = new pdf();
		$pdf->SetFont('Arial','',10);
		$dias = array('Segunda-Feira','Terça-Feira','Quarta-Feira','Quinta-Feira','Sexta-Feira','Sábado');
		$diacoluna = array('segunda','terca','quarta','quinta','sexta','sabado');
		$pdf->AddPage('L');
		$pdf->Cell(30,5,'',0,0);
		foreach($dias as $key=>$value){
			$pdf->Cell(30,5, utf8_decode($value),1,0,'C');
		}
		$pdf->Ln(5);

		foreach($horarios as $k => $item){
			$pdf->Cell(30,5, $item['inicio']. utf8_decode(' às ') . $item['termino'],1,0,'C');
			foreach($diacoluna as $idx => $column)
				$pdf->Cell(30, 5,utf8_decode($item[$column]),1,0,'C');
			$pdf->Ln(5);
		}

        $pdf->Output();
		exit();
	}

	public function listaFrequencia()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
		$this->load->model('frequencia_model');
        $this->load->library('pdf');
		$id_turma = $this->input->post('id_turma');
        $disciplinas = $this->frequencia_model->getDisciplina($id_turma);
		$pdf = new pdf();
		foreach( $disciplinas as $disciplina):
			if (count($disciplina['yearmonth'])):
				foreach($disciplina['yearmonth'] as $yearmonth):
					$pdf->SetFont('Arial','',10);
					$pdf->AddPage('P');
					$pdf->Rect( 10, 10, 116, 21, 'D');
					$pdf->Text( 28, 16, utf8_decode("ANOTAÇÃO DA FREQUÊNCIA ÀS AULAS DADAS"));
					$pdf->Rect(126, 10,  33, 21, 'D');
					$pdf->Text(133, 22, utf8_decode("AFERIÇÕES"));
					$pdf->RoundedRect(22, 21.5, 35, 8, 1);
					$pdf->Text( 14, 27, utf8_decode("MÊS"));
					$pdf->RoundedRect(87, 21.5, 35, 8, 1);
					$pdf->Text( 66, 27, utf8_decode("DISCIPLINA"));

					$pdf->Text( 89, 27, utf8_decode($disciplina['disciplina']));
					$pdf->Text( 24, 27, $this->getMes(substr($yearmonth['dt_ym'],4,2)));
					$pdf->SetXY(10,31);

					/*
					 * Primeira linha para os dias e aferições
					 */

					$pdf->Rect(  10,  31, 5, 5.5);
					$pdf->Rect(  15,  31, 5, 5.5);
					$pdf->Rect(  20,  31, 5, 5.5);
					$pdf->Rect(  25,  31, 5, 5.5);
					$pdf->Rect(  30,  31, 5, 5.5);
					$pdf->Rect(  35,  31, 5, 5.5);
					$pdf->Rect(  40,  31, 5, 5.5);
					$pdf->Rect(  45,  31, 5, 5.5);
					$pdf->Rect(  50,  31, 5, 5.5);
					$pdf->Rect(  55,  31, 5, 5.5);
					$pdf->Rect(  60,  31, 5, 5.5);
					$pdf->Rect(  65,  31, 5, 5.5);
					$pdf->Rect(  70,  31, 5, 5.5);
					$pdf->Rect(  75,  31, 5, 5.5);
					$pdf->Rect(  80,  31, 5, 5.5);
					$pdf->Rect(  85,  31, 5, 5.5);
					$pdf->Rect(  90,  31, 5, 5.5);
					$pdf->Rect(  95,  31, 5, 5.5);
					$pdf->Rect( 100,  31, 5, 5.5);
					$pdf->Rect( 105,  31, 5, 5.5);
					$pdf->Rect( 110,  31, 5, 5.5);
					$pdf->Rect( 115,  31, 5, 5.5);
					$pdf->Rect( 120,  31, 6, 5.5);
					$pdf->Rect( 126,  31,11, 5.5);
					$pdf->Rect( 137,  31,11, 5.5);
					$pdf->Rect( 148,  31,11, 5.5);

					$pdf->Cell(5,5.5,utf8_decode("Nº"),0,0);
					foreach($this->frequencia_model->getDiaFrequencia($id_turma, $disciplina['id'], $yearmonth['dt_ym']) as $dia):
						for ($tempo=0;$tempo<$dia['n_tempos'];$tempo++)
							$pdf->Cell(5,5.5,"{$dia['dia']}",0,0,'C');
					endforeach;
					$pdf->Ln(5.5);
					foreach($disciplina['students'] as $i => $student):
                    	$py = $pdf->GetY();
						$pdf->Cell(5, 5.5,$i+1,1,0);
   		 				$pdf->Rect(  15, $py, 5, 5.5);
						$pdf->Rect(  20, $py, 5, 5.5);
						$pdf->Rect(  25, $py, 5, 5.5);
						$pdf->Rect(  30, $py, 5, 5.5);
						$pdf->Rect(  35, $py, 5, 5.5);
						$pdf->Rect(  40, $py, 5, 5.5);
						$pdf->Rect(  45, $py, 5, 5.5);
						$pdf->Rect(  50, $py, 5, 5.5);
						$pdf->Rect(  55, $py, 5, 5.5);
						$pdf->Rect(  60, $py, 5, 5.5);
						$pdf->Rect(  65, $py, 5, 5.5);
						$pdf->Rect(  70, $py, 5, 5.5);
						$pdf->Rect(  75, $py, 5, 5.5);
						$pdf->Rect(  80, $py, 5, 5.5);
						$pdf->Rect(  85, $py, 5, 5.5);
						$pdf->Rect(  90, $py, 5, 5.5);
						$pdf->Rect(  95, $py, 5, 5.5);
						$pdf->Rect( 100, $py, 5, 5.5);
						$pdf->Rect( 105, $py, 5, 5.5);
						$pdf->Rect( 110, $py, 5, 5.5);
						$pdf->Rect( 115, $py, 5, 5.5);
						$pdf->Rect( 120, $py, 6, 5.5);
						$pdf->Rect( 126, $py,11, 5.5);
						$pdf->Rect( 137, $py,11, 5.5);
						$pdf->Rect( 148, $py,11, 5.5);
						foreach($this->frequencia_model->getDiaFrequenciaAluno($id_turma, $disciplina['id'], $yearmonth['dt_ym'], $student['id']) as $day):
							$label = ($day['is_presente'])?"·":"F";
							for ($tempo=0;$tempo<$day['n_tempos'];$tempo++)
								$pdf->Cell(5, 5.5, utf8_decode($label),0,0,'C');
						endforeach;
                        $pdf->Ln(5.5);
					endforeach;
				endforeach;
			endif;
		endforeach;
        $pdf->Output();
		exit();
	}


	public function listaNota()
	{
		$this->load->model('perfil_model');
		if (!$this->perfil_model->verifica_acesso($this->registro,__METHOD__))
		{
			header('location:' . base_url() . 'index.php/forbidden');exit;
		}
  	$this->load->library('pdf');
		$pdf = new pdf();
		$pdf->SetFont('Arial','',10);
		$this->load->model('report_model');
		$id_turma = $this->input->post('id_turma');
		$id_certificacao = $this->input->post('id_certificacao');
		$notas = $this->report_model->getNotas($id_turma, $id_certificacao);
		$last_certificacao = '';
		$last_disciplina = '';
		foreach($notas as $id => $nota):
			if ($last_certificacao !== $nota->nm_certificacao):
				$pdf->AddPage('P');
				$last_certificacao = $nota->nm_certificacao;
				$last_disciplina = $nota->nm_disciplina;
				$pdf->Cell( 50,5.5, utf8_decode($last_certificacao));
				$pdf->Cell(100,5.5, utf8_decode($last_disciplina),0,1,'C');
				$pdf->Cell(100,5.5, 'NOME',0,0,'C');
				$pdf->Cell(20,5.5, 'NOTA',0,1,'C');
			endif;
			if ($last_disciplina !== $nota->nm_disciplina):
				$pdf->AddPage('P');
				$last_disciplina = $nota->nm_disciplina;
				$pdf->Cell( 50,5.5, utf8_decode($last_certificacao));
				$pdf->Cell(100,5.5, utf8_decode($last_disciplina),0,1,'C');
				$pdf->Cell(100,5.5, 'NOME',0,0,'C');
				$pdf->Cell(20,5.5, 'NOTA',0,1,'C');
			endif;
			$pdf->Cell(100,5.5, utf8_decode($nota->nm_aluno),0,0,'R');
			$pdf->Cell(20,5.5, utf8_decode($nota->nota),0,1,'C');
		endforeach;
		$pdf->Output();
		exit();
	}
}
