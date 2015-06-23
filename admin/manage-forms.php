<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-gear"></span>&nbsp;Manage Forms</h1>

<!--Active and Inactive Forms -->
<div class="row">
 <div class="six cols callout">
    <h2 class="callout-title">Active Forms</h2>
        <ul class="list-group edit-links">
            <li><a href="#">Form NameHere</a></li>
            <li><a href="#">Form NameHere</a></li>
            <li><a href="#">Form NameHere</a></li>
            <li><a href="#">Form NameHere</a></li>
            <li><a href="#">Form NameHere</a></li>
        </ul>
    </div>
    
    <div class="six cols callout">
    <h2 class="callout-title">Inactive Forms</h2>
        <ul class="list-group inactive edit-links">
            <li><a href="#">Form NameHere</a></li>
            <li><a href="#">Form NameHere</a></li>
            <li><a href="#">Form NameHere</a></li>
            <li><a href="#">Form NameHere</a></li>
            <li><a href="#">Form NameHere</a></li>
        </ul>
    </div>   
</div>  
    
    <a href="#"><button class="right"><span class="fa fa-plus-circle"></span>&nbsp;Add New Form</button></a>
    <div class="clear"></div>
    
</div>

<?php include ('../includes/footer.php'); ?>