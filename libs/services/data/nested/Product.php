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
 * order to associate products to a PurchaseRequestData.
 */
class Product
{
	private $data = array();
	
	/**
	 * The products SKU (Stock Keeping Unit) or the unique identifier
	 * for this product.
	 * This field is required.
	 * @return
	 */
	public function getSKU() { return $this->data['sku']; }
	public function setSKU( $sku ) { $this->data['sku'] = $sku; }
	
	/**
	 * The products retail price.
	 * This field is required.
	 * @return
	 */
	public function getPrice() { return $this->data['price']; }
	public function setPrice( $price ) { $this->data['price'] = $price; }
	
	/**
	 * The products discount price.
	 * @return
	 */
	public function getDiscountPrice() { return $this->data['discountPrice']; }
	public function setDiscountPrice( $discountPrice ) { $this->data['discountPrice'] = $discountPrice; }
	
	/**
	 * The quantity of this product being purchased.
	 * This field is required.
	 * @return
	 */
	public function getQuantity() { return $this->data['quantity']; }
	public function setQuantity( $quantity ) { $this->data['quantity'] = $quantity; }
	
	/**
	 * The name of the product.
	 * This field is required.
	 * @return
	 */
	public function getName() { return $this->data['name']; }
	public function setName( $name ) { $this->data['name'] = $name; }
	
	/**
	 * The URL that points to this products page in your store.
	 * This field is not required but is useful for viewing the product details.
	 * @return
	 */
	public function getURL() { return $this->data['url']; }
	public function setURL( $url ) { $this->data['url'] = $url; }
	
	/**
	 * The URL of an image of the product.
	 * This field is not required but is useful for viewing the product details.
	 * @return
	 */
	public function getImageURL() { return $this->data['imageUrl']; }
	public function setImageURL( $imageUrl ) { $this->data['imageUrl'] = $imageUrl; }
	
	/**
	 * The list of categories to which this product belongs.
	 * For example: Mens, Shoes, Large.
	 * @return
	 */
	public function getCategories() { return $this->data['categories']; }
	public function setCategories( array $categories ) { $this->data['categories'] = $categories; }
	
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