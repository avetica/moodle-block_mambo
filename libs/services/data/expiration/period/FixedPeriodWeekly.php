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
 * - Weekly on Tuesday at 11:00AM
 */
class FixedPeriodWeekly
{
	private $data = array();


	/**
	 * The type of fixed period: weekly
	 * This field cannot be null.
	 * @return
	 */
	public function getType() { return 'weekly'; }


	/**
	 * The day indicates the day of the week on which the object should expire.
	 * Valid values range from 0 to 6 where 0 indicates Monday and 6 indicates Sunday.
	 * This field cannot be null.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getDay() { return $this->data['day']; }
	public function setDay( $day ) { $this->data['day'] = $day; }


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