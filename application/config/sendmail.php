<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	"Timeout"		=> 10,
	"MessageID"		=> '',
	"SMTPAuth"		=> true,
	"SMTPSecure"	=> '',
	"Host" 			=> "smtp.moderna.com.br",
	"Port" 			=> 25, // 587 novo padrao // padrao antigo 25
	"Username"		=> "renato.rocha@moderna.com.br", // "mail@umstudiohomolog.com.br"
	"Password"		=> "moderna@09",
	"CharSet" 		=> "utf-8",
	"Language"		=> "br",
	"WordWrap"		=> 0,
	"SMTPDebug"		=> "true",
	"crlf"			=> "\r\n", // Windows \r\n | linux \r
);