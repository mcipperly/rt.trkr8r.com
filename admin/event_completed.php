<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-calendar"></span>&nbsp;<a href="manage-events.php">Manage Events</a> <span class="fa fa-angle-right"></span>&nbsp;This is a Completed Event</h1>
    
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Details</h2>
            
        <div class="row">
            <h3>This is a Completed Event</h3>
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
                <a href="#"><button class="btn btn-closed">Event is Completed</button></a> <a href="#"><button class="btn btn-open-outline">Reopen Event</button></a>
                <p><small><em>Marking this event as complete will add it to the Completed Events page. You will
    no longer be able to make additional changes unless you reopen the event.</em></small></p>
            </div>
            
            <div class="four cols">
                <h3 class="phone-space-top">Quick Export</h3>
                <a href="#"><button>All Fields</button></a> <a href="#"><button>Mailing Fields</button></a> <a href="#"><button>eNewsletter Fields</button></a>
            </div>            
        </div>   
    </div>  
</div>

<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Volunteers</h2>
            
        <div class="row">
            <table>
                
                <thead>
                    <tr>
                        <th class="print_details"></th>
                        <th>Volunteer Name</th>
                        <th>Affiliation</th>
                        <th>Hours</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Affiliation">Affiliation</td>
                        <td data-label="Hours">8.00</td>
                    </tr>
                    
                    
                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Affiliation">Affiliation</td>
                        <td data-label="Hours">8.00</td>
                    </tr>
                    
                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Affiliation">Affiliation</td>
                        <td data-label="Hours">8.00</td>
                    </tr>

                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Affiliation">Affiliation</td>
                        <td data-label="Hours">8.00</td>
                    </tr>
                </tbody>
            </table>            
        </div>
        
        
    </div>  
</div>
    
<div>
    <div class="left"><a href="manage-events.php"><span class="fa fa-calendar"></span> Back to Manage Events</a></div>
    <div class="clear"></div>
</div>  
    
<?php include ('../includes/footer.php'); ?>