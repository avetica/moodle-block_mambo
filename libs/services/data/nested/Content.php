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
 * This object captures the data used by the Event API in
 * order to associate content information to an EventRequestData.
 */
class Content
{
	private $data = array();


	/**
	 * The id should contain a unique identifier for this piece of content.
	 * @return
	 */
	public function getId() { return $this->data['id']; }
	public function setId( $id ) { $this->data['id'] = $id; }


	/**
	 * The title of the piece of content. This will be used in the activities
	 * widgets when describing an activity. An example using the title in the
	 * activities widget is:
	 * Bob Dylan has shared [Relaxing in the Sun].
	 * In this case the [] represents the title of the photo.
	 * @return
	 */
	public function getTitle() { return $this->data['title']; }
	public function setTitle( $title ) { $this->data['title'] = $title; }


	/**
	 * The description of the piece of content. This may be used in the activities
	 * widget to render tool tips for the content's title.
	 * @return
	 */
	public function getDescription() { return $this->data['description']; }
	public function setDescription( $description ) { $this->data['description'] = $description; }


	/**
	 * The type of the piece of content. For example:
	 * image, blog, article, product, pdf...
	 * @return
	 */
	public function getType() { return $this->data['type']; }
	public function setType( $type ) { $this->data['type'] = $type; }


	/**
	 * The URL of an image which is associated to this piece of content.
	 * For example: if the content is an image, this could contain the link
	 * to the image; if the content is a blog post, this could contain the
	 * link to the featured image if one exists; if the content was a product,
	 * this could contain the link to an image of the product.
	 * @return
	 */
	public function getImageUrl() { return $this->data['imageUrl']; }
	public function setImageUrl( $imageUrl ) { $this->data['imageUrl'] = $imageUrl; }


	/**
	 * The URL which when clicked will take us to this piece of content.
	 * For example: the URL to view an image, the URL of a blog post,
	 * the URL of a product page in an e-commerce store, etc.
	 * The URL is used in the activity stream to link the activity item
	 * back to the content on which the behaviour was performed.
	 * @return
	 */
	public function getUrl() { return $this->data['url']; }
	public function setUrl( $url ) { $this->data['url'] = $url; }
	
	
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