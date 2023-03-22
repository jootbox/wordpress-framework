<?php

namespace Framework\Helpers;

class Date {

	public function __construct() {
		add_filter( 'wpf_date_i18n', [ $this, 'getTranslatedDate' ], 10, 5 );
		add_filter( 'wpf_date_range', [ $this, 'getDateRange' ], 10, 9 );
	}

	/* ---
	  Functions
	--- */

	public function getTranslatedDate( $value, $dateFormat, $timestamp = false, $forceGenitive = false ) {
		if ( ! preg_match( '/(\d{10})/', $timestamp ) ) {
			$timestamp = strtotime( $timestamp );
		}
		$isGenitive = $forceGenitive ? true : preg_match( '/([d|j]{1})/', $dateFormat );

		$date = date( $dateFormat, $timestamp );
		$date = $this->parseDateToGenitive( $date, $isGenitive );
		return $date;
	}

	public function parseDateToGenitive( $date, $isGenitive ) {
		global $wp_locale;
		$month       = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
		$monthAbbr   = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ];
		$weekday     = [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ];
		$weekdayAbbr = [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ];

		$output = str_replace( $month, $isGenitive ? $wp_locale->month_genitive : $wp_locale->month, $date );
		$output = str_replace( $monthAbbr, $wp_locale->month_abbrev, $output );
		$output = str_replace( $weekday, $wp_locale->weekday, $output );
		$output = str_replace( $weekdayAbbr, $wp_locale->weekday_abbrev, $output );
		$output = mb_strtolower( $output );
		return $output;
	}

	public function getDateRange( $value, $dateStart, $dateEnd, $divider = ' - ', $formatDay = 'd F Y', $formatMonth = 'd%d F Y', $formatYear = 'd F%d F Y', $formatDiffYear = 'd F Y%d F Y', $forceGenitive = true ) {
		$timeStart = strtotime( $dateStart );
		$timeEnd   = strtotime( $dateEnd );

		if ( date( 'Y-m-d', $timeStart ) === date( 'Y-m-d', $timeEnd ) ) {
			return $this->getTranslatedDate( '', $formatDay, $dateStart, $forceGenitive );
		}

		if ( date( 'Y-m', $timeStart ) === date( 'Y-m', $timeEnd ) ) {
			$parts = explode( '%', $formatMonth );
		} else {
			if ( date( 'Y', $timeStart ) === date( 'Y', $timeEnd ) ) {
				$parts = explode( '%', $formatYear );
			} else {
				$parts = explode( '%', $formatDiffYear );
			}
		}

		if ( count( $parts ) !== 2 ) {
			return $value;
		}
		return sprintf( '%s%s%s',
			$this->getTranslatedDate( '', $parts[0], $dateStart, $forceGenitive ),
			( ! empty( $parts[0] ) && ! empty( $parts[1] ) ) ? $divider : '',
			$this->getTranslatedDate( '', $parts[1], $dateEnd, $forceGenitive )
		);
	}
}
