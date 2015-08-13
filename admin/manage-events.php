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
});
function getMoreEvents(lastEvent) {
  var openEventsDiv = document.getElementById("events_" + (lastEvent-6));
  $.getJSON("get-events.php?status_id=1&count=6&offset="+lastEvent, function(json){
    var html = '<div id="events_'+lastEvent+'"><div class="row flexbox">';
    $.each(json, function (key, val) {
      if(key==3) {
        html+= '</div><div class="row flexbox">';
      }
      html += '<div class="four cols bkg-more-opaque"><a href="event_noaction.php?id='+val.event_id+'" class="event-box"><h3>'+val.location+'</h3><h4>'+val.date+'</h4><p class="desc">'+val.note+'</p></div>';
    });
    html += '</div></div>';
    if(json.length!=0) {
      $('.eventslide').slick('slickAdd',html);
    }
  });
}
$(function(){
  $('.slick-next').click( function(){
    lastEvent = typeof(lastEvent) == 'undefined' ? 12 : lastEvent + 6;
    getMoreEvents(lastEvent);
  });
});
</script>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-calendar"></span>&nbsp;Manage Events</h1>

<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Events Pending Completion</h2>

            <div class="row flexbox">
                <div class="four cols bkg-less-opaque">
                    <a href="event_action.php" class="event-box">
                    <h3>Open Event That Requires Action</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols bkg-less-opaque">
                    <a href="#" class="event-box">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols bkg-less-opaque">
                    <a href="#" class="event-box">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
            </div>

    </div>
</div>

<div class="row">
    <div class="twelve cols callout" id="openevents">
        <h2 class="callout-title">Open Events <a href="#" class="add-event"><span class="fa fa-plus-circle"></span>&nbsp;Add New Event</a></h2>
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
                  <a href="event_noaction.php?id=<?php print($event['event_id']) ?>" class="event-box">
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

            <table>
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

                    <tr>
                        <td data-label="Event">This is a Completed Event</td>
                        <td data-label="Date">00/00/00</td>
                        <td data-label="Volunteers">1,000</td>
                        <td data-label="Hours">100,000</td>
                        <td data-label="Details"><a href="event_completed.php"><button>View</button></a></td>
                    </tr>


                    <tr>
                        <td data-label="Event">Event Name</td>
                        <td data-label="Date">00/00/00</td>
                        <td data-label="Volunteers">1,000</td>
                        <td data-label="Hours">100,000</td>
                        <td data-label="Details"><a href="#"><button>View</button></a></td>
                    </tr>

                    <tr>
                        <td data-label="Event">Event Name</td>
                        <td data-label="Date">00/00/00</td>
                        <td data-label="Volunteers">1,000</td>
                        <td data-label="Hours">100,000</td>
                        <td data-label="Details"><a href="#"><button>View</button></a></td>
                    </tr>
                </tbody>
            </table>
           <div class="right"><a href="completed-events.php">More <span class="fa fa-arrow-circle-right"></span></a></div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
