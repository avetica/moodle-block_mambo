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
class LeaderboardRequestData extends AbstractHasTagRequestData
{

	/**
	 * The name of the leaderboard. See the leaderboard page in
	 * administration panel for more information.
	 * @return
	 */
	public function getName() { return $this->data['name']; }
	public function setName( $name ) { $this->data['name'] = $name; }

	/**
	 * This must contain the list of the IDs of the points which must
	 * be added together for this leaderboard score.
	 * @return
	 */
	public function getPointIds() { return $this->data['pointIds']; }
	public function setPointIds( array $pointIds ) { $this->data['pointIds'] = $pointIds; }
	public function addPoints( SimplePoint $point ) {
		if( !isset( $this->data['pointIds'] ) )
			$this->data['pointIds'] = array();
		
		if( !is_null( $point ) )
			array_push( $this->data['pointIds'], $point->getJsonArray()['pointId'] );
		else
			array_push( $this->data['pointIds'], $point );
	}

	/**
	 * The attributes of the leaderboard. There are currently two types of
	 * attributes: LeaderboardBehaviourAttrs and LeaderboardPointAttrs.
	 * @return
	 */
	public function getAttrs() { return $this->data['attrs']; }
	public function setAttrs( $attrs ) {
		if( !is_null( $attrs ) )
			$this->data['attrs'] = $attrs->getJsonArray();
		else
			$this->data['attrs'] = $attrs;
	}
}
?>