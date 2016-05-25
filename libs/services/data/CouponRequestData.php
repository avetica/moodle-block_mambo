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
 * This object captures the data required by the Coupon API in
 * order to create / update coupons.
 */
class CouponRequestData extends AbstractHasTagRequestData
{

	/**
	 * Whether the image associated to the Coupon should be removed
	 * @return boolean removeImage
	 */
	public function getRemoveImage() { return $this->data['removeImage']; }
	public function setRemoveImage( $removeImage ) { $this->data['removeImage'] = $removeImage; }

	/**
	 * The name of the coupon.
	 * @return
	 */
	public function getName() { return $this->data['name']; }
	public function setName( $name ) { $this->data['name'] = $name; }

	/**
	 * The discount coupon code to be used.
	 * @return
	 */
	public function getCode() { return $this->data['code']; }
	public function setCode( $code ) { $this->data['code'] = $code; }

	/**
	 * The type of coupon. Valid values include: percent, fixed, shipping and custom.
	 * @return
	 */
	public function getType() { return $this->data['type']; }
	public function setType( $type ) { $this->data['type'] = $type; }

	/**
	 * This flag indicates whether this coupon is active.
	 * @return
	 */
	public function getActive() { return $this->data['active']; }
	public function setActive( $active ) { $this->data['active'] = $active; }

	/**
	 * In the case of a percent or fixed based coupon, the amount should contain
	 * the percentage or currency amount that the coupon provides.
	 * @return
	 */
	public function getAmount() { return $this->data['amount']; }
	public function setAmount( $amount ) { $this->data['amount'] = $amount; }

	/**
	 * In the case of a custom based coupon, thus field should contain information
	 * relating to the nature of the coupon that is being given. For example: buy 1
	 * get 1 free.
	 * @return
	 */
	public function getCustomPrize() { return $this->data['custom']; }
	public function setCustomPrize( $custom ) { $this->data['custom'] = $custom; }

	/**
	 * The number of points required in order to buy this coupon.
	 * If the coupon cannot be bought then this value should be
	 * set to null.
	 */
	public function getPointsToBuy() { return $this->data['pointsToBuy']; }
	public function setPointsToBuy( $pointsToBuy ) { $this->data['pointsToBuy'] = $pointsToBuy; }

	/**
	 * The message to be displayed in the coupon purchasing screen. This can provide
	 * more information about the coupon, how to redeem it, any exceptions for the
	 * coupon, etc.
	 * @return
	 */
	public function getHelpMessage() { return $this->data['helpMessage']; }
	public function setHelpMessage( $helpMessage ) { $this->data['helpMessage'] = $helpMessage; }

	/**
	 * The usage indicates how many times this coupon can be used. Valid values
	 * include: single or multi. If single is used then the coupon can only be used
	 * once. If multi is used then the coupon can be re-used multiple times (if an
	 * expire period is set, then it can be used re-used until it's expired).
	 *
	 * Important: users can be awarded with the same single use coupon more than
	 * once. This will award the same coupon twice to the user and they should be
	 * able to redeem BOTH those rewards.
	 *
	 * @return
	 */
	public function getUsage() { return $this->data['usage']; }
	public function setUsage( $usage ) { $this->data['usage'] = $usage; }

	/**
	 * Defines whether this coupon expires or not. If it does, then the relevant time
	 * frame needs to be set.
	 * See the {@link NeverExpiration}, {@link FixedDateExpiration} or 
	 * {@link VariablePeriodExpiration} objects for more information.
	 * @return
	 */
	public function getExpiration() { return $this->data['expiration']; }
	public function setExpiration( $expiration ) { $this->data['expiration'] = $expiration; }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		$json = $this->data;
		
		if( isset( $json['pointsToBuy'] ) && !is_null( $json['pointsToBuy'] ) ) {
			$json['pointsToBuy'] = $json['pointsToBuy']->getJsonArray();
		}
		
		if( isset( $json['expiration'] ) && !is_null( $json['expiration'] ) ) {
			$json['expiration'] = $json['expiration']->getJsonArray();
		}
		
		return json_encode( $json );
	}
}
?>