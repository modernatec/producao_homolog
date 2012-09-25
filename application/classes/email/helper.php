<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Classe para enviar email
 *
 * @package    Kohana
 * @category   Base
 * @author     Renato Ibiapina
 */
class Email_Helper
{        
    public $userInfo;
    public $assunto;
    public $mensagem;
    
    public function enviaEmail($debug=false){
        if(!$debug)
        {
            $mailer = Email::connect();   

            $message = Swift_Message::newInstance()

                ->setSubject($this->assunto)

                ->setFrom(array('editorial_tec15@moderna.com.br' => 'Santillana'))

                ->setTo(array($this->userInfo->email => $this->userInfo->nome))

                ->setBody($this->mensagem, 'text/html');

                /*And optionally an alternative body
                ->addPart('<q>Here is the message itself</q>', 'text/html');

                //// Optionally add any attachments
                ->attach(Swift_Attachment::fromPath('my-document.pdf')*/				  
            try{
                $mail = $mailer->send($message);
            }catch(Exception $e){
                print $e->getMessage();
                //exit;
            }
        }else{
            print "<pre>";
            var_dump($this);
            print "</pre>";
        }
    }
}
?>
