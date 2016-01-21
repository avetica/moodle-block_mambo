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
 * This object captures the data required by the Point API in
 * order to associate units of measure to a PointRequestData.
 */
class Units
{
	private $data = array();


	/**
	 * The units of measure used to describe more than one point, for example: 10 points
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getPlural() { return $this->data['plural']; }
	public function setPlural( $plural ) { $this->data['plural'] = $plural; }


	/**
	 * The units of measure used to describe one point, for example: 1 point
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getSingular() { return $this->data['singular']; }
	public function setSingular( $singular ) { $this->data['singular'] = $singular; }


	/**
	 * The units of measure used to describe the abbreviation for more
	 * than one point, for example: 10 pts
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getAbbrPlural() { return $this->data['abbrPlural']; }
	public function setAbbrPlural( $abbrPlural ) { $this->data['abbrPlural'] = $abbrPlural; }


	/**
	 * The units of measure used to describe the abbreviation one point, for example: 1 pt
	 * See the points page in administration panel for more information.
	 * @return
	 */
	public function getAbbrSingular() { return $this->data['abbrSingular']; }
	public function setAbbrSingular( $abbrSingular ) { $this->data['abbrSingular'] = $abbrSingular; }
	
	
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