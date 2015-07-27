<!-- ROB, I DIDNT ADD IN THE MANAGE HOURS PROGRAMMING STUFF SINCE I DIDNT KNOW IF
THIS WOULD CHANGE SINCE WE ARE NOW LOOKING IT UP DIFFERENTLY, BY EVENT. 
I DID NOT DELETE THE MANAGEHOURS.PHP PAGE SHOULD YOU NEED TO PULL FROM THAT
-->
<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-calendar"></span>&nbsp;<a href="manage-events.php">Manage Events</a> <span class="fa fa-angle-right"></span>&nbsp;Open Event That Requires Action</h1>
    
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Details <a href="#" class="add-event"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>
            
        <div class="row">
            <h3>Open Event That Requires Action</h3>
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
                <a href="#"><button>All Fields</button></a> <a href="#"><button>Mailing Fields</button></a> <a href="#"><button>eNewsletter Fields</button></a>
            </div>            
        </div>   
    </div>  
</div>
    
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Volunteers</h2>
            
        <div class="row">
            <h3>Update ALl Volunteer Stats</h3>
            <form>
            <div class="row">
                <div class="five cols">
                    <select class="full-width">
                    <option value="Organization/Affiliation">Organization/Affiliation</option>
                      <option value="K&amp;L Gates">K&amp;L Gates</option>
                      <option value="American Eagle">American Eagle</option>
                      <option value="Davison">Davison</option>
                    </select>
                </div>
                <div class="five cols">
                <input type="text" class="full-width" id="logged_hours" name="logged_hours" value="" placeholder="Hours (example: 8.00)" />
                </div>               
                <div class="two cols">
                <input type="submit" value="Apply" class="btn full-width no-min">
                </div>
            </div>
            </form>
            
            <h3><small>OR</small> Update Individual Volunteer Stats</h3>
            <form>
            <table>
                <tbody>
                    
                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Org/Affiliation">
                            <select>
                                <option value="K&amp;L Gates">K&amp;L Gates</option>
                                <option value="American Eagle">American Eagle</option>
                                <option value="Davison">Davison</option>
                            </select>
                        </td>
                        <td data-label="Hours"><input type="text" id="logged_hours" name="logged_hours" value="8.00"/></td>
                    </tr>
                    
                    
                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Org/Affiliation">
                            <select>
                                <option value="K&amp;L Gates">K&amp;L Gates</option>
                                <option value="American Eagle">American Eagle</option>
                                <option value="Davison">Davison</option>
                            </select>
                        </td>
                        <td data-label="Hours"><input type="text" id="logged_hours" name="logged_hours" value="8.00"/></td>
                    </tr>
                    
                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Org/Affiliation">
                            <select>
                                <option value="K&amp;L Gates">K&amp;L Gates</option>
                                <option value="American Eagle">American Eagle</option>
                                <option value="Davison">Davison</option>
                            </select>
                        </td>
                        <td data-label="Hours"><input type="text" id="logged_hours" name="logged_hours" value="8.00"/></td>
                    </tr>

                    <tr>
                        <td data-label="Print Details" class="print_details"><a href="#"><span class="fa fa-print fa-lg"></span></a></td>
                        <td data-label="Volunteer Name">Volunteer Name</td>
                        <td data-label="Org/Affiliation">
                            <select>
                                <option value="K&amp;L Gates">K&amp;L Gates</option>
                                <option value="American Eagle">American Eagle</option>
                                <option value="Davison">Davison</option>
                            </select>
                        </td>
                        <td data-label="Hours"><input type="text" id="logged_hours" name="logged_hours" value="8.00"/></td>
                    </tr>
                </tbody>
            </table>
                <input type="submit" class="btn right" value="Update Stats">
            </form>            
        </div>
        
        
    </div>  
</div>
    
<div>
    <div class="left"><a href="manage-events.php"><span class="fa fa-calendar"></span> Back to Manage Events</a></div>
    <div class="clear"></div>
</div>  
    
<?php include ('../includes/footer.php'); ?>