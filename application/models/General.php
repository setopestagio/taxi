<?php

class Application_Model_General
{

	public static function dateToUs($date)
	{
    if($date == '0000-00-00' || $date == '')
      return new Zend_Db_Expr('NULL');
		$aux = explode('/', $date);
		return $aux[2].'-'.$aux[1].'-'.$aux[0];
	}

	public static function dateToBr($date)
	{
    if($date == '0000-00-00' || $date == '')
      return '';
		$aux = explode('-', $date);
		$date = $aux[2].'/'.$aux[1].'/'.$aux[0];
		return $date;
	}

	public static function cutString($texto, $quantidade_caracteres, $string_complemento='')
	{
   $string_sem_espacos = trim($texto);
   $recorte_string = "";
   for ($i = 0;; $i++)
   {
    if (($quantidade_caracteres + $i) <= strlen($texto))
    {              
     $string_recortada = substr($string_sem_espacos, 0, $quantidade_caracteres + $i);
     if(substr($string_recortada, -1) == " ")
     {
      $recorte_string = substr($string_recortada, 0, -1) ."".$string_complemento;
      break;
     }
    }
    elseif (($quantidade_caracteres + $i) > strlen($texto))
    {
     $recorte_string = $texto;
     break;
    }
   }
   return $recorte_string;
  }

  public static function resumeString($texto, $limite) 
  {
		$str = Application_Model_General::cutString($texto,$limite);
		return str_replace($str,'', $texto);
	}

  public static function removeAccents($title)
  {
    $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
    $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");
    return str_replace($search, $replace, $title);
  }
  public static function formatLongText($text,$start,$finished)
  {
    return ltrim(substr($text, $start, $finished));
  }
}

