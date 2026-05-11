<?php

/**
 * SublimeBaseTab is an abstract class that defines the common structure and behavior 
 * for individual tab classes in the SublimePlus settings page.
 */
abstract class SublimeBaseTab {
    protected $settings;

    public function __construct($settings) {
        $this->settings = $settings;
    }

    abstract public function render();
    abstract public function sanitize($inputs);
    abstract public function getTitle();  

    protected function getName($key) {
        return Sublimeplus_SETTINGS_KEY . '[' . $key . ']';
    }

    protected function getValue($key) {
        return isset($this->settings[$key]) ? $this->settings[$key] : '';
    }
}
