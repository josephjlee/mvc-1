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

      //ACL check
      $grantAccess = self::hasAccess($controller_name, $action_name);
      if(!$grantAccess) {
        $controller_name = $controller = ACCESS_RESTRICTED;
        $action = 'indexAction';
      }

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

    public static function hasAccess($controller_name, $action_name = 'index') {
      $acl_file = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json');
      $acl = json_decode($acl_file, true);
      $current_user_acls = ["Guest"];
      $grantAccess = false;
      if(Session::exists(CURRENT_USER_SESSION_NAME)) {
        $current_user_acls[] = "LoggedIn";
        foreach(currentUser()->acls() as $a) {
          $current_user_acls[] = $a;
        }
      }
      dnd($current_user_acls);
    }
  }
