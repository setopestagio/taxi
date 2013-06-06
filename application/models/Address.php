<?php

class Application_Model_Address
{

	public function newAddress($data)
	{
		$address = new Application_Model_DbTable_Address();
		$newAddress = $address->createRow();
		$newAddress->address = $data['address'];
		$newAddress->number = $data['number'];
		$newAddress->apartament = $data['apartament'];
		$newAddress->neighborhood = $data['neighborhood'];
		$newAddress->city = $data['address_city'];
		$newAddress->zipcode = $data['zipcode'];
		return $newAddress->save();
	}

	public function editAddress($data,$addressId)
	{
		$address = new Application_Model_DbTable_Address();
		$editAddress = $address->fetchRow($address->select()->where('id = ?', $addressId));
		$editAddress->id = $addressId;
		$editAddress->address = $data['address'];
		$editAddress->number = $data['number'];
		$editAddress->apartament = $data['apartament'];
		$editAddress->neighborhood = $data['neighborhood'];
		$editAddress->city = $data['address_city'];
		$editAddress->zipcode = $data['zipcode'];
		return $editAddress->save();
	}

}

