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
 * order to associate a monetary values to a PurchaseRequestData.
 */
class MonetaryValues
{
	private $data = array();
	
	/**
	 * The grand total amount of the purchase. This should include
	 * discounts and shipping costs.
	 * This field is required.
	 * @return
	 */
	public function getTotalAmount() { return $this->data['totalAmount']; }
	public function setTotalAmount( $totalAmount ) { $this->data['totalAmount'] = $totalAmount; }
	
	/**
	 * The total amount paid by the customer for the purchase.
	 * This field is required.
	 * @return
	 */
	public function getTotalPaid() { return $this->data['totalPaid']; }
	public function setTotalPaid( $totalPaid ) { $this->data['totalPaid'] = $totalPaid; }
	
	/**
	 * The total amount of the purchase excluding any discounts or shipping fees.
	 * This should be the sum of the price of all the products in the cart.
	 * This field is required.
	 * @return
	 */
	public function getSubtotal() { return $this->data['subtotal']; }
	public function setSubtotal( $subtotal ) { $this->data['subtotal'] = $subtotal; }
	
	/**
	 * This is the amount that is spent on shipping. If the user uses a
	 * Free Shipping coupon, this should be the value that the shipping was 
	 * going to cost.
	 * This field is required.
	 * @return
	 */
	public function getShippingAmount() { return $this->data['shippingAmount']; }
	public function setShippingAmount( $shippingAmount ) { $this->data['shippingAmount'] = $shippingAmount; }
	
	/**
	 * This is the amount that was given as a discount. If no discount was
	 * given, then this can be set to zero.
	 * @return
	 */
	public function getDiscountAmount() { return $this->data['discountAmount']; }
	public function setDiscountAmount( $discountAmount ) { $this->data['discountAmount'] = $discountAmount; }
	
	/**
	 * This is the three letter country code for the currency to be used.
	 * For example: BRL or USD.
	 * This field is required.
	 * @return
	 */
	public function getCurrency() { return $this->data['currency']; }
	public function setCurrency( $currency ) { $this->data['currency'] = $currency; }
	
	/**
	 * Returns the current model as an array ready to
	 * be json_encoded
	 */
	public function getJsonArray()
	{
		return $this->data;
	}
}
?>