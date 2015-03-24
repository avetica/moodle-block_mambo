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
 * This object captures the data required by the Point API in
 * order to create / update points.
 */
class PointRequestData
{
	private $data = array();
	
	/**
	 * Whether the image associated to the Point should be removed
	 * @return boolean removeImage
	 */
	public function getRemoveImage() { return $this->data['removeImage']; }
	public function setRemoveImage( $removeImage ) { $this->data['removeImage'] = $removeImage; }

	/**
	 * The name of the point.
	 * @return
	 */
	public function getName() { return $this->data['name']; }
	public function setName( $name ) { $this->data['name'] = $name; }

	/**
	 * This flag indicates whether this point is active.
	 * @return
	 */
	public function getActive() { return $this->data['active']; }
	public function setActive( $active ) { $this->data['active'] = $active; }

	/**
	 * Indicates whether the user can have negative points of this type.
	 * If the points cannot be negative then transactions will be checked
	 * to ensure they don't cause the user to go negative.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getNegativeable() { return $this->data['negativeable']; }
	public function setNegativeable( $negativeable ) { $this->data['negativeable'] = $negativeable; }

	/**
	 * Indicates whether the points can be redeemed in exchange for items.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getRedeemable() { return $this->data['redeemable']; }
	public function setRedeemable( $redeemable ) { $this->data['redeemable'] = $redeemable; }

	/**
	 * Indicates whether the points can be gifted to other users.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getGiftable() { return $this->data['giftable']; }
	public function setGiftable( $giftable ) { $this->data['giftable'] = $giftable; }

	/**
	 * Indicates whether the points can be used as a bounty which will then
	 * be given to the user who meets the bounty's requirements.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getBountiable() { return $this->data['bountiable']; }
	public function setBountiable( $bountiable ) { $this->data['bountiable'] = $bountiable; }

	/**
	 * Indicates whether the points expire.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getExpirable() { return $this->data['expirable']; }
	public function setExpirable( $expirable ) { $this->data['expirable'] = $expirable; }

	/**
	 * If the points are expiration then this field should contain the general
	 * expiration information. See the {@link PeriodicExpiration} object for more
	 * information.
	 */
	public function getExpiration() { return $this->data['expiration']; }
	public function setExpiration( PeriodicExpiration $expiration ) {
		if( !is_null( $expiration ) )
			$this->data['expiration'] = $expiration->getJsonArray();
		else
			$this->data['expiration'] = $expiration;
	}

	/**
	 * The description associated with the point.
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getDescription() { return $this->data['description']; }
	public function setDescription( $description ) { $this->data['description'] = $description; }

	/**
	 * This contains the point's units of measure.
	 * See the {@link Units} object for more information.
	 */
	public function getUnits() { return $this->data['units']; }
	public function setUnits( Units $units ) {
		if( !is_null( $units ) )
			$this->data['units'] = $units->getJsonArray();
		else
			$this->data['units'] = $units;
	}
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		return json_encode( $this->data );
	}
}
?>