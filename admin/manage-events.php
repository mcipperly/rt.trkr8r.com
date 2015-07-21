<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
?>

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
    <div class="twelve cols callout">
        <h2 class="callout-title">Open Events <a href="#" class="add-event"><span class="fa fa-plus-circle"></span>&nbsp;Add New Event</a></h2>
            
            <div class="row flexbox">
                <div class="four cols bkg-more-opaque">
                    <a href="event_noaction.php" class="event-box">
                    <h3>This is an Open Event</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols bkg-more-opaque">
                    <a href="#" class="event-box">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols bkg-more-opaque">
                    <a href="#" class="event-box">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
            </div>
            <div class="row flexbox">
                <div class="four cols bkg-more-opaque">
                    <a href="#" class="event-box">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols bkg-more-opaque">
                    <a href="#" class="event-box">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols bkg-more-opaque">
                    <a href="#" class="event-box">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
            </div> 
        <div class="right"><a href="#">More <span class="fa fa-arrow-circle-right"></span></a></div>
 
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

<?php include ('../includes/footer.php'); ?>