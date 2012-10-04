<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Funções uteis e genéricas estáticas
 *
 * @package    Kohana
 * @category   Base
 * @author     Renato Ibiapina
 */
class Utils_Helper
{  
    public static function mensagens($acao,$msg='')
    {
        $session = Session::instance();
        switch($acao)
        {
            case 'add':
                if($msg!='')
                {
                    $oldMsg = array();
                    if($session->get('mensagens')!='')
                    {
                        $oldMsg = json_decode($session->get('mensagens'));
                    }
                    $oldMsg[] = $msg;
                    $session->set('mensagens',json_encode($oldMsg));
                }
                break;
            case 'print':
                $msg = $session->get('mensagens');
                $session->delete('mensagens');
                return $msg;
                break;
        }        
    }
    
    public static function data($dt,$format='d/m/Y')
    {
        $data = new DateTime($dt);
        return date_format($data,$format);
    }
    
    public static function limparStr($str)
    {
        $str = strtolower($str);
        $a = array('â','ã','à','á','ä','ê','è','é','ë','î','í','ì','ï','ô','õ','ò','ó','ö','û','ú','ù','ü','ç',' ','+');
        $b = array('a','a','a','a','a','e','e','e','e','i','i','i','i','o','o','o','o','o','u','u','u','u','c','_','_');        
        return str_replace($a,$b,$str);
    }
    
    public static function debug($var,$exit=true)
    {
        print '<pre>';
        print_r($var);
        print '</pre>';
        if($exit) exit;
    }
    
    public static function uploadNoAssoc($file,$pasta,$tipagem=array('jpg','jpeg','gif','png'))
    {
        $erro = array(
            1=>'Tipo incorreto de arquivo',
            2=>'Erro ao fazer o upload do arquivo',
        );

        if(Upload::type($file,$tipagem))
        {
            $fName = Utils_Helper::limparStr($file['name']);
            $basedir = 'public/upload/'.$pasta.'/';
            $rootdir = DOCROOT.$basedir;
            $ext = explode(".",$fName);
            $ext = end($ext);                
            $nomeArquivo = str_replace(".$ext","",$fName);

            $fileName = $nomeArquivo.'_'.(time()).'.'.$ext;
            if(Upload::save($file,$fileName,$rootdir,0777))
            {
                return $basedir.$fileName;
            }else
            {
                return 2;
            }
        }else
        {
            return 1;
        }
    }
    
    public static function getExt($filename){
        $ext = explode('.',$filename);
        return end($ext);
    }
    
    public static function getDefaultExtPreview()
    {   
        return array(
            'image'=>array('jpg','jpeg','gif','png'),
            'audio'=>array('mp3','wav'),
            'video'=>array('mp4','avi','ogg'),
            'pdf'=>array('pdf')
        );
    }
    
    public static function preview($file){
        
        $has_preview = false;
        $ext = self::getExt($file->uri);
        foreach(self::getDefaultExtPreview() as $key=>$arr){
            if(in_array($ext,$arr)){
                $has_preview = true;
                break;
            }
        }        
        if($has_preview){
            if($ext=='pdf'){
                return '<a href="'.URL::base().$file->uri.'" target="_blank" title="Preview" class="preview floatNone">Preview</a></li>';
            }else{
                return '<a href="javascript:openPop(\'/admin/files/preview/'.$file->id.'\');" title="Preview" class="preview floatNone">Preview</a></li>';
            }
        }else{
            return '';
        }
    }
    
    public static function getSize($val)
    {
        if($val < 1024){
            return $val.' b';
        }else{
            $kbval = (int)($val / 1024);
            if($kbval < 1024){
                return $kbval.' kb';
            }else{
                $mbval = (int)($kbval / 1024);
                if($mbval < 1024){
                    return $mbval.' mb';
                }else{
                    $gbval = (int)($kbval / 1024);
                    return $gbval.' gb';
                }
            }
        }
    }
}
?>
