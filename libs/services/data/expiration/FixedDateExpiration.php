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
 * Represents an object which expires on a fixed date.
 * For example: 24/01/2015
 */
class FixedDateExpiration
{
	private $data = array();


	/**
	 * The type of expiration: fixed_date
	 * This field cannot be null.
	 * @return
	 */
	public function getType() { return 'fixed_date'; }


	/**
	 * This field contains the exact expiration date of the object.
	 * This will be a UTC timestamp in ISO 8601 format with
	 * millisecond precision: YYYY-MM-DDTHH:MM:SS.MMMZ<br>
	 * For example: 2013-01-20T20:43:24.094Z.MMMZ<br>
	 * This field cannot be null.
	 * @return
	 */
	public function getDate() { return $this->data['date']; }
	public function setDate( $date ) { $this->data['date'] = $date; }
	
	
	/**
	 * Returns the current model as an array ready to
	 * be json_encoded
	 */
	public function getJsonArray()
	{
		$this->data['type'] = $this->getType();
		return $this->data;
	}
}
?>