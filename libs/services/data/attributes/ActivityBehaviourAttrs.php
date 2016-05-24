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
 * Defines activity attributes specific to behaviour activities.
 */
class ActivityBehaviourAttrs
{
	private $data = array();
	
	/**
	 * The type of attribute
	 * @return
	 */
	public function getType() { return 'behaviour'; }

	
	/**
	 * The behaviour performed by the user. Each behaviour has a corresponding verb
	 * which is the name of the behaviour in lower case. For example: The behaviour
	 * "Read an Article" would have an verb of "read an article".
	 * @return string verb
	 */
	public function getVerb() { return $this->data['verb']; }
	public function setVerb( $verb ) { $this->data['verb'] = $verb; }
	
	
	/**
	 * The metadata associated to the behaviour performed by the user. This is an array of
	 * key/value pairs, for example: if the name of the metadata is "type" and the value is
	 * "product" then the metadata array would look like this:
	 * array( "type" => "product" )
	 * To find out more please visit the Flexible Behaviours page in the administration panel.
	 * @return string metadata
	 */
	public function getMetadata() { return $this->data['metadata']; }
	public function setMetadata( array $metadata ) { $this->data['metadata'] = $metadata; }

	
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