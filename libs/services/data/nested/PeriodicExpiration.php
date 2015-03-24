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
 * This object captures the data required by the Point API in
 * order to associate an expiration to a PointRequestData.
 */
class PeriodicExpiration
{
	private $data = array();


	/**
	 * The type indicates when the object should expire.
	 * Valid types include: period, period_date and never.
	 * Period: represents a period of time after which the object should expire.
	 * Period_date: represents a period of time after which on a specific date the object should expire.
	 * Never: no expiration is specified.
	 * This field cannot be null.
	 * @return
	 */
	public function getType() { return $this->data['type']; }
	public function setType( $type ) { $this->data['type'] = $type; }


	/**
	 * The trigger indicates what represents the date from which the expiration will be calculated.
	 * Valid types include: earned and fixed.
	 * Earned: represents the date on which an object is earned in the engine (ex: points, rewards).
	 * Fixed: represents a fixed date based on a combination of the period and date fields.
	 * @return
	 */
	public function getTrigger() { return $this->data['trigger']; }
	public function setTrigger( $trigger ) { $this->data['trigger'] = $trigger; }


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
	 * When an object uses period_date expiration then this field should contain the date
	 * on which the object should expire after the period has elapsed. The definition of
	 * the period varies based on the type of trigger. See the examples below:
	 *
	 * 1) Using "earned" as a trigger and specifying a period of 6 months with a date of the
	 * 31st of December will result in the following: 6 months after the object was earned
	 * on the next 31st of December, expire the object.
	 *
	 * 2) Using "fixed" as a trigger and specifying a period of 3 months with a date of the
	 * 31st of December will result in the following: every 3 months on the 31st of the month
	 * (or the last day of the month if the month has less than 31 days), expire the object.
	 *
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