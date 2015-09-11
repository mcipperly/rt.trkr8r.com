<?php
include '../includes/admin-header.php';
include 'validate.php';
include '../includes/admin-sidebar.php';
include '../db/db.php';
?>

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$('.eventslide').slick({
    infinite: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    centerPadding: '0px',
    prevArrow: '.slick-prev',
    nextArrow: '.slick-next'
  });
$('.aeventslide').slick({
  infinite: false,
  slidesToShow: 1,
  slidesToScroll: 1,
  centerPadding: '0px',
  prevArrow: '.slick-prev-a',
  nextArrow: '.slick-next-a'
})
});
function getMoreEvents(lastEvent,qt) {
  if(qt=="a") {
    var openEventsDiv = document.getElementById("a_events_" + (lastEvent-3));
    var startDate = new Date(new Date().setDate(new Date().getDate()-3650));
    var endDate = new Date(new Date().setDate(new Date().getDate()-1));
    var dateQuery = '&start_date='+startDate.toISOString().slice(0, 10)+'&end_date='+endDate.toISOString().slice(0, 10);
    var numQuery = '&count=3';
    var sliderId = '.aeventslide';
    var colorClass = 'bkg-less-opaque';
  } else {
    var openEventsDiv = document.getElementById("events_" + (lastEvent-6));
    var dateQuery = '';
    var numQuery = '&count=6';
    var sliderId = '.eventslide';
    var colorClass = 'bkg-more-opaque';
  }
  $.getJSON("get-events.php?status_id=1"+dateQuery+numQuery+"&offset="+lastEvent, function(json){
    var html = '<div id="events_'+lastEvent+'"><div class="row flexbox">';
    var iter = 0;
    $.each(json, function (key, val) {
      if(key==3) {
        html+= '</div><div class="row flexbox">';
      }
      if(val.note.length>100) {
        val.note = val.note.substring(0, 100)+" (cont.)";
      }
      html += '<div class="four cols '+colorClass+'"><a href="event-details.php?event_id='+val.event_id+'" class="event-box"><h3>'+val.location+'</h3><h4>'+val.date+'</h4><p class="desc">'+val.note+'</p></div>';
      iter = key;
    });
    iter++;
    while(iter%3 != 0) {
      html += '<div class="four cols"></div>';
      iter++;
    }
    html += '</div></div>';
    if(json.length!=0) {
      $(sliderId).slick('slickAdd',html);
    }
  });
}
$(function(){
  $('.slick-next').click( function(){
    lastEvent = typeof(lastEvent) == 'undefined' ? 12 : lastEvent + 6;
    getMoreEvents(lastEvent);
  });
  $('.slick-next-a').click( function(){
    aLastEvent = typeof(aLastEvent) == 'undefined' ? 6 : aLastEvent + 3;
    getMoreEvents(aLastEvent,"a");
  });
});
</script>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-calendar"></span>&nbsp;Manage Events<button class="m-full-width add-action"><span class="fa fa-plus-circle"></span>&nbsp;Add New Event</button></h1>

    
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Events Pending Completion</h2>
        <div class="aeventslide">
          <div id="events_0" class="flexbox">

            <div class="row">
              <?php
              // get two panels worth of actionable events from the db
              $start_date = date_create();
              $end_date = date_create();
              date_sub($start_date, date_interval_create_from_date_string('10 years'));
              date_sub($end_date, date_interval_create_from_date_string('1 day'));
              $a_events_opts = array(
                status_id => 1,
                count => 6,
                start_date => date_format($start_date, "Y-m-d"),
                end_date => date_format($end_date, "Y-m-d")
              );
              $a_events = get_events($a_events_opts);
              foreach($a_events as $key => $event) {
                if ($key == 3) {
                  ?></div></div><div id="a_events_3"><div class="row flexbox"><?php
                }
                ?><div class="four cols bkg-less-opaque">
                    <a href="event-details.php?event_id=<?php print($event['event_id']) ?>" class="event-box">
                      <h3><?php print($event['location']) ?></h3>
                      <h4><?php print($event['date']) ?></h4>
                      <p class="desc"><?php print($event['note']) ?></p>
                    </a>
                  </div><?php
              }
               ?>
             </div>
           </div>
          </div>
              <div class="slick-prev-a left"><a href="#"><span class="fa fa-arrow-circle-left"></span> Previous</a></div>
          <div class="slick-next-a right"><a href="javascript:getMoreEvents(lastEvent,a);">More <span class="fa fa-arrow-circle-right"></span></a></div>

    </div>
</div>
<div class="row">
    <div class="twelve cols callout" id="openevents">
        <h2 class="callout-title">Open Events</h2>
          <div class="eventslide">
            <div id="events_0">
              <div class="row flexbox">
            <?php
            // get two panels worth of data from the db on load, fetch the rest lazily
            $o_events_opts = array(
              status_id => 1,
              count => 12
            );
            $o_events = get_events($o_events_opts);
            foreach($o_events as $key => $event) {
              if ($key == 3 || $key == 9) {
                ?></div>
                <div class="row flexbox"><?php
              }
              if ($key == 6) {
                ?></div></div><div id="events_6"><div class="row flexbox"><?php
              }
              ?><div class="four cols bkg-more-opaque">
                  <a href="event-details.php?event_id=<?php print($event['event_id']) ?>" class="event-box">
                    <h3><?php print($event['location']) ?></h3>
                    <h4><?php print($event['date']) ?></h4>
                    <p class="desc"><?php print($event['note']) ?></p>
                  </a>
                </div><?php
            }
             ?>
           </div>
         </div>
        </div>
            <div class="slick-prev left"><a href="#"><span class="fa fa-arrow-circle-left"></span> Previous</a></div>
        <div class="slick-next right"><a href="javascript:getMoreEvents(lastEvent);">More <span class="fa fa-arrow-circle-right"></span></a></div>

    </div>
</div>

<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Completed Events</h2>
            <table class="respond">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Vols.</th>
                        <th>Hours</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
<?php

//Get the three most recent closed events
$search['status_id'] = 2; //Closed
$search['sort_dir'] = 1; //DESC
$search['count'] = 3;
$events = get_events($search);

foreach($events as $event) {
	$event_date = date("m/d/Y", strtotime($event['date']));
	$event_vols = number_format($event['totals']['volunteers']);
	$event_dur = number_format($event['totals']['duration'], 2);
	$html = <<<EOS
                    <tr>
                        <td data-label="Event">{$event['location']}</td>
                        <td data-label="Date">{$event_date}</td>
                        <td data-label="Volunteers">{$event_vols}</td>
                        <td data-label="Hours">{$event_dur}</td>
                        <td data-label="Details"><a href="event-details.php?event_id={$event['event_id']}"><button>View</button></a></td>
                    </tr>
EOS;
	print($html);
}

?>
                </tbody>
            </table>
           <div class="right"><a href="completed-events.php">More <span class="fa fa-arrow-circle-right"></span></a></div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
