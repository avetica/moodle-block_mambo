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
 * This class encapsulates data related to a site's security settings.
 */
class Security
{
	private $data = array();


	/**
	 * The Activity JavaScript Security object is used to define which of the activities
	 * can be created through the JavaScript API.
	 * @return
	 */
	public function getJsActivities() { return $this->data['jsActivities']; }
	public function setJsActivities( $jsActivities ) { $this->data['jsActivities'] = $jsActivities; }


	/**
	 * The User JavaScript Security object is used to define which of the User
	 * CRUD APIs can be called through the JavaScript API.
	 * @return
	 */
	public function getJsUsers() { return $this->data['jsUsers']; }
	public function setJsUsers( $jsUsers ) { $this->data['jsUsers'] = $jsUsers; }

	
	/**
	 * Returns the current model as an array ready to
	 * be json_encoded
	 */
	public function getJsonArray()
	{
		$json = $this->data;
		
		if( isset( $json['jsActivities'] ) && !is_null( $json['jsActivities'] ) ) {
			$json['jsActivities'] = $json['jsActivities']->getJsonArray();
		}
		
		if( isset( $json['jsUsers'] ) && !is_null( $json['jsUsers'] ) ) {
			$json['jsUsers'] = $json['jsUsers']->getJsonArray();
		}
		
		return $json;
	}
}
?>