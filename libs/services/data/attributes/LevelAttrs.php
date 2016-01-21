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
 * order to create / update levels
 */
class LevelAttrs
{
	private $data = array();
	
	/**
	 * The type of attribute
	 * @return
	 */
	public function getType() { return 'level'; }

	/**
	 * The total number of points a user must have to unlock the level.
	 * See the level page in administration panel for more information.
	 * @return
	 */
	public function getPoints() { return $this->data['points']; }
	public function setPoints( array $points ) {
		if( is_null( $points ) ) {
			$this->data['points'] = $points;
			return;
		}
		
		$this->data['points'] = array();
		foreach( $points as $point ) {
			array_push( $this->data['points'], $point->getJsonArray() );
		}
	}
	public function addPoints( SimplePoint $point ) {
		if( !isset( $this->data['points'] ) )
			$this->data['points'] = array();
		
		if( !is_null( $point ) )
			array_push( $this->data['points'], $point->getJsonArray() );
		else
			array_push( $this->data['points'], $point );
	}
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonArray()
	{
		$this->data['type'] = 'level';
		return $this->data;
	}
}
?>