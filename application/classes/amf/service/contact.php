<?php

/**
 * Just a quick little test service
 *
 * @package AMF
 * @category Example
 * @author Lowgain
 */
class ContactVO{
	var $id;
	var $firstname;
	var $lastname;
	var $phone;
	var $email;
	var $_explicitType = "br.com.mystuff.model.entity.ContactVO";	
}
 
class AMF_Service_Contact{
	
	/**
	*
	* AMFPHP services are cool because they're just plain classes
	* and what you return gets serialized automatically!
	*
	* @return string
	*/
	public function getContacts()
	{
		$contacts = AR::factory('contact')->all();
		return $this->parseObj($contacts);
	}
	
	public function save($obj)
	{
		$contact = ($obj->id != 'NAN') ? AR::factory('contact')->find($obj->id) : new Contact();
		
		if($contact){
			$contact->firstname = $obj->firstname;
			$contact->lastname	= $obj->lastname;
			$contact->phone		= $obj->phone;
			$contact->email		= $obj->email;
			$contact->birthday	= $obj->birthday;
			$contact->save();
			
			$arr = array($contact);
			return $this->parseObj($arr);
		}
		
		return false;
	}
	
	public function remove($obj)
	{
		$contact = AR::factory('contact')->find($obj->id);
		
		if($contact){
			$contact->delete();
			return true;
		}
		
		return false;
	}
	
	public function search($searchItem)
	{
		$contact = AR::factory('contact')->find('all', array('conditions' => array("firstname LIKE '%".$searchItem."%' OR lastname LIKE '%".$searchItem."%' OR phone LIKE '%".$searchItem."%' ")));	
		return $this->parseObj($contact);
	}
	
	
	public function parseObj($contacts){
		$r = array();
		foreach($contacts as $contact){
			$c 				= new ContactVO();
			$c->id			= $contact->id;
			$c->firstname	= $contact->firstname;
			$c->lastname	= $contact->lastname;
			$c->phone		= $contact->phone;
			$c->email		= $contact->email;
			$c->birthday	= $contact->birthday;
			
			$r[] = $c;
		}
		return $r;
	}
}