<?php

class User {
	//String
  public $userCode;
	
	//String
  public $name;
	
	//String
	public $surname1;
	
	//String
  public $surname2;
	
	//String
	public $phone;
	
	//Array of UserEntityEmail
	public $entities;
	
	//Enum (String) = [USER, ADMIN_FUNCTIONAL, ADMIN_INFRASTRUCTURE, ADMIN_GLOBAL]
	public $role;
	
	//UserCmis
	public $cmis;
	
	//Enum (String) = [EUROPE_MADRID, EUROPE_LONDON, etc.]
	public $timezone;
	
	//Enum (String) = [ES, EN, FR, CA, EU]
	public $locale;
	
	//Enum (String) = [HIGH, MEDIUM, LOW, NEWSLETTER]
	public $notificationsLevel;
	
	//Long
	public $newsletterFrequencyDays;
	
	//Boolean
	public $isSender;
	
	//Boolean
	public $canSendAllEntity;
	
	//Boolean
	public $canViewWorkflow;
	
	//Boolean
	public $isServerSign;
	
	//String
	public $serverSignPassword;
	
	//String
	public $serverSignAlias;
	
	//Array of String
	public $numberIds;
	
	//Boolean
	public $isExternalSign;
	
	//Enum (String) = [PLATFORM, FORTRESS, COSIGN, OTPSMS, WEB]
	public $defaultExternalSign;
}

?>