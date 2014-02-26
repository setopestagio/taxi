<?php

class Application_Model_Scheduling
{

	public function newSchedule($data)
	{
		try {
			if(strlen($data['name']) < 3 || strlen($data['cpf']) != 14 || $data['type_user'] == 0)
			{
				return false;
			}
			else
			{
				$scheduling = new Application_Model_DbTable_Scheduling();
				$data['str_hour'] = $this->returnSpecificHour($data['hour']);
				$schedulingNew = $scheduling->createRow($data);
				return $schedulingNew->save();
			}
		}catch(Zend_Exception $e) {
			return false;
		}
	}

	protected function amountHour()
	{
		$schedulingHourAllowed = new Application_Model_DbTable_SchedulingHourAllowed();
		$schedulingHourAllowedRow = $schedulingHourAllowed->fetchAll();
		return count($schedulingHourAllowedRow);
	}

	public function returnAllEvents()
	{
		$amountHour = $this->amountHour();
		$scheduling = new Application_Model_DbTable_Scheduling();
		$select = $scheduling->select()->setIntegrityCheck(false);
		$select	->from(array('scheduling'), array('events' => 'COUNT(*)', 'date') )
						->where('date > ?', new Zend_Db_Expr('NOW()'))
						->group('date')
						->having('events >= '.$amountHour);
		$schedulingRow = $scheduling->fetchAll($select);
		return $schedulingRow->toArray();
	}

	public function returnEvents($date)
	{
		$scheduling = new Application_Model_DbTable_Scheduling();
		$select = $scheduling->select()->setIntegrityCheck(false);
		$select	->from(array('s' => 'scheduling'), array('hour') )
						->where('s.date = ?',$date);
		$schedulingUserRow = $scheduling->fetchAll($select);
		return $schedulingUserRow->toArray();
	}

	public function newHour($data)
	{
		$data['hour'] = $data['hour'].':00';
		$schedulingHour = new Application_Model_DbTable_SchedulingHourAllowed();
		$schedulingHourNew = $schedulingHour->createRow($data);
		$newHour = $schedulingHourNew->save();
		$this->addHourHolidays($newHour,$data['hour']);
	}

	public function returnHour()
	{
		$schedulingHour = new Application_Model_DbTable_SchedulingHourAllowed();
		$select = $schedulingHour->select()->setIntegrityCheck(false);
		$select	->from(array('scheduling_hour_allowed'), array('id','hour' => 'TIME_FORMAT(hour,"%H:%i")') )
						->order('hour');
		return $schedulingHour->fetchAll($select);
	}

	public function deleteHour($id)
	{
		$schedulingHour = new Application_Model_DbTable_SchedulingHourAllowed();
		$schedulingHourRow = $schedulingHour->fetchRow($schedulingHour->select()->where('id = ?',$id) );
		$this->removeHourHolidays($id);
		$deletedHour = $schedulingHourRow->delete();
		return $deletedHour;
	}

	protected function addHourHolidays($newHour,$strHour)
	{
		$schedulingHoliday = new Application_Model_DbTable_SchedulingHoliday();
		$schedulingHolidayAll = $schedulingHoliday->fetchAll($schedulingHoliday->select()->where('date >= ?',new Zend_Db_Expr('NOW()')) );
		foreach($schedulingHolidayAll as $schedulingHoliday)
		{
			$scheduling = new Application_Model_DbTable_Scheduling();
			$schedulingNew = $scheduling->createRow();
			$schedulingNew->name = 'Recesso';
			$schedulingNew->date = $schedulingHoliday->date;
			$schedulingNew->hour = $newHour;
			$schedulingNew->str_hour = $strHour;
			$schedulingNew->save();
			unset($schedulingNew);
		}
	}

	protected function removeHourHolidays($hour)
	{
		$schedulingHoliday = new Application_Model_DbTable_SchedulingHoliday();
		$schedulingHolidayAll = $schedulingHoliday->fetchAll($schedulingHoliday->select()->where('date >= ?',new Zend_Db_Expr('NOW()')) );
		foreach($schedulingHolidayAll as $schedulingHoliday)
		{
			$scheduling = new Application_Model_DbTable_Scheduling();
			$schedulingRow = $scheduling->fetchRow($scheduling->select()->where('date = ?',$schedulingHoliday->date)->where('hour = ?',$hour));
			$schedulingRow->delete();
			unset($schedulingRow);
		}
	}

	public function returnSpecificHour($id)
	{
		$schedulingHour = new Application_Model_DbTable_SchedulingHourAllowed();
		$schedulingHourRow = $schedulingHour->fetchRow($schedulingHour->select()->where('id = ?',$id) );
		return $schedulingHourRow->hour;
	}

	public function rpHash($value) {
		$hash = 5381; 
    $value = strtoupper($value); 
    for($i = 0; $i < strlen($value); $i++) 
    { 
    	if($this->is_64bit())
    	{
      	$hash = ($this->leftShift32($hash, 5) + $hash) + ord(substr($value, $i)); 
    	}
    	else
    	{
    		$hash = (($hash << 5) + $hash) + ord(substr($value, $i));
    	}
    } 
    return $hash;
	}

	protected function leftShift32($number, $steps) 
	{ 
    $binary = decbin($number); 
    $binary = str_pad($binary, 32, "0", STR_PAD_LEFT); 
    $binary = $binary.str_repeat("0", $steps); 
    $binary = substr($binary, strlen($binary) - 32); 
    return ($binary{0} == "0" ? bindec($binary) : 
        -(pow(2, 31) - bindec(substr($binary, 1)))); 
	} 

	protected function is_64bit() 
	{
		$int = "9223372036854775807";
		$int = intval($int);
		if ($int == 9223372036854775807) 
		{
		  return true;
		}
		elseif ($int == 2147483647) 
		{
		  return false;
		}
		else 
		{
		  return "error";
		} 
	}

	public function getInfo($id)
	{
		$scheduling = new Application_Model_DbTable_Scheduling();
		$select = $scheduling->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'scheduling'), array('id', 'name', 'email', 'date') )
						->joinInner(array('h' => 'scheduling_hour_allowed'),'p.hour=h.id',array('hour' => 'TIME_FORMAT(h.hour,"%H:%i")') )
						->where('p.id = ?',$id);
		return $scheduling->fetchRow($select);
	}

	public function saveError()
	{
		try { 
			$schedulingError = new Application_Model_DbTable_SchedulingError();
			$schedulingErrorNew = $schedulingError->createRow();
			$schedulingErrorNew->error = 'Error Captcha';
			$schedulingErrorNew->date = new Zend_Db_Expr('NOW()');
			$schedulingErrorNew->save();
		}catch(Zend_Exception $e) {

		}
	}

	public function returnEventsCalendar()
	{
		$scheduling = new Application_Model_DbTable_Scheduling();
		$select = $scheduling->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'scheduling'), array('title' => 'name', 'start' => 'CONCAT(date," ",p.str_hour)') )
						->where('date > DATE_SUB(NOW(),INTERVAL 1 MONTH)');
		$schedulingAll = $scheduling->fetchAll($select);
		return $schedulingAll->toArray();
	}

	public function newAbsence($data)
	{
		try{
			$data['date'] =  Application_Model_General::dateToUs($data['date']);
			$schedulingHoliday = new Application_Model_DbTable_SchedulingHoliday();
			$schedulingHolidayRow = $schedulingHoliday->fetchRow($schedulingHoliday->select()->where('date = ?',$data['date']));
			if(!count($schedulingHolidayRow))
			{
				$schedulingHolidayNew = $schedulingHoliday->createRow($data);
				$schedulingHolidayNew->save();

				$schedulingHour = new Application_Model_DbTable_SchedulingHourAllowed();
				$schedulingHourRow = $schedulingHour->fetchAll();
				foreach($schedulingHourRow as $hour)
				{
					$scheduling = new Application_Model_DbTable_Scheduling();
					$schedulingNew = $scheduling->createRow();
					$schedulingNew->name = $data['name'];
					$schedulingNew->date = $data['date'];
					$schedulingNew->hour = $hour->id;
					$schedulingNew->str_hour = $this->returnSpecificHour($hour->id);
					$schedulingNew->save();
					unset($schedulingNew);
					unset($scheduling);
				}
				return true;
			}
		}catch(Zend_Exception $e) {
			return false;
		}
	}

	public function returnReport($startDate,$endDate)
	{
		$scheduling = new Application_Model_DbTable_Scheduling();
		$select = $scheduling->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'scheduling'), array('name', 'date', 'email') )
						->joinInner(array('h' => 'scheduling_hour_allowed'),'h.id=p.hour',array('hour' => 'TIME_FORMAT(h.hour,"%H:%i")') )
						->where('date >= ?',$startDate)
						->where('date <= ?',$endDate)
						->where('p.name NOT LIKE "Recesso"')
						->order('date ASC')
						->order('hour ASC');
		return $scheduling->fetchAll($select);
	}

	public function searchByCPF($cpf)
	{
		$scheduling = new Application_Model_DbTable_Scheduling();
		$select = $scheduling->select()->setIntegrityCheck(false);
		$select	->from(array('p' => 'scheduling'), array('id', 'name', 'email', 'date', 'str_hour') )
						->where('p.cpf = ?',$cpf)
						->where('p.date >= ?',new Zend_Db_Expr('NOW()'));
		return $scheduling->fetchAll($select);
	}

	public function remove($id)
	{
		$scheduling = new Application_Model_DbTable_Scheduling();
		$schedulingRow = $scheduling->fetchRow($scheduling->select()->where('id = ?',$id) );
		return $schedulingRow->delete();
	}

	public function reschedule($id, $hour, $date)
	{
		$scheduling = new Application_Model_DbTable_Scheduling();
		$schedulingOld = $scheduling->fetchRow($scheduling->select()->where('id = ?',$id));
		if($this->remove($id))
		{
			$schedulingNew = $scheduling->createRow();
			$schedulingNew->name = $schedulingOld->name;
			$schedulingNew->cpf = $schedulingOld->cpf;
			$schedulingNew->email = $schedulingOld->email;
			$schedulingNew->phone = $schedulingOld->phone;
			$schedulingNew->type_user = $schedulingOld->type_user;
			$schedulingNew->date = $date;
			$schedulingNew->hour = $schedulingOld->hour;
			$schedulingNew->str_hour = $this->returnSpecificHour($hour);
			return $schedulingNew->save();
		}
		return false;
	}

}

