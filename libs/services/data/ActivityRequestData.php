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
 * This object captures the data required by the Activity API in
 * order to create an activity.
 */
class ActivityRequestData extends AbstractHasTagRequestData
{
	
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
	public function setContent( Content $content ) { $this->data['content'] = $content; }

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
	public function setTarget( Content $target ) { $this->data['target'] = $target; }

	/**
	 * The attributes of the event. Types of attributes:
	 * BehaviourEventAttrs
	 * @return
	 */
	public function getAttrs() { return $this->data['attrs']; }
	public function setAttrs( $attrs ) { $this->data['attrs'] = $attrs; }
	
	
	/**
	 * Return the JSON string equivalent of this object
	 */
	public function getJsonString()
	{
		$json = $this->data;
		
		if( isset( $json['content'] ) && !is_null( $json['content'] ) ) {
			$json['content'] = $json['content']->getJsonArray();
		}
		
		if( isset( $json['target'] ) && !is_null( $json['target'] ) ) {
			$json['target'] = $json['target']->getJsonArray();
		}
		
		if( isset( $json['attrs'] ) && !is_null( $json['attrs'] ) ) {
			$json['attrs'] = $json['attrs']->getJsonArray();
		}
		
		return json_encode( $json );
	}
}
?>