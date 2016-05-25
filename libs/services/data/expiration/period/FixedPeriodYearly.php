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
 * Represents an object which expires on a fixed weekly interval.
 * For example:
 * - Yearly in January on the 20th at 13:00PM
 */
class FixedPeriodYearly
{
	private $data = array();


	/**
	 * The type of fixed period: yearly
	 * This field cannot be null.
	 * @return
	 */
	public function getType() { return 'yearly'; }


	/**
	 * The month indicates the month of the year on which the object should expire.
	 * Valid values range from 0 to 11 where 0 indicates January and 11 indicates December.
	 * This field cannot be null.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getMonth() { return $this->data['month']; }
	public function setMonth( $month ) { $this->data['month'] = $month; }


	/**
	 * The date indicates the day of the month on which the object should expire.
	 * Valid values range from 1 to 31 where 1 indicates the first day of the month.
	 * Note: if 31 is selected as a date on a month which contains less than 31 days,
	 * an error will be raised.
	 * This field cannot be null.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getDate() { return $this->data['date']; }
	public function setDate( $date ) { $this->data['date'] = $date; }


	/**
	 * The hour indicates the hour on which the object should expire.
	 * Valid values range from 0 to 23 where 0 indicates midnight.
	 * This field cannot be null.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getHour() { return $this->data['hour']; }
	public function setHour( $hour ) { $this->data['hour'] = $hour; }
	
	
	/**
	 * Returns the current model as an array ready to
	 * be json_encoded
	 */
	public function getJsonArray()
	{
		$json = $this->data;
		$json['type'] = $this->getType();
		return $json;
	}
}
?>