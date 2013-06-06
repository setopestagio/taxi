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
		return $aux[2].'/'.$aux[1].'/'.$aux[0];
	}

}

