<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-calendar"></span>&nbsp;<a href="manage-events.php">Manage Events</a> <span class="fa fa-angle-right"></span>&nbsp;This is an Open Event</h1>
    
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Details <a href="#" class="add-event"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>
            
        <div class="row">
            <h3>This is an Open Event</h3>
            <h4>Date &bull; Location</h4>
            <p>Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. 
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. Dolor sit 
    amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta.</p>
        </div>   
    </div>  
</div>

<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Manage</h2>
            
        <div class="row">
            <div class="eight cols">
                <h3>Status</h3>
                <a href="#"><button class="btn-open">Event is Open</button></a> <a href="#"><button class="btn-closed-outline">Mark as Complete</button></a>
                <p><small><em>Marking this event as complete will add it to the Completed Events page. You will
    no longer be able to make additional changes unless you reopen the event.</em></small></p>
            </div>
            
            <div class="four cols">
                <h3 class="phone-space-top">Quick Export</h3>
                <a href="#"><button>All Fields</button></a> <a href="#"><button>Postal Fields</button></a> <a href="#"><button>Email Fields</button></a>
            </div>            
        </div>   
    </div>  
</div>
    
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Volunteers</h2>
            
        <div class="row">
            <p>This event hasn’t happened yet! Check back after your event date to view volunteers for this event and
manage their affiliations and hours.</p>
        </div>   
    </div>  
</div>
    
<div>
    <div class="left"><a href="manage-events.php"><span class="fa fa-calendar"></span> Back to Manage Events</a></div>
    <div class="clear"></div>
</div>  
    
<?php include ('../includes/footer.php'); ?>