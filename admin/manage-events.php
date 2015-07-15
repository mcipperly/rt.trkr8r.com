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
            
            <div class="row">
                <div class="four cols">
                    <a href="#" class="event-box bkg-less-opaque">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols">
                    <a href="#" class="event-box bkg-less-opaque">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols">
                    <a href="#" class="event-box bkg-less-opaque">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
            </div>
        
    </div>   
</div>  
    
<div class="row" id="slider">
    <div class="twelve cols callout">
        <h2 class="callout-title">Open Events <a href="#" class="add-event"><span class="fa fa-plus-circle"></span>&nbsp;Add New Event</a></h2>
            
            <div class="row">
                <div class="four cols">
                    <a href="#" class="event-box bkg-more-opaque">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols">
                    <a href="#" class="event-box bkg-more-opaque">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols">
                    <a href="#" class="event-box bkg-more-opaque">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="four cols">
                    <a href="#" class="event-box bkg-more-opaque">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols">
                    <a href="#" class="event-box bkg-more-opaque">
                    <h3>Event Name</h3>
                    <h4>Date &bull; Location</h4>
                    <p class="desc">Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. </p>
                    </a>
                </div>
                <div class="four cols">
                    <a href="#" class="event-box bkg-more-opaque">
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
                <div class="row log_vol-name">
                    <div class="three cols">Event</div>
                    <div class="two cols">Date</div>
                    <div class="three cols">Volunteers</div>
                    <div class="two cols">Hours</div>
                    <div class="two cols"></div>
                </div>
                <div class="row log_vol-name">
                    <div class="three cols">Event Name</div>
                    <div class="two cols">00/00/00</div>
                    <div class="three cols">1000</div>
                    <div class="two cols">1000</div>
                    <div class="two cols"><button>Reopen</button></div>
                </div>
                <div class="row log_vol-name">
                    <div class="three cols">Event Name</div>
                    <div class="two cols">00/00/00</div>
                    <div class="three cols">1000</div>
                    <div class="two cols">1000</div>
                    <div class="two cols"><button>Reopen</button></div>
                </div>
                <div class="row log_vol-name">
                    <div class="three cols">Event Name</div>
                    <div class="two cols">00/00/00</div>
                    <div class="three cols">1000</div>
                    <div class="two cols">1000</div>
                    <div class="two cols"><button>Reopen</button></div>
                </div>
        
    </div>   
</div>  

<?php include ('../includes/footer.php'); ?>