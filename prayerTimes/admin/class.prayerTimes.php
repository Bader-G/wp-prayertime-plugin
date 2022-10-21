<?php

class PrayerTimes {

    //final vars but global
	const API_HOST = 'http://api.aladhan.com/v1/calendar?';
    const METHOD = 4;
    const DATA = 'data';
    const TIMINGS = 'timings';

	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
    }

    private static function todaysDate(){
        return (int)date("d");
    }

    private static function todaysPrayerTimes($res){
        $jsondata = json_decode($res, true);
        $todaysData = $jsondata[self::DATA][self::todaysDate()][self::TIMINGS];
        return $todaysData;
    }

    public static function getTimes($lat, $long){
        $data = array('latitude' => $lat, 'longitude' => $long, 'method' => self::METHOD);
        $get_data = http_build_query($data);
        $url = self::API_HOST . $get_data;
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        curl_close($ch);
        return  self::todaysPrayerTimes($result);
    }

    public static function verifyTimes($day){
      return (self::todaysDate() == $day)? true : false;
    }

}