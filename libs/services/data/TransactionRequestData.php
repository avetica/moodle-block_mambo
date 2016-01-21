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
 * This object captures the data required by the Transaction API in
 * order to reject the specified transaction.
 */
class TransactionRequestData extends AbstractHasTagRequestData
{
	/**
	 * The Unique User ID of the user who triggered this transaction
	 */
	public function getUUID() { return $this->data['uuid']; }
	public function setUUID( $uuid ) { $this->data['uuid'] = $uuid; }

	/**
	 * The number of points required in order to buy this coupon.
	 * If the coupon cannot be bought then this value should be
	 * set to null.
	 */
	public function getPoints() { return $this->data['points']; }
	public function setPoints( SimplePoint $points ) {
		if( !is_null( $points ) )
			$this->data['points'] = $points->getJsonArray();
		else
			$this->data['points'] = $points;
	}

	/**
	 * The attributes of the transaction. There are currently three types of
	 * attributes: BountyTransactionAttrs, GiftedTransactionAttrs and ManualTransactionAttrs.
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