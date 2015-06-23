<?php
include ('../includes/admin-header.php'); 
include('validate.php');
include ('../includes/admin-sidebar.php'); 
require_once('../db/db.php');

if($_REQUEST['today'] || $_REQUEST['export']) {
	if($_REQUEST['preset_id'])
		$preset_id = $_REQUEST['preset_id'];
	elseif($_REQUEST['today'])
		$preset_id = 1;
	else
		$preset_id = 0;
	
	$element_ids = ($preset_id) ? get_export_preset($preset_id) : $_REQUEST['element_ids'];

	if($_REQUEST['service_date'])
		$service_date = $_REQUEST['service_date'];
	elseif($_REQUEST['today'])
		$service_date = date("Y-m-d");
	else
		$service_date = date("Y-m-d");
	
	$file_name = export_csv($element_ids, $service_date);
	Header("Location: ../export/{$file_name}");
}

?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-file-excel-o"></span>&nbsp;Export Records</h1>

<div class="row">
 <div class="twelve cols callout">
    <h2 class="callout-title">Create Custom .CSV File</h2>
    
     <h3>Date Range</h3>
        <script>
            $(function() {
            $( "#datepicker" ).datepicker();
            });
        </script>

        <form method="POST">
        <div class="row">
            <div class="four cols">
                <input class="full-width" type="text" id="datepicker" name="service_date" value="{$readable_service_date}"/>
            </div>
            
            <div class="one cols">
                <p style="text-align: center;">to</p>            
            </div>
            
            <div class="four cols">
                <input class="full-width" type="text" id="datepicker" name="service_date" value="{$readable_service_date}"/>
            </div>
            
            <div class="three cols">
                <input type="submit" value="Go" class="full-width no-min">
            </div>
        </div>
        </form>
     
        <h3>Quick Export</h3>
        <form method="GET">
            <input type="hidden" name="export" value="true"></input>
            <div class="row">
                <div class="four cols">
                <input type="checkbox" id="checkmaster" onClick="toggleAll()">&nbsp;Export All Fields
                </div>
                <div class="four cols">
                <input type="checkbox" id="mcbox" name="preset_id" value="2" onclick="toggleOther(this,'mailbox')">&nbsp;Export for eNewsletter
                </div>
                <div class="four cols">
                <input type="checkbox" id="mailbox" name="preset_id" value="3" onclick="toggleOther(this,'mcbox')">&nbsp;Export For Mailers
                </div>
            </div>
     <br>
        <h3>Or Custom Export</h3>
            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="1">&nbsp;First Name
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="2">&nbsp;Last Name
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="3">&nbsp;Age
                </div>
            </div>

            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="10">&nbsp;Phone
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="11">&nbsp;Email
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="13">&nbsp;Future Interest
                </div>
            </div>

            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="5">&nbsp;Address
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="6">&nbsp;Apt/Suite/Floor
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="7">&nbsp;City
                </div>
            </div>


            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="8">&nbsp;State
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="9">&nbsp;ZIP
                </div>
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="4">&nbsp;Affiliation or Company
                </div>
            </div>

            <div class="row">
                <div class="four cols">
                <input type="checkbox" name="element_ids[]" value="12">&nbsp;Skills
                </div>
                <div class="four cols">
                </div>
                <div class="four cols">
                </div>
            </div>
     <br>
            <input type="submit" value="Export">
        </form>
        <script type="text/javascript">
        function toggleAll() {
          var x = document.getElementsByName('element_ids[]');
          var cm = document.getElementById('checkmaster');
          var i;
          for (i = 0; i < x.length; i++) {
              if (x[i].type == "checkbox") {
                  x[i].checked = cm.checked;
              }
          }
        }
        function toggleOther(master,other) {
          var oth = document.getElementById(other);
          if(master.checked) {
            oth.checked = false;
          }
        }

        </script>

<?php include ('../includes/footer.php'); ?>
