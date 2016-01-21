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
 * order to validate a coupon.
 */
class CouponUserRequestData
{
	private $uuid, $couponCode;
	
	/**
	 * The Unique User ID of the Player against which to validate
	 * the coupon code.
	 * @return
	 */
	public function getUuid() { return $this->uuid; }
	public function setUuid( $uuid ) { $this->uuid = $uuid; }
	
	/**
	 * The coupon code to validate against the specified user.
	 * @return
	 */
	public function getCouponCode() { return $this->couponCode; }
	public function setCouponCode( $couponCode ) { $this->couponCode = $couponCode; }
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		return json_encode( array(
						'uuid' => $this->uuid, 
						'code' => $this->couponCode ) );
	}
}
?>