<?php
/**
 * Favor nao retirar os creditos aqui descritos.
 * Classe utilizada para ler arquivo de texto/html.
 *
 * @author Adalberto Ap. Silva
 * @contato: betoap@msn.com / betoap@globo.com
 * @licence open source
 * @version v 1.0 05/11/2007 10:14:46
 * @package WEB-INF/classes/php
 * @access public
*/
 class LerArquivo{
 	
 	/**
 	 * Variavel com o caminho do arquivo.
 	 * @name $caminho
 	 * @var String
 	 * @access private
 	 */
 	var $caminho;
 	
 	/**
 	 * Variavel com o nome do arquivo.
 	 * @name $arquivo
 	 * @var String
 	 * @access private
 	 */
 	var $arquivo;
 	 	
 	/**
 	 * Guarda o conteudo do aquivo aberto.
 	 * @name $conteudo
 	 * @var String
 	 * @access private
 	 */
 	var $conteudo; 
	 
	 /**
	  * M�todo
	  * @name __construct
	  * @access public
	  * @return true;
	  */
	 function __construct(){
	 	return true;
	 }
	 /**
	  * M�todo
	  * Inica caminho aonde se encontra o arquivo.
	  * @name setCaminho
	  * @param String $caminho
	  * @access public
	  */
	 function setCaminho($caminho){
	 	$this->caminho	= $caminho;
	 }
	 /**
	  * M�todo
	  * Retorna o caminho para o arquivo.
	  * @name getCaminho
	  * @access public
	  * @return String
	  */
	 function getCaminho(){
	 	return $this->caminho;
	 }
	 /**
	  * M�todo
	  * Inica o nome do arquivo a ser lido.
	  * @name setArquivo
	  * @access public
	  * @param String $arquivo
	  * @access private
	  */
	 function setArquivo($arquivo){
	 	$this->arquivo	= $arquivo;
	 }
	 /**
	  * M�todo
	  * Retorna o nome do arquivo.
	  * @name getArquivo
	  * @access public
	  * @return String
	  */
	 function getArquivo(){
	 	return $this->arquivo;
	 }
	 /**
	  * M�todo
	  * Abre o arquivo para leitura.
	  * Caso o arquivo seja aberto com exito retorna uma String com o conteudo.
	  * Caso haja erro retorna um boolean com false.
	  * @name abreArquivo
	  * @access public
	  * @return caso erro boolean / caso sucesso String
	  */
	 function abreArquivo(){
	 	if ($this->valida()) {
			if (!$handle = fopen($this->getCaminho().$this->getArquivo(), 'r+')) {
			     echo "Erro abrindo arquivo (".$this->getCaminho().$this->getArquivo().")";
			     return false;
			}else{
				return $handle;
			}
	 	}
	 }
	 
	 /**
	  * M�todo
	  * Valida se o arquivo exite
	  * @name valida
	  * @access public
	  * @return boolean
	  */
	 function valida(){
	 	if (is_writable($this->getCaminho().$this->getArquivo()) && file_exists($this->getCaminho().$this->getArquivo())) {
	 		return true;
	 	} else {
	 		return false;
	 	}
	 }

	 /**
	  * M�todo
	  * Le o conteudo do arquivo aberto e o fecha em seguinda.
	  * @name ler
	  * @access public
	  * @return boolean 
	  */
	 function ler(){
	 	if($this->valida()){
	 		$rs = $this->abreArquivo();
			while (!feof ($rs)) {
				$arr	 		= fgets($rs, 4096);
				$this->conteudo .=  $arr;
			}
			$this->fechar();
			return true;
		}else {
			return false;
		}
	 }
	 
	 function txtExist($txt){
	 	return strpos($this->conteudo, $txt);
	 }

	 /**
	  * M�todo
	  * Subistitui $substiuir por $subistituto
	  * @name substitui
	  * @access public
	  * @param String $substiuir.
	  * @param String $subistituto.
	  * @return boolean 
	  */
	 function substitui($substiuir, $subistituto){
	 	$retorno = str_replace($substiuir, $subistituto, $this->conteudo);
	 	if($retorno){
	 		$this->conteudo = $retorno;
	 		return true;
	 	}else{
	 		return false;
	 	}
		
	 }
	 /**
	  * M�todo
	  * Exibe o texto aberto.
	  * @name exibir
	  * @return String.
	  */
	 function exibir(){
	 	return $this->conteudo;
	 }

	 /**
	  * M�todo
	  * Fecha o arquivo aberto pelo fopen.
	  * @name fechar
	  * @access public
	  * @return boolean
	  */
	 function fechar(){
	 	if($this->valida()){
			fclose($this->abreArquivo());
			return true;
		}else{
			return false;
		}
	 }
	 
 }

?>