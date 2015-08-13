<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-th"></span>&nbsp;<a href="manage-orgs.php">Manage Organizations</a> <span class="fa fa-angle-right"></span>&nbsp;Sample Organization Detail Page</h1>
    
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Details <a href="#" class="add-event"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>
            
        <div class="row">
            <h3>Organization Name</h3>
            <h4><strong>Contact Name:</strong> Contact Name &bull; <strong>Contact Details:</strong> Phone or Email</h4>
            <p>Description lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. 
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta, at eleifend. Dolor sit 
    amet, consectetur adipiscing elit. Ut sollicitudin risus congue ipsum porta.</p>
        </div>   
    </div>  
</div>

<div class="row flexbox">

            <div class="three cols callout">
                <h2 class="callout-title"><span class="fa fa-users"></span>&nbsp;Volunteers to Date</h2>
                <p class="lrg-text">2,500</p>
            </div>  


            <div class="three cols callout">
                <h2 class="callout-title"><span class="fa fa-clock-o"></span>&nbsp;Hours to Date</h2>
                <p class="lrg-text">2,500</p>
            </div> 

            
            <div class="six cols callout">
                <h2 class="callout-title">Quick Export</h2>
                <a href="#"><button>All Fields</button></a> <a href="#"><button>Postal Fields</button></a> <a href="#"><button>Email Fields</button></a>
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
                        <th>Hours</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Hours">8.00</td>
                    </tr>
                    
                    
                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Hours">8.00</td>
                    </tr>
                    
                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Hours">8.00</td>
                    </tr>

                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Hours">8.00</td>
                    </tr>
                </tbody>
            </table>            
        </div>
        
        
    </div>  
</div>
    
<div>
    <div class="left"><a href="manage-orgs.php"><span class="fa fa-th"></span> Back to Manage Organizations</a></div>
    <div class="clear"></div>
</div>  
    
<?php include ('../includes/footer.php'); ?>