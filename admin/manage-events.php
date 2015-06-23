<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-calendar"></span>&nbsp;Manage Events</h1>


    
<!--Active and Inactive Events -->
<div class="row">
 <div class="six cols callout">
    <h2 class="callout-title">Active Events</h2>
        <ul class="list-group edit-links">
            <li><a href="#">Event NameHere</a></li>
            <li><a href="#">Event NameHere</a></li>
            <li><a href="#">Event NameHere</a></li>
            <li><a href="#">Event NameHere</a></li>
            <li><a href="#">Event NameHere</a></li>
        </ul>
    </div>
    
    <div class="six cols callout">
    <h2 class="callout-title">Inactive Events</h2>
        <ul class="list-group inactive edit-links">
            <li><a href="#">Event NameHere</a></li>
            <li><a href="#">Event NameHere</a></li>
            <li><a href="#">Event NameHere</a></li>
            <li><a href="#">Event NameHere</a></li>
            <li><a href="#">Event NameHere</a></li>
        </ul>
    </div>   
</div>  
    
    <a href="#"><button class="right"><span class="fa fa-plus-circle"></span>&nbsp;Add New Event</button></a>
    <div class="clear"></div>

</div>

<?php include ('../includes/footer.php'); ?>