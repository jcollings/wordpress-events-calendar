<?php

function jce_add_event_title(){
	if(is_single()){
		jce_get_template_part('single-event/title');
	}else{
		jce_get_template_part('archive-event/title');
	}	
}

// Add event meta to archive
function jce_add_event_meta(){
    jce_get_template_part('archive-event/meta');
}

/** ----------------------------------------------
 * Event Archive
 ---------------------------------------------- */

// show read more button
function jce_add_event_footer(){
	?>
	<a href="<?php the_permalink(); ?>">Read more</a>
	<?php
}

function jce_add_archive_month(){

	global $current_month;

	// display month name in archive
	$month = jce_event_start_date('F', false);
	if($current_month != $month){
		$current_month = $month;

		$title = sprintf("%s %s", $current_month, jce_event_start_date('Y', false));
		$title = apply_filters( 'jce/archive_month_title', $title );
		echo sprintf("<h2 class=\"jce-archive-title\">%s</h2>", $title);
	}
}

function jce_before_event_archive(){
	?>
	<div class="jce-event-archive">
	<?php
}

function jce_after_event_archive(){
	?>
	</div>
	<?php
}

function jce_before_event_loop(){
	?>
	<div class="cal">
	<?php
}

function jce_after_event_loop(){
	?>
	</div>
	<?php
}

function jce_show_archive_filter(){
	?>
	<a class="jce-show-filters">Show Filters</a>
	<?php
}

/**
 * Display Archive Prev & Next Links
 */
function jce_output_monthly_archive_links(){

    $year = get_query_var( 'cal_year' ) ? get_query_var( 'cal_year' ) : JCE()->query->query_vars['cal_year'];
    $month = get_query_var( 'cal_month' ) ? get_query_var( 'cal_month' ) : JCE()->query->query_vars['cal_month'];
    $view = get_query_var( 'view' ) ? get_query_var( 'view' ) : JCE()->query->query_vars['view'];

    if($view == 'upcoming'){
        return;
    }

    if(($month - 1) <= 0){
        $prev_link = add_query_arg(array('view' => $view, 'cal_year' => ($year - 1), 'cal_month' => 12));
        $next_link = add_query_arg(array('view' => $view, 'cal_year' => $year, 'cal_month' => ($month+1)));
    }elseif(($month + 1) > 12){
        $prev_link = add_query_arg(array('view' => $view, 'cal_year' => ($year), 'cal_month' => ($month-1)));
        $next_link = add_query_arg(array('view' => $view, 'cal_year' => ($year+1), 'cal_month' => (1)));
    }else{
        $prev_link = add_query_arg(array('view' => $view, 'cal_year' => ($year), 'cal_month' => ($month-1)));
        $next_link = add_query_arg(array('view' => $view, 'cal_year' => ($year), 'cal_month' => ($month+1)));
    }

    ?>
    <a class="jce-month-link jce-month-prev" href="<?php echo $prev_link; ?>">&lt;</a>
    <a class="jce-month-link jce-month-next" href="<?php echo $next_link; ?>">&gt;</a>
    <?php
}

/**
 * Display Archive Heading
 */
function jce_output_monthly_archive_heading(){

    $year = get_query_var( 'cal_year' ) ? get_query_var( 'cal_year' ) : JCE()->query->query_vars['cal_year'];
    $month = get_query_var( 'cal_month' ) ? get_query_var( 'cal_month' ) : JCE()->query->query_vars['cal_month'];
    $view = get_query_var( 'view' ) ? get_query_var( 'view' ) : JCE()->query->query_vars['view'];

	$title = date('F, Y', strtotime("$year-$month-01"));

    jce_get_template_part("archive-event/heading", array(
        'title' => $title
    ));
}

function jce_output_calendar_wrapper_open(){

	$classes = apply_filters('jce/calendar_class', array());
	$classes[] = 'jce-calendar'; 
	$classes = array_unique($classes);
	?>
	<div class="<?php echo implode(' ', $classes); ?>">
	<?php
}

function jce_output_calendar_wrapper_close(){
	?>
	</div>
	<?php
}

/**
 * Display monthly title in archive only
 */
function jce_output_daily_archive_heading(){

	$d = JCE()->query->get_day();
	$m = JCE()->query->get_month();
	$y = JCE()->query->get_year();

	$year = get_query_var( 'cal_year' ) ? get_query_var( 'cal_year' ) : $y;
	$month = get_query_var( 'cal_month' ) ? get_query_var( 'cal_month' ) : $m;
	$day = get_query_var( 'cal_day' ) ? get_query_var( 'cal_day' ) : $d;

	$title = date('l jS, F Y', strtotime("$year-$month-$day")); 

	echo "<h2 class=\"jce-archive-title\">".$title."</h2>";
}

/**
 * Events Archive Title
 * @return void
 */
function jce_display_upcoming_heading(){

	if( is_tax( 'event_venue' ) ){

		// Event Venue Archive Title
		$title = sprintf('Upcoming Events Venue: %s', single_term_title('', false));

	}elseif(is_tax('event_organiser')){

		// Event Organiser Archive Title
		$title = sprintf('Upcoming Events Organiser: %s', single_term_title('', false));

	}elseif(is_tax('event_category')){

		// Event Category Archive Title
		$title = sprintf('Upcoming Events Category: %s', single_term_title('', false));

	}elseif(is_tax('event_tag')){

		// Event Tag Archive Title
		$title = sprintf('Upcoming Events Tag: %s', single_term_title('', false));

	}else{

		// Events Archive Title
		$title = 'Upcoming Events';
	}

	$title = apply_filters( 'jce/archive_heading', $title );

    jce_get_template_part("archive-event/heading", array(
        'title' => $title
    ));
}

function jce_output_pagination(){
	jce_pagination();
}

function jce_output_event_filters(){
	jce_get_template_part('archive-event/filters');
}

/** ----------------------------------------------
 * Single Event
 ---------------------------------------------- */
function jce_add_event_date(){

    jce_get_template_part('single-event/meta');
}

function jce_add_single_event_content(){
    jce_get_template_part('single-event/content');
}

/**
 * Load event image on single event
 */
function jce_add_single_event_image(){
	jce_get_template_part('single-event/image');
}

/**
 * Load venue details column on single event
 */
function jce_add_single_event_venue(){
	jce_get_template_part('single-event/venue');
}

/**
 * Load organiser details column on single event
 */
function jce_add_single_event_organiser(){
    jce_get_template_part('single-event/organiser');
}

function jce_add_single_event_footer_meta(){
    jce_get_template_part('single-event/footer');
}

function jce_add_single_back_btn(){

	if(!is_single())
		return false;
	?>

	<?php if(wp_get_referer()): ?>
		<a href="<?php echo esc_url(wp_get_referer() ); ?>">&lt; Back to Events</a>
	<?php else: ?>

		<?php if(get_option('permalink_structure')): ?>
			<a href="<?php echo site_url('/events'); ?>">&lt; Back to Events</a>
		<?php else: ?>
			<a href="<?php echo site_url('?post_type=event'); ?>">&lt; Back to Events</a>
		<?php endif;
	endif;
}

function jce_output_daily_archive(){

	$year = get_query_var( 'cal_year' ) ? get_query_var( 'cal_year' ) : date('Y');
	$month = get_query_var( 'cal_month' ) ? get_query_var( 'cal_month' ) : date('m');
	$day = get_query_var( 'cal_day' ) ? get_query_var( 'cal_day' ) : date('d');

	// remove event archive
	remove_action('jce/before_event_archive', 'jce_output_event_filters', 11);

	echo "<div id=\"daily_ajax_response\">";
	echo do_shortcode('[jce_event_archive view="archive" year="'.$year.'" month="'.$month.'" day="'.$day.'" /]' );	
	echo "</div>";

	// re-add event archive
	add_action('jce/before_event_archive', 'jce_output_event_filters', 11);
}

function jce_output_widget_daily_archive(){

	$year = get_query_var( 'cal_year' ) ? get_query_var( 'cal_year' ) : date('Y');
	$month = get_query_var( 'cal_month' ) ? get_query_var( 'cal_month' ) : date('m');
	$day = get_query_var( 'cal_day' ) ? get_query_var( 'cal_day' ) : date('d');

	// remove event archive
	// remove_action('jce/before_event_archive', 'jce_output_event_filters', 11);

	echo "<div id=\"daily_ajax_response\">";
	echo do_shortcode('[jce_event_archive view="archive" year="'.$year.'" month="'.$month.'" day="'.$day.'" widget="1" /]' );	
	echo "</div>";

	// re-add event archive
	// add_action('jce/before_event_archive', 'jce_output_event_filters', 11);
}