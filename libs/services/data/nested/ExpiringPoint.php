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
 * This object captures the data required by the different
 * data request objects which are associated to points and
 * which supply the expiration data
 */
class ExpiringPoint
{
	private $data = array();


	/**
	 * The ID of the points to use with this object.
	 * This field cannot be null.
	 * @return
	 */
	public function getPointId() { return $this->data['pointId']; }
	public function setPointId( $pointId ) { $this->data['pointId'] = (string) $pointId; }


	/**
	 * The number of points, of the type specified by pointId, associated with the object.
	 * This field cannot be null.
	 * @return
	 */
	public function getPoints() { return $this->data['points']; }
	public function setPoints( $points ) { $this->data['points'] = $points; }


	/**
	 * If the points are expirable then this field can be used to override
	 * the points default expiration settings.
	 * See the {@link NeverExpiration}, {@link FixedPeriodExpiration} or 
	 * {@link VariablePeriodExpiration} objects for more information.
	 * @return
	 */
	public function getExpiration() { return $this->data['expiration']; }
	public function setExpiration( $expiration ) { $this->data['expiration'] = $expiration; }
	
	/**
	 * Returns the current model as an array ready to
	 * be json_encoded
	 */
	public function getJsonArray()
	{
		$json = $this->data;
		
		if( isset( $json['expiration'] ) && !is_null( $json['expiration'] ) ) {
			$json['expiration'] = $json['expiration']->getJsonArray();
		}
		
		return $json;
	}
}
?>