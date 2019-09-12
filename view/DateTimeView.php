<?php

/*
 * Get current date & time
 */

class DateTimeView {

	public function show() {
		$time_ = date ('H:i:s');
		$day_ = date('l');
		$date_ = date('jS') . " of " . date('F') . " " . date('Y');
		$timeString = "$day_, the $date_, The time is  $time_";
		return "<p>$timeString</p>";
	}

}
