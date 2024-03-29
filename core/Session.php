<?php

  class Session {

    public static function exists($name) {
      if(isset($_SESSION[$name])) {
        return true;
      }
      return false;
    }

    public static function get($name) {
      if(self::exists($name)) {
        return $_SESSION[$name];
      }
      return false;
    }

    public static function set($name, $value) {
      return $_SESSION[$name] = $value;
    }

    public static function delete($name) {
      if(self::exists($name)) {
        unset($_SESSION[$name]);
      }
    }

    public static function uagent_no_version() {
      $uagent = $_SERVER['HTTP_USER_AGENT'];
      $regx = '/\/[a-zA-Z0-9.]+/';
      return preg_replace($regx, '', $uagent);
    }
  }
