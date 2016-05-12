<?php
include('validate.php');
require_once('../db/db.php');

if($_REQUEST['email']) {
        $volunteer_id = validate_volunteer_email($_REQUEST['email']);
        if($volunteer_id)
                Header("Location: ../signature.php?view=1&vid={$volunteer_id}");
        else
                $no_volunteer = true;
}
elseif($_REQUEST['firstname'] || $_REQUEST['lastname']) {
        $volunteer_id = find_volunteer($_REQUEST);
        if($volunteer_id)
                Header("Location: ../signature.php?view=1&vid={$volunteer_id}");
        else
                $no_volunteer = true;
}

include ('../includes/admin-header.php');
include ('../includes/admin-sidebar.php');

?>

<div class="container">
<div class="admin-content-wrapper">
<h1 class="admin-page-title"><span class="fa fa-heart"></span>&nbsp;Manage Volunteers</h1>
<?php
if($no_volunteer) {
	$html = <<<EOS
		<div class="row"><div class="twelve cols callout failure">No Volunteers Found With Those Search Terms</div></div>
EOS;
	print($html);
}
?>
<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Find a Volunteer</h2>
        <form method="POST" target="_blank">
            <div class="row">
                <div class="five cols">
                <input type="text" class="full-width" name="firstname" placeholder="First Name">
                </div>

                <div class="five cols">
                <input type="text" class="full-width" name="lastname" placeholder="Last Name">
                </div>

                <div class="two cols">
                <input type="submit" value="Search" class="full-width no-min">
                </div>
            </div>
        </form>

    </div>
</div>

<div class="row">
    <div class="twelve cols callout">
        <h2 class="callout-title">Search Results</h2>
        <form>
        <table class="respond manage-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Merge This</th>
                        <th>Into This</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td data-label="Name"><a href="volunteer-details.php"><span class="manage-table--break">Name McNameface</span>&nbsp;&nbsp;<span class="fa fa-angle-right"></span></a></td>
                        <td data-label="Email">Email@email.com</td>
                        <td data-label="Merge This"><input type="checkbox" /></td>
                        <td data-label="Into This"><input type="radio" /></td>
                    </tr>

                </tbody>
            </table>
        <input type="button" class="right m-full-width" value="Merge Selected Volunteers" />
        </form>
    </div>
</div>
    
<?php include ('../includes/footer.php'); ?>
