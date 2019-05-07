<?php

  class Router {

    public static function route($url) {

      // Controller
      $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
      $controller_name = $controller;
      array_shift($url);

      /// Action
      $action = (isset($url[0]) && $url[0] != '') ? $url[0] . 'Action' : 'indexAction';
      $action_name = $action;
      array_shift($url);

      // Params
      $queryParams = $url;

      $dispatch = new $controller($controller_name, $action_name);

      if(method_exists($controller, $action)) {
        call_user_func_array([$dispatch, $action], $queryParams);
      } else {
        die('Method "' . $action_name . '" does not exists in the "' . $controller_name . '" controller');
      }
    }

    public static function redirect($location) {
      if(!headers_sent()) {
        header("Location: " . PROOT . $location);
        exit();
      } else {
        echo '<script type="text/javascript">';
        echo 'window.loaction.href="' . PROOT . $location . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
        echo '</noscript>';
        exit();
      }
    }
  }
