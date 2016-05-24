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
 * This object captures the data required by the Purchase API in
 * order to track a user's purchase and redeem any associated
 * coupons.
 */
class PurchaseRequestData
{
	const PURCHASE_STATUS_NEW = "new";
	const PURCHASE_STATUS_PENDING_PAYMENT = "pending_payment";
	const PURCHASE_STATUS_PROCESSING = "processing";
	const PURCHASE_STATUS_COMPLETE = "complete";
	const PURCHASE_STATUS_CLOSED = "closed";
	const PURCHASE_STATUS_CANCELED = "canceled";
	const PURCHASE_STATUS_HOLDED = "holded";
	const PURCHASE_STATUS_PAYMENT_REVIEW = "payment_review";
	
	private $data = array();
	
	/**
	 * The Unique User ID of the user performing the purchase.
	 * This field is required.
	 * @return
	 */
	public function getUuid() { return $this->data['uuid']; }
	public function setUuid( $uuid ) { $this->data['uuid'] = $uuid; }
	
	/**
	 * The Order Number of the purchase. Order numbers must be unique.
	 * If we receive two identical order numbers, an error will be thrown.
	 * This field is required.
	 * @return
	 */
	public function getOrderNumber() { return $this->data['orderNumber']; }
	public function setOrderNumber( $orderNumber ) { $this->data['orderNumber'] = $orderNumber; }
	
	/**
	 * The date the purchase was made.
	 * This is expected as a UTC timestamp in ISO 8601 format with 
	 * millisecond precision: YYYY-MM-DDTHH:MM:SS.MMMZ
	 * For example: 2013-01-20T20:43:24.094Z
	 * Dates formatted differently will return an Exception.
	 * This field is required.
	 * @return
	 */
	public function getOrderDate() { return $this->data['orderDate']; }
	public function setOrderDate( $orderDate ) { $this->data['orderDate'] = $orderDate; }
	
	/**	
	 * The status of the Purchase Order.
	 * 
	 * This can have one of the following values:
	 * <ul>
	 * <li><b>New</b> - New orders have just come into the system.</li>
	 * <li><b>Pending</b> - Pending orders are brand new orders that have not been processed. 
	 * Typically, these orders need to be invoiced and shipped.</li>
	 * <li><b>On Hold</b> - The user cannot proceed to order processing if the order is in this 
	 * state. This is convenient if, for example, some data must be verified.</li>
	 * <li><b>Payment Review</b> - As long as an external payment gateway is verifying the 
	 * payment information from a sales order, the order is assigned the Payment 
	 * Review status both in the payment system and in Magento CE.</li>
	 * <li><b>Processing</b> - Processing means that the order has been either invoiced or 
	 * shipped, but not both.</li>
	 * <li><b>Complete</b> - Orders marked as complete have fully been invoiced and have shipped.</li>
	 * <li><b>Canceled</b> - The order can be of this status if the customer calls your web store 
	 * and asks to cancel an order if the order has not been paid for.</li>
	 * </ul>
	 * 
	 * Use the following class constants for each value:
	 * 
	 * 	PurchaseRequestData::PURCHASE_STATUS_NEW
	 * 	PurchaseRequestData::PURCHASE_STATUS_PENDING_PAYMENT
	 * 	PurchaseRequestData::PURCHASE_STATUS_PROCESSING
	 * 	PurchaseRequestData::PURCHASE_STATUS_COMPLETE
	 * 	PurchaseRequestData::PURCHASE_STATUS_CLOSED
	 * 	PurchaseRequestData::PURCHASE_STATUS_CANCELED
	 * 	PurchaseRequestData::PURCHASE_STATUS_HOLDED
	 * 	PurchaseRequestData::PURCHASE_STATUS_PAYMENT_REVIEW
	 * 
	 * This field is required.
	 * @return
	 */
	public function getStatus() { return $this->data['status']; }
	public function setStatus( $status )
	{
		if( strcmp( $status, self::PURCHASE_STATUS_NEW) != 0 && strcmp( $status, self::PURCHASE_STATUS_PENDING_PAYMENT) != 0 && 
			strcmp( $status, self::PURCHASE_STATUS_PROCESSING) != 0 && strcmp( $status, self::PURCHASE_STATUS_COMPLETE) != 0 && 
			strcmp( $status, self::PURCHASE_STATUS_CLOSED) != 0 && strcmp( $status, self::PURCHASE_STATUS_CANCELED) != 0 &&
				strcmp( $status, self::PURCHASE_STATUS_HOLDED) != 0 && strcmp( $status, self::PURCHASE_STATUS_PAYMENT_REVIEW) != 0)
		{
			trigger_error( "The value specified for status is invalid. Allowed values: 
					new, pending_payment, processing, complete, closed, canceled, holded, payment_review, ", 
					E_USER_ERROR );
		}
		else
		{
			$this->data['status'] = $status;
		}
	}
	
	/**
	 * This is the coupon code associated with the purchase (if any). This Purchase API
	 * will check to see if this is a registered coupon. If it isn't, then the
	 * purchase is saved. If it is, then the coupon is first validated against
	 * the user performing the purchase. If it's valid, then the coupon is
	 * redeemed from the user's account and the purchase is saved. If the coupon
	 * is not valid, then an exception will be thrown and the purchase will not
	 * be saved. It is important you validate the responses from the Purchase API.
	 * @return
	 */
	public function getCouponCode() { return $this->data['couponCode']; }
	public function setCouponCode( $couponCode ) { $this->data['couponCode'] = $couponCode; }

	/**
	 * The monetary values associated to this Purchase
	 * @return
	 */
	public function getMonetaryValues() { return $this->data['monetaryValues']; }
	public function setMonetaryValues( MonetaryValues $monetaryValues ) { $this->data['monetaryValues'] = $monetaryValues; }
	
	/**
	 * This is the list of products associated to this purchase. Providing this
	 * information allows us to provide you with information about what a user
	 * has purchased. In future this will also be used to provide you with other
	 * interesting metrics.
	 * @return
	 */
	public function getProducts() { return $this->data['products']; }
	public function setProducts( array $products ) { $this->data['products'] = $products; }
	public function addProduct( Product $product ) {
		if( !isset( $this->data['products'] ) ) {
			$this->data['products'] = array();
		}
		array_push( $this->data['products'], $product );
	}
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		$json = $this->data;
		
		if( isset( $json['products'] ) && !is_null( $json['products'] ) ) {
			$productsArr = array();
			foreach( $json['products'] as $product ) {
				array_push( $productsArr, $product->getJsonArray() );
			}
			$json['products'] = $productsArr;
		}
		
		if( isset( $json['monetaryValues'] ) && !is_null( $json['monetaryValues'] ) ) {
			$json['monetaryValues'] = $json['monetaryValues']->getJsonArray();
		}
		
		return json_encode( $json );
	}
}
?>