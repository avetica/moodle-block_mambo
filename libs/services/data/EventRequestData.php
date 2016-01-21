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
	private $data = array();
	
	/**
	 * The Unique User ID of the Player who triggered the event.
	 * For more information on this field, please see the Player
	 * related APIs.
	 * @return string uuid
	 */
	public function getUUID() { return $this->data['uuid']; }
	public function setUUID( $uuid ) { $this->data['uuid'] = $uuid; }

	
	/**
	 * The URL of the page on which the event took place. This should
	 * be a fully qualified URL. For example: http://www.acme.com/the/page.html
	 * @return string url
	 */
	public function getUrl() { return $this->data['url']; }
	public function setUrl( $url ) { $this->data['url'] = $url; }
	
	
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
	 * This {@link ContentData} represents the piece of content on which the
	 * behaviour took place, if any. For example, if the user shares a blog
	 * post, the content could represent the blog post. The content is then
	 * used when generating the activity streams to create rich messages for
	 * the users. Using the blog example we could display:
	 * Bob Dylan has shared [A Guide to Copy Writing]
	 * Where the [] represent a link to the blog post.
	 * @return
	 */
	public function getContent() { return $this->data['content']; }
	public function setContent( Content $content ) {
		if( !is_null( $content ) )
			$this->data['content'] = $content->getJsonArray();
		else
			$this->data['content'] = $content;
	}

	/**
	 * This {@link ContentData} represents the target of the content. Using the
	 * Content field example, the user might share the blog to Facebook, the
	 * target object can be used to capture this:
	 * Bob Dylan has shared [A Guide to Copy Writing] to [Facebook]
	 * Where the [] represent a link to the blog post and Facebook.
	 * Another example could be uploading an image to a specific photo album,
	 * that might look something like this:
	 * Bob Dylan has uploaded [Relaxing on a beach] to [Epic Journey]
	 * @return
	 */
	public function getTarget() { return $this->data['target']; }
	public function setTarget( Content $target ) {
		if( !is_null( $target ) )
			$this->data['target'] = $target->getJsonArray();
		else
			$this->data['target'] = $target;
	}
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		return json_encode( $this->data );
	}
}
?>