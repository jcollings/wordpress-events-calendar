<?php
get_header(); ?>

<?php do_action('before_theme_content'); ?>

<?php do_action( 'jce/before_event_calendar' ); ?>

<?php 
global $wp_query;

$year = get_query_var( 'cal_year' ) ? get_query_var( 'cal_year' ) : date('Y');
$month = get_query_var( 'cal_month' ) ? get_query_var( 'cal_month' ) : date('m');
$day = get_query_var( 'cal_day' ) ? get_query_var( 'cal_day' ) : date('d');

$calendar = new JCE_Calendar();

// todo: set week start has to be set before the month
$calendar->set_week_start('Mon');
$calendar->set_month($year, $month);

$calendar->render($wp_query->posts);
?>

<?php do_action( 'jce/after_event_calendar' ); ?>

<?php do_action('after_theme_content'); ?>

<?php get_footer(); ?>