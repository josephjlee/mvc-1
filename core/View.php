<?php

  class View {

    protected $_head;
    protected $_body;
    protected $_siteTitle;
    protected $_outputBuffer;
    protected $_layout = DEFAULT_LAYOUT;

    public function __construct() {

    }

    public function render($viewName) {
      $viewArray = explode('/', $viewName);
      $viewString = implode(DS, $viewArray);
      if(file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')) {
        include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
        include(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
      } else {
        die('The view \"' . $viewName . '\" does not exist.');
      }
    }

    public function content($type) {
      if($type == 'head') {
        return $this->_head;
      } elseif($type == 'body') {
        return $this->_body;
      }
      return false;
    }
  }
