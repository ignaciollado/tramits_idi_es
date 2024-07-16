<?php

class AddresseeUserEntity {
	//String
	public $jobCode;
	
	//String
	public $groupCode;
	
	//Enum (String) = [SIGN, APPROVAL]
	public $action;

	//String by Nacho
	public $userCode;
	
	//String by Nacho
	public $entityCode;

	//String by Nacho
	public $userPhone;
	
	//Enum (String) = [NEW, READ, SIGNED, APPROVAL, REJECT, NO_ACTION]
	public $status;
	
	//AddresseeActionInfo
	public $actionInfo;
	
	//StampPosition
	//public $stampPosition;
}

?>