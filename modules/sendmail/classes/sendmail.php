<?php
/**
 * Favor nao retirar os creditos aqui descritos.
 * Classe utilizada para disparo de e-mail.
 *
 * @author Adalberto Ap. Silva
 * @contato: betoap@msn.com / betoap@globo.com
 * @licence open source
 * @version v 1.0 27/11/2007 10:14:46
 * @package WEB-INF/classes/php
 * @access public
*/

require_once("lerarquivo.php");
require_once("phpmailer.php");
require_once("smtp.php");

class SendMail extends PHPMailer{
	
	private $crlf;
	private $dados;
	private $config;
	
	public static function factory(array $config = array())
	{
		return new SendMail($config);
	}
	
	public function __construct(array $config = array()) {
		$this->config 	= Kohana::config("sendmail");
		$this->IsSMTP();
		$this->auth();
		return true;
	}
	
	private function auth(){
		$this->Timeout		= @$this->config['Timeout'];
		$this->MessageID	= @$this->config['MessageID'];
		$this->SMTPAuth		= @$this->config['SMTPAuth'];
		$this->SMTPSecure	= @$this->config['SMTPSecure']; 
		$this->Host 		= @$this->config['Host'];
		$this->Port			= @$this->config['Port'];
		$this->Username		= @$this->config['Username'];
		$this->Password		= @$this->config['Password'];
		$this->WordWrap		= @$this->config['WordWrap'];
		$this->CharSet 		= @$this->config['CharSet'];
		$this->SMTPDebug	= @$this->config['SMTPDebug'];
		$this->SetLanguage(@$this->config['Language']);
		return true;
	}
	
	public function setFrom($from) {
		$this->From			= $from['mail'];
		$this->FromName 	= $from['name'];
	}
	
	public function setTo($to) {
		$this->AddAddress($to['mail'], $to['name']);
	}
	
	public function setCC($cc) {
		$this->AddCC($cc['mail'], $cc['name']);
	}
	
	public function setBCC($bcc) {
		$this->AddBCC($bcc['mail'], $bcc['name']);
	}
	
	public function setSubject($subject) {
		$this->Subject = utf8_decode($subject);
	}
	
	public function setDados($dados){
		$this->dados = $dados;
	}
	public function getMail()
	{
		return parent::body;
	}
	
	public function attachFile($file, $name)
	{
		$this->AddAttachment($file, $name);
	}
	
	public function setContent($tpl = null){
		if(!empty($tpl['txt'])){
			$msg			= $tpl['txt'];
			$this->IsHTML(false);
		}elseif(!empty($tpl['file']) ) {
			$load	= new LerArquivo();
			$load->setCaminho(@$tpl['path']);
			$load->setArquivo(@$tpl['file']);
			$load->ler();
			foreach($this->dados as $chave=>$valor){
				$load->substitui("{".$chave."}", $valor);
			}
			$msg	= $load->exibir();
			$this->IsHTML(true);
		}
		$this->Body 	= $msg;
		$this->AltBody	= $msg;
	}
	
	public function send() {
		$mail = false;
		try{
			$mail	= $this->SendMail();
			$this->ClearAllRecipients();
			$this->ClearAttachments();
		}catch(Exception $error){
			echo $this->ErrorInfo;
		}
		return	@$mail;
	}
	
}
?>