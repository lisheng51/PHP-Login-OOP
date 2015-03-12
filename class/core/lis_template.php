<?php

/**
 * Template class
 * 
 * @author Lisheng Ye
 * @version 1.0
 */
class LIS_Template {

    private $template;
    private $path;

    public function __construct($template) {
        $this->path = ROOT_DIR . "/template/";
        $this->load($template);
    }

    private function load($template) {
        $file = $this->path . $template . '.html';
        if (file_exists($file) === true) {
            $this->template = file_get_contents($file);
        }
    }

    public function set($var, $content) {
        $this->template = str_replace("##" . $var . "##", $content, $this->template);
    }

    public function parse() {
        return $this->template;
    }

    public function execute() {
       $this->template = preg_replace('^##.*##^', "", $this->template);
       echo $this->template;
    }
    


}
