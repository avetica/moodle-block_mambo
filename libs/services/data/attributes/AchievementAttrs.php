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
 * This object captures the data required by the Reward API in
 * order to create / update achievements
 */
class AchievementAttrs
{
	private $data = array();
	
	/**
	 * The type of attribute
	 * @return
	 */
	public function getType() { return 'achievement'; }

	/**
	 * The ID of the behaviour that must be performed by the user in order to
	 * unlock the achievement. Each behaviour has a corresponding behaviourId.
	 * See the achievement page in administration panel for more information.
	 * @return
	 */
	public function getBehaviourId() { return $this->data['behaviourId']; }
	public function setBehaviourId( $behaviourId ) { $this->data['behaviourId'] = (string) $behaviourId; }

	/**
	 * The total number of timers a user must repeat the behaviour in
	 * order to unlock the achievement. See the achievement page in
	 * administration panel for more information.
	 * @return
	 */
	public function getTimes() { return $this->data['times']; }
	public function setTimes( $times ) { $this->data['times'] = $times; }

	/**
	 * If the achievement is expirable then this field should contain the general
	 * expiration information. See the {@link ExpirationData} object for more information.
	 * Achievements support the following types of reset: never, fixed_period and variable_period
	 * @return
	 */
	public function getExpiration() { return $this->data['expiration']; }
	public function setExpiration( $expiration ) {
		if( !is_null( $expiration ) && 
			( $expiration instanceof NeverExpiration ||
			  $expiration instanceof FixedPeriodExpiration ||
			  $expiration instanceof VariablePeriodExpiration ) )
			$this->data['expiration'] = $expiration->getJsonArray();
		else
			$this->data['expiration'] = $expiration;
	}

	/**
	 * Get the count limit which is used to limit the number of times the user
	 * can unlock this particular achievement
	 * @return
	 */
	public function getCountLimit() { return $this->data['countLimit']; }
	public function setCountLimit( $countLimit ) { $this->data['countLimit'] = $countLimit; }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonArray()
	{
		$this->data['type'] = 'achievement';
		return $this->data;
	}
}
?>