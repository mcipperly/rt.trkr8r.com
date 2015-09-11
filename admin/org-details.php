<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
include ('../db/db.php');

if($_REQUEST['preset_id']) {
	$element_ids = get_export_preset($_REQUEST['preset_id']);

	$search['company_id'] = $_REQUEST['company_id'];
	
	$file_name = export_csv($element_ids, $search);
	Header("Location: ../export/{$file_name}");
}

$org = get_organization($_REQUEST['org_id']);

?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-th"></span>&nbsp;<a href="manage-orgs.php">Manage Organizations</a> <span class="fa fa-angle-right"></span>&nbsp;<?php print($org['name']); ?></h1>
    
<div class="row flexbox">
    <div class="eight cols callout">
        <h2 class="callout-title">Details <a href="#" class="edit-action"><span class="fa fa-wrench"></span>&nbsp;Edit</a></h2>
            
            <h3><?php print($org['name']); ?></h3>
            <h4><strong>Contact Name:</strong> <?php print($org['contact_name']); ?> &bull; <strong>Contact Details:</strong> <?php print($org['contact_details']); ?></h4>
            <p><?php print($org['description']); ?></p>
    </div> 
    
    <div class="four cols callout">
        <h2 class="callout-title">Stats</h2>
        
        <h3><strong>Volunteers: </strong> 2,500</h3>
        <h3 style="margin-top:15px;margin-bottom:15px;padding-bottom:17px;padding-top:17px;border-bottom:1px dotted #A5A5A5;border-top:1px dotted #A5A5A5"><strong>Hours:</strong> 2,500</h3>
        <h3><strong>Quick Export</strong></h3>
        <a href="#"><button class="m-full-width">All Fields</button></a> <a href="#"><button class="m-full-width">Postal Fields</button></a> <a href="#"><button class="m-full-width">Email Fields</button></a>
    </div>    
    
</div>
    
    
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Volunteers</h2>
            
        <div class="row">
            <table class="respond">
                
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