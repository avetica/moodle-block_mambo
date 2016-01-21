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
 * Represents an object which expires on a fixed daily interval.
 * For example:
 * - Daily at 10:00AM
 */
class FixedPeriodDaily
{
	private $data = array();


	/**
	 * The type of fixed period: daily
	 * This field cannot be null.
	 * @return
	 */
	public function getType() { return 'daily'; }


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
		$this->data['type'] = $this->getType();
		return $this->data;
	}
}
?>