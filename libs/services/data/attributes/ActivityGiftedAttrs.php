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
 * Defines activity attributes specific to gifted.
 */
class ActivityGiftedAttrs
{
	private $data = array();
	
	/**
	 * The type of attribute
	 * @return
	 */
	public function getType() { return 'gifted'; }

	/**
	 * The Unique User ID of the user to whom the points are being gifted.
	 * @return
	 */
	public function getTargetUuid() { return $this->data['targetUuid']; }
	public function setTargetUuid( $targetUuid ) { $this->data['targetUuid'] = (string) $targetUuid; }

	/**
	 * The reason associated to the gifted activity. This can be used for the
	 * source of the gift to provide a message / reason to the target of the gift
	 * as to why they are being gifted with points.
	 * @return
	 */
	public function getReason() { return $this->data['reason']; }
	public function setReason( $reason ) { $this->data['reason'] = (string) $reason; }

	/**
	 * The points associated with this gifted activity.
	 */
	public function getPoints() { return $this->data['points']; }
	public function setPoints( array $points ) { $this->data['points'] = $points; }
	public function addPoints( SimplePoint $point ) {
		if( !isset( $this->data['points'] ) ) {
			$this->data['points'] = array();
		}
		array_push( $this->data['points'], $point );
	}
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonArray()
	{
		$json = $this->data;
		$json['type'] = $this->getType();
		
		if( isset( $json['points'] ) && !is_null( $json['points'] ) ) {
			$pointsArr = array();
			foreach( $json['points'] as $point ) {
				array_push( $pointsArr, $point->getJsonArray() );
			}
			$json['points'] = $pointsArr;
		}
		
		return $json;
	}
}
?>