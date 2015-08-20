<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-home"></span>&nbsp;Dashboard</h1>
<div class="row flexbox">
    <div class="four cols callout">
        <h2 class="callout-title">This Month's Volunteers</h2>
        <p class="text"><span class="fa fa-user left dash"></span><span class="right stroke-text">2,500</span></p>
    </div>

    <div class="four cols callout">
        <h2 class="callout-title">Volunteers to Date</h2>
        <p class="text"><span class="fa fa-users left dash "></span><span class="right stroke-text">2,500</span></p>
    </div>  
    
    <div class="four cols callout">
        <h2 class="callout-title">Hours to Date</h2>
        <p class="text"><span class="fa fa-clock-o dash left"></span><span class="right stroke-text">2,500</span></p>
    </div> 
    <div class="clear"></div>
</div>

    
<div class="row">
    <div class="six cols callout">
    <h2 class="callout-title">Top Volunteers</h2>
        <ol class="list-group">
            <li>Volunteer NameHere</li>
            <li>Volunteer NameHere</li>
            <li>Volunteer NameHere</li>
        </ol>
    </div>   
    
    <div class="six cols callout">
    <h2 class="callout-title">Top Organizations</h2>
        <ol class="list-group">
            <li><a href="#">Organization NameHere</a></li>
            <li><a href="#">Organization NameHere</a></li>
            <li><a href="#">Organization NameHere</a></li>
        </ol>
    </div>    
</div>  
    <div class="row">
 <div class="eight cols callout">
    <h2 class="callout-title">Your Events</h2>
    <div class="row">
        <div class="six cols">
        <h3>Open</h3>
            <ul class="list-group">
                <li><a href="#">Event NameHere</a></li>
                <li><a href="#">Event NameHere</a></li>
                <li><a href="#">Event NameHere</a></li>
                <li><a href="#">Event NameHere</a></li>
                <li><a href="#">Event NameHere</a></li>
            </ul>
         </div>
        <div class="six cols">
        <h3>Completed</h3>
            <ul class="list-group">
                <li><a href="#">Event NameHere</a></li>
                <li><a href="#">Event NameHere</a></li>
                <li><a href="#">Event NameHere</a></li>
                <li><a href="#">Event NameHere</a></li>
                <li><a href="#">Event NameHere</a></li>
            </ul>
         </div>
    </div>
    </div>    
    
    <div class="four cols callout">
    <h2 class="callout-title">Quick Export</h2>
    <h3>Today's Data</h3>
     <a href="#"><button>All Fields</button></a> <a href="#"><button>Postal Fields</button></a> <a href="#"><button>Email Fields</button></a>   
        <br><br>
    <h3>Yesterday's Data</h3>
    <a href="#"><button>All Fields</button></a> <a href="#"><button>Postal Fields</button></a> <a href="#"><button>Email Fields</button></a>
    </div>    
    
</div>   

    </div>

<?php include ('../includes/footer.php'); ?>
