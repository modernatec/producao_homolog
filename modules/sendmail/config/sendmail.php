<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	"Timeout"		=> 10,
	"MessageID"		=> '',
	"SMTPAuth"		=> true,
	"SMTPSecure"	=> '',
	"Host" 			=> "smtp.seudominio.com.br",
	"Port" 			=> 587, // novo padrao 587 | padrao antigo 25
	"Username"		=> "seuusuario",
	"Password"		=> "suasenha",
	"CharSet" 		=> "utf-8",
	"Language"		=> "br",
	"WordWrap"		=> 0,
	"SMTPDebug"		=> "false",
	"crlf"			=> "\r", // Windows \r\n | linux \r
);