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
 * This object captures the data required by the Event API in
 * order to track a behaviour performed by a specific user.
 */
class EventRequestData
{
	private $uuid, $url, $verb, $metadata;
	
	/**
	 * The Unique User ID of the Player who triggered the event.
	 * For more information on this field, please see the Player
	 * related APIs.
	 * @return string uuid
	 */
	public function getUUID() { return $this->uuid; }
	public function setUUID( $uuid ) { $this->uuid = $uuid; }

	
	/**
	 * The URL of the page on which the event took place. This should
	 * be a fully qualified URL. For example: http://www.acme.com/the/page.html
	 * @return string url
	 */
	public function getUrl() { return $this->url; }
	public function setUrl( $url ) { $this->url = $url; }
	
	
	/**
	 * The behaviour performed by the user. Each behaviour has a corresponding verb 
	 * which is the name of the behaviour in lower case. For example: The behaviour 
	 * "Read an Article" would have an verb of "read an article".
	 * @return string verb
	 */
	public function getVerb() { return $this->verb; }
	public function setVerb( $verb ) { $this->verb = $verb; }
	
	
	/**
	 * The metadata associated to the behaviour performed by the user. This is an array of
	 * key/value pairs, for example: if the name of the metadata is "type" and the value is
	 * "product" then the metadata array would look like this:
	 * array( "type" => "product" )
	 * To find out more please visit the Flexible Behaviours page in the administration panel.
	 * @return string metadata
	 */
	public function getMetadata() { return $this->metadata; }
	public function setMetadata( array $metadata ) { $this->metadata = $metadata; }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		$arr = array( 'uuid' => $this->uuid, 'url' => $this->url, 'verb' => $this->verb );
		if( is_array( $this->metadata ) && !empty( $this->metadata ) )
		{
			$arr['metadata'] = $this->metadata;
		}
		return json_encode( $arr );
	}
}
?>