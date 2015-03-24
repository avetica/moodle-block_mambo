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
 * This object captures the data required by the Event API in
 * order to track a behaviour performed by a specific user.
 */
class LeaderboardRequestData
{
	private $data = array();

	/**
	 * The name of the leaderboard. See the leaderboard page in
	 * administration panel for more information.
	 * @return
	 */
	public function getName() { return $this->data['name']; }
	public function setName( $name ) { $this->data['name'] = $name; }

	/**
	 * The ID of the behaviour associated to this leaderboard.
	 * See the leaderboard page in administration panel for more information.
	 * @return
	 */
	public function getBehaviourId() { return $this->data['behaviourId']; }
	public function setBehaviourId( $behaviourId ) { $this->data['behaviourId'] = (string )$behaviourId; }

	/**
	 * For leaderboards based on simple behaviours, this flag indicates whether the flexible
	 * behaviours associated to the simple one should also be counted in the points for this
	 * leaderboard.
	 * See the leaderboard page in administration panel for more information.
	 * @return
	 */
	public function getCountFlex() { return $this->data['countFlex']; }
	public function setCountFlex( $countFlex ) { $this->data['countFlex'] = $countFlex; }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		return json_encode( $this->data );
	}
}
?>