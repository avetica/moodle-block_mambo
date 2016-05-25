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
 * Defines activity attributes specific to coupon.
 */
class ActivityCouponAttrs
{
	private $data = array();
	
	/**
	 * The type of attribute
	 * @return
	 */
	public function getType() { return 'coupon'; }

	/**
	 * The coupon code to be used for this activity
	 * @return
	 */
	public function getCode() { return $this->data['code']; }
	public function setCode( $code ) { $this->data['code'] = (string) $code; }

	/**
	 * The action associated to the coupon activity. The actions currently
	 * available are:<br>
	 * Redeem: redeems the user's coupon<br>
	 * Refund: refunds the user's coupon
	 * @return
	 */
	public function getAction() { return $this->data['action']; }
	public function setAction( $action ) { $this->data['action'] = (string) $action; }
	
	
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