<?php
/*
 * Copyright (C) 2014-2015 Mambo Solutions Ltd.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/**
 * This object captures the data required by the User API in
 * order to associate an user details to a UserRequestData.
 */
class UserDetails
{
	private $data = array();
	
	/**
	 * The user's email address.
	 * @return
	 */
	public function getEmail() { return $this->data['email']; }
	public function setEmail( $email ) { $this->data['email'] = $email; }
	
	/**
	 * The name to be displayed when a user's information is being displayed.
	 * @return
	 */
	public function getDisplayName() { return $this->data['displayName']; }
	public function setDisplayName( $displayName ) { $this->data['displayName'] = $displayName; }
	
	/**
	 * The user's first name.
	 * @return
	 */
	public function getFirstName() { return $this->data['firstName']; }
	public function setFirstName( $firstName ) { $this->data['firstName'] = $firstName; }
	
	/**
	 * The user's last name.
	 * @return
	 */
	public function getLastName() { return $this->data['lastName']; }
	public function setLastName( $lastName ) { $this->data['lastName'] = $lastName; }
	
	/**
	 * The user's birthday.
	 * This is expected as a UTC timestamp in ISO 8601 format with 
	 * millisecond precision: YYYY-MM-DDTHH:MM:SS.MMMZ
	 * For example: 2013-01-20T20:43:24.094Z
	 * @return
	 */
	public function getBirthday() { return $this->data['birthday']; }
	public function setBirthday( $birthday ) { $this->data['birthday'] = $birthday; }
	
	/**
	 * The user's gender. Valid values include: M, F or U.
	 * M = Male, F = Female, U = Unknown.
	 * @return
	 */
	public function getGender() { return $this->data['gender']; }
	public function setGender( $gender ) { $this->data['gender'] = $gender; }
	
	/**
	 * Returns the current model as an array ready to
	 * be json_encoded
	 */
	public function getJsonArray()
	{
		return $this->data;
	}
}
?>