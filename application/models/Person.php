<?php

class Application_Model_Person
{

	public function newPerson($data, $addressId)
	{
		$person = new Application_Model_DbTable_Person();
		$newPerson = $person->createRow();
		$newPerson->name = $data['name'];
		$newPerson->address = $addressId;
		$newPerson->phone = $data['phone'];
		$newPerson->mobile = $data['mobile'];
		$newPerson->email = $data['email'];
		$newPerson->rg = $data['rg'];
		$newPerson->rg_issuer = $data['rg_issuer'];
		$newPerson->cpf = $data['cpf'];
		$newPerson->cnh = $data['cnh'];
		$newPerson->cnh_issuer = $data['cnh_issuer'];
		$newPerson->iapas = $data['iapas'];
		$newPerson->voter = $data['voter'];
		$newPerson->voter_zone = $data['voter_zone'];
		$newPerson->army = $data['army'];
		$newPerson->army_issuer = $data['army_issuer'];
		return $newPerson->save();
	}

	public function editPerson($data, $personId)
	{
		$person = new Application_Model_DbTable_Person();
		$editPerson = $person->fetchRow($person->select()->where('id = ?',$personId));
		$editPerson->id = $personId;
		$address = new Application_Model_Address();
		$address->editAddress($data,$editPerson->address);
		$editPerson->name = $data['name'];
		$editPerson->phone = $data['phone'];
		$editPerson->mobile = $data['mobile'];
		$editPerson->email = $data['email'];
		$editPerson->rg = $data['rg'];
		$editPerson->rg_issuer = $data['rg_issuer'];
		$editPerson->cpf = $data['cpf'];
		$editPerson->cnh = $data['cnh'];
		$editPerson->cnh_issuer = $data['cnh_issuer'];
		$editPerson->iapas = $data['iapas'];
		$editPerson->voter = $data['voter'];
		$editPerson->voter_zone = $data['voter_zone'];
		$editPerson->army = $data['army'];
		$editPerson->army_issuer = $data['army_issuer'];
		return $editPerson->save();
	}
}

