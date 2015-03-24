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
 * This object captures the data required by the Coupon API in
 * order to associate an expiry to a CouponRequestData.
 */
class SimpleExpiration
{
	private $data = array();


	/**
	 * The type indicates when the object should expire.
	 * Valid types include: period, date and never.
	 * Period: represents a period of time after which the object should expire.
	 * Date: represents a specific date on which the object should expire.
	 * Never: no expiration is specified.
	 * This field cannot be null.
	 * @return
	 */
	public function getType() { return $this->data['type']; }
	public function setType( $type ) { $this->data['type'] = $type; }


	/**
	 * Defines a period of time after which an object should expire.
	 * See the {@link Period} object for more information.
	 * @return
	 */
	public function getPeriod() { return $this->data['period']; }
	public function setPeriod( $period ) {
		if( !is_null( $period ) && ( $period instanceof Period ) )
			$this->data['period'] = $period->getJsonArray();
		else
			$this->data['period'] = $period;
	}


	/**
	 * If we are using an object which expires on a specific date, then this
	 * field will contain the date on which the object will expire.
	 * This will be a UTC timestamp in ISO 8601 format with
	 * millisecond precision: YYYY-MM-DDTHH:MM:SS.MMMZ<br>
	 * For example: 2013-01-20T20:43:24.094Z
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
		return $this->data;
	}
}
?>