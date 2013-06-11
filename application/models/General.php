<?php

class Application_Model_General
{

	public static function dateToUs($date)
	{
		$aux = explode('/', $date);
		return $aux[2].'-'.$aux[1].'-'.$aux[0];
	}

	public static function dateToBr($date)
	{
		$aux = explode('-', $date);
		$date = $aux[2].'/'.$aux[1].'/'.$aux[0];
		if($date == '00/00/0000')
			return '';
		return $date;
	}

}

