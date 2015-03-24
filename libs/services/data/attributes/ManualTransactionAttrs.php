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
 * Defines transaction attributes specific to manual.
 */
class ManualTransactionAttrs
{
	private $data = array();
	
	/**
	 * The type of attribute
	 * @return
	 */
	public function getType() { return 'manual'; }

	/**
	 * The action associated to the manual transaction. The actions currently
	 * available are:
	 * Increment: increments the user's total points and point balance
	 * Redeem: decrements the user's points balance and increments the user's spent points
	 * Refund: decrements the user's spent points and increments the user's point balance
	 * @return
	 */
	public function getAction() { return $this->data['action']; }
	public function setAction( $action ) { $this->data['action'] = (string) $action; }

	/**
	 * The reason associated to the manual transaction. This is used to provide more
	 * details to the user as to why they are earning / losing the points.
	 * @return
	 */
	public function getReason() { return $this->data['reason']; }
	public function setReason( $reason ) { $this->data['reason'] = (string) $reason; }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonArray()
	{
		$this->data['type'] = 'manual';
		return $this->data;
	}
}
?>