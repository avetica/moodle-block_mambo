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
 * Represents an object which expires on a variable time interval
 * which begins from the date the object was created.
 * For example:
 * - 2 hours after creation
 * - 3 days after creation
 * - 4 weeks after creation
 * - 5 months after creation
 * - 6 years after creation
 */
class VariablePeriodExpiration
{
	private $data = array();


	/**
	 * The type of expiration: variable_period
	 * This field cannot be null.
	 * @return
	 */
	public function getType() { return 'variable_period'; }


	/**
	 * Defines a period of time after which an object should expire.
	 * See the {@link VariablePeriod} object for more information.
	 * @return
	 */
	public function getPeriod() { return $this->data['period']; }
	public function setPeriod( $period ) {
		if( !is_null( $period ) && ( $period instanceof VariablePeriod ) )
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