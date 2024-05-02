<?php
class UserSession {
    public function __construct() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setLastSearchedCity($city) {
        setcookie('last_searched_city', $city, time() + (86400 * 30)); // 86400 = 1 day
    }

    public function getLastSearchedCity() {
        return isset($_COOKIE['last_searched_city']) ? $_COOKIE['last_searched_city'] : null;
    }

    public function incrementSearchCount() {
        if(!isset($_COOKIE['search_count'])) {
            setcookie('search_count', 1, time() + (86400 * 30)); // 86400 = 1 day
        } else {
            $count = $_COOKIE['search_count'] + 1;
            setcookie('search_count', $count, time() + (86400 * 30)); // 86400 = 1 day
        }
    }

    public function getSearchCount() {
        return isset($_COOKIE['search_count']) ? $_COOKIE['search_count'] : 0;
    }
}