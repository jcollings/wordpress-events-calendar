<?php  
/*
	Plugin Name: Easy Events Calendar
	Plugin URI: http://www.jamescollings.co.uk
	Description: Easy to install and use events calendar
	Version: 0.0.1
	Author: James Collings
	Author URI: http://www.jamescollings.co.uk
 */

/*  Copyright 2013  James Collings  (email : james@jclabs.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$JCEvents = new JCEvents();

class JCEvents{

	var $version = '0.0.1';
	var $plugin_dir = false;
	var $plugin_url = false;
	var $events_pt = 'events';
	var $recurring_events_pt = 'recurring_events';

	function __construct(){

		$this->plugin_dir =  plugin_dir_path( __FILE__ );
		$this->plugin_url = plugins_url( '/', __FILE__ );
		

		add_action('init', array($this, 'register'));
		add_action('query_vars', array($this, 'register_query_vars') );

		$this->load_modules();
		$this->load_settings();
	}

	function register(){

		register_post_type( $this->events_pt, 
			array(
				'capability_type' => 'post',
				'rewrite' => array('slug' => ''),
				'query_var' => true,
				'has_archive' => true,
				'show_in_nav_menus' => true,
				'labels' => array(
					'name' => __('Events'),
				    'singular_name' => __('Event'),
				    'add_new' => _x('Add New', 'event'),
				    'add_new_item' => __('Add New Event'),
				    'edit_item' => __('Edit Event'),
				    'new_item' => __('New Event'),
				    'all_items' => __('All Event'),
				    'view_item' => __('View Event'),
				    'search_items' => __('Search Events'),
				    'not_found' =>  __('No events found'),
				    'not_found_in_trash' => __('No events found in Trash'), 
				    'parent_item_colon' => '',
				    'menu_name' => __('Events')
				),
				'exclude_from_search' => true,
				'publicly_queryable' => false,
				'public' => true,
				'taxonomies' => array('event_cals'),
				'supports' => array('title', 'editor', 'thumbnail')
			)
		);

		register_post_type( $this->recurring_events_pt, 
			array(
				'capability_type' => 'post',
				'rewrite' => array('slug' => ''),
				'query_var' => true,
				'has_archive' => false,
				'show_in_nav_menus' => false,
				'labels' => array(
					'name' => __('Recurring Events'),
				    'singular_name' => __('Event'),
				    'add_new' => _x('Add New', 'event'),
				    'add_new_item' => __('Add New Event'),
				    'edit_item' => __('Edit Event'),
				    'new_item' => __('New Event'),
				    'all_items' => __('All Event'),
				    'view_item' => __('View Event'),
				    'search_items' => __('Search Events'),
				    'not_found' =>  __('No events found'),
				    'not_found_in_trash' => __('No events found in Trash'), 
				    'parent_item_colon' => '',
				    'menu_name' => __('Events')
				),
				'public' => false,
				'taxonomies' => array('event_cals'),
				'show_in_menu' => false
			)
		);

		
	}

	/**
	 * Register Query Vars
	 * 
	 * @param  array $public_query_vars 
	 * @return array
	 */
	function register_query_vars($public_query_vars) {
		$public_query_vars[] = 'xyear';
		$public_query_vars[] = 'xyear';
		return $public_query_vars;
	}

	function load_settings(){

	}

	function load_modules(){
		
		include 'functions.php';
		include 'calendar.php';
		include 'shortcodes.php';

		include 'EventsModel.php';
		EventsModel::init($this);

		include 'CalendarAdmin.php';
		new CalendarAdmin($this);

		include 'EventsAdmin.php';
		new EventsAdmin($this);
	}

}

?>