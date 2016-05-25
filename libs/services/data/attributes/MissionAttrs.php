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
 * order to create / update missions
 */
class MissionAttrs
{
	private $data = array();
	
	/**
	 * The type of attribute
	 * @return
	 */
	public function getType() { return 'mission'; }

	/**
	 * The type of the mission. This will be either: linear or random.
	 * See the mission page in administration panel for more information.
	 * @return
	 */
	public function getMissionType() { return $this->data['missionType']; }
	public function setMissionType( $missionType ) { $this->data['missionType'] = $missionType; }

	/**
	 * The list of rewards from which the mission is composed. See the mission
	 * page in administration panel for more information.
	 * @return
	 */
	public function getRewardIds() { return $this->data['rewardIds']; }
	public function setRewardIds( array $rewardIds ) { $this->data['rewardIds'] = $rewardIds; }
	public function addRewardId( $id ) { 
		if( !isset( $this->data['rewardIds'] ) )
			$this->data['rewardIds'] = array();
		array_push( $this->data['rewardIds'], (string) $id );
	}
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonArray()
	{
		$json = $this->data;
		$json['type'] = $this->getType();
		return $json;
	}
}
?>