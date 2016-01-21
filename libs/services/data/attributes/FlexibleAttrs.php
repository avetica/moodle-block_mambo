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
 * This object captures the data required by the Behaviour API in
 * order to create / update flexible behaviours
 */
class FlexibleAttrs
{
	private $data = array();
	
	/**
	 * The type of attribute
	 * @return
	 */
	public function getType() { return 'flexible'; }

	/**
	 * The ID of the underlying simple behaviour
	 * @return
	 */
	public function getBehaviourId() { return $this->data['behaviourId']; }
	public function setBehaviourId( $behaviourId ) { $this->data['behaviourId'] = (string) $behaviourId; }

	/**
	 * Get the count scope which is used to apply the count limit to a specific metadata's values.
	 * For example, you could limit the behaviour to one repetition per blog_id or per product_sku.
	 * @return
	 */
	public function getCountScope() { return $this->data['countScope']; }
	public function setCountScope( $countScope ) { $this->data['countScope'] = $countScope; }

	/**
	 * Get the count limit which is used to limit the repetitions of this behaviour per user
	 * @return
	 */
	public function getCountLimit() { return $this->data['countLimit']; }
	public function setCountLimit( $countLimit ) { $this->data['countLimit'] = $countLimit; }

	/**
	 * The metadata associated to the flexible behaviour. This is an array of
	 * key/value pairs, for example: if the name of the metadata is "type" and the value is
	 * "product" then the metadata array would look like this:
	 * array( "type" => "product" )
	 * See the flexible behaviour page in the administration panel for more information.
	 * @return
	 */
	public function getMetadata() { return $this->data['metadata']; }
	public function setMetadata( array $metadata ) { $this->data['metadata'] = $metadata; }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonArray()
	{
		$this->data['type'] = 'flexible';
		return $this->data;
	}
}
?>