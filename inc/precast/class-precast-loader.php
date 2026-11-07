<?php
/**
 * Precast Al Turab — hook loader.
 *
 * Collects every action, filter and shortcode the Precast modules need and
 * registers them with WordPress in one place (run()). Feature classes never
 * call add_action / add_filter / add_shortcode themselves.
 *
 * @package SublimePlusV2
 * @since   1.1.0
 */
defined('ABSPATH') || exit;

class Precast_Loader {

    /** @var array[] */
    protected $actions = [];

    /** @var array[] */
    protected $filters = [];

    /** @var array[] */
    protected $shortcodes = [];

    /**
     * Queue an action.
     *
     * @param string      $hook          WordPress hook name.
     * @param object|null $component     Object that owns the callback, or null for a plain function name.
     * @param string      $callback      Method (or function) name.
     * @param int         $priority      Hook priority.
     * @param int         $accepted_args Number of arguments passed to the callback.
     */
    public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->actions[] = compact('hook', 'component', 'callback', 'priority', 'accepted_args');
    }

    /** Queue a filter. Same parameters as add_action(). */
    public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->filters[] = compact('hook', 'component', 'callback', 'priority', 'accepted_args');
    }

    /** Queue a shortcode. */
    public function add_shortcode($tag, $component, $callback) {
        $this->shortcodes[] = compact('tag', 'component', 'callback');
    }

    /** Turn a queued item into a PHP callable. */
    protected function callable_for(array $item) {
        return $item['component'] ? [$item['component'], $item['callback']] : $item['callback'];
    }

    /** Register everything with WordPress. */
    public function run() {
        foreach ($this->filters as $f) {
            add_filter($f['hook'], $this->callable_for($f), $f['priority'], $f['accepted_args']);
        }
        foreach ($this->actions as $a) {
            add_action($a['hook'], $this->callable_for($a), $a['priority'], $a['accepted_args']);
        }
        foreach ($this->shortcodes as $s) {
            add_shortcode($s['tag'], $this->callable_for($s));
        }
    }
}
