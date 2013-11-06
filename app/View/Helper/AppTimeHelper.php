<?php

App::uses('TimeHelper', 'View/Helper');

class AppTimeHelper extends TimeHelper {

	/**
	 * @see CakeTime::nice()
	 *
	 * @param integer|string|DateTime $dateString UNIX timestamp, strtotime() valid string or DateTime object
	 * @param string|DateTimeZone $timezone User's timezone string or DateTimeZone object
	 * @param string $format The format to use. If null, `TimeHelper::$niceFormat` is used
	 * @return string Formatted date string
	 */
	public function nice($dateString = null, $timezone = null, $format = null) {
		if (is_null($format)) {
			$format = '%a, %b %eS %Y, %l:%M %p';
		}
		return $this->_engine->nice($dateString, $timezone, $format);
	}
		
}
