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
 * Represents an object which expires on a fixed time interval.
 * For example:
 * - Hourly
 * - Daily at 10:00AM
 * - Weekly on Tuesday at 11:00AM
 * - Monthly on the 12th at 12:00PM
 * - Yearly in January on the 20th at 13:00PM
 */
class FixedPeriodExpiration
{
	private $data = array();


	/**
	 * The type of expiration: fixed_period
	 * This field cannot be null.
	 * @return
	 */
	public function getType() { return 'fixed_period'; }


	/**
	 * The period contains the type of period that we wish to use.
	 * Valid periods include: hourly, daily, weekly, monthly and yearly.
	 * This field cannot be null.
	 * @return
	 */
	public function getPeriod() { return $this->data['period']; }
	public function setPeriod( $period ) {
		if( !is_null( $period ) && 
			( $period instanceof FixedPeriodHourly ||
			  $period instanceof FixedPeriodDaily ||
			  $period instanceof FixedPeriodWeekly ||
			  $period instanceof FixedPeriodMonthly ||
			  $period instanceof FixedPeriodYearly ) )
			$this->data['period'] = $period->getJsonArray();
		else
			$this->data['period'] = $period;
	}
	
	
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