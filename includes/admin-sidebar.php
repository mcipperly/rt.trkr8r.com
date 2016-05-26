<div class="admin-header-wrapper">
<div class="admin-header-bar">

    <h1 class="left">
    <!-- Menu toggle -->
    <a href="#toggle-menu" id="toggle-menu" class="toggle-menu">
    <i class="fa fa-bars"></i>
    </a>
        <?php print($site_org) ?></h1>
    <nav class="right hidden-phone">
        <ul>
            <li><a href="/admin/logout.php"><span class="fa fa-power-off"></span>&nbsp;&nbsp;Logout</a></li>
            <?php
            $search['date'] = date("Y-m-d");
            $events = get_events($search);
            if(count($events) != 0) { ?>
            <li><a href="/admin/onsite.php"><span class="fa fa-toggle-off"></span>&nbsp;&nbsp;Activate On-Site Mode</a></li>
            <?php } ?>
        </ul>
    </nav>
</div>
</div>

<!-- Start Admin Sidebar Nav -->
<div class="admin-sidebar" id="admin-sidebar">
    <nav>
        <ul>
            <li><a href="/admin/"><span class="fa fa-home"></span>&nbsp;&nbsp;Dashboard</a></li>
            <!--<li><a href="/admin/manage-form.php"><span class="fa fa-gear"></span>&nbsp;&nbsp;Manage Form</a></li>-->
            <li><a href="/admin/export-records.php"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;Export Records</a></li>
            <li><a href="/admin/manage-events.php"><span class="fa fa-calendar"></span>&nbsp;&nbsp;Manage Events</a></li>
            <li><a href="/admin/manage-volunteers.php"><span class="fa fa-heart"></span>&nbsp;&nbsp;Manage Volunteers</a></li>
            <li><a href="/admin/manage-orgs.php"><span class="fa fa-th"></span>&nbsp;&nbsp;Manage Organizations</a></li>
            <li><a href="/admin/manage-users.php"><span class="fa fa-group"></span>&nbsp;&nbsp;Manage Users</a></li>
            <!--<li><a href="#api"><span class="fa fa-paint-brush"></span>&nbsp;&nbsp;Customize Theme</a></li>-->
            <?php
            if(count($events) != 0) { ?>
            <li><a href="/admin/onsite.php"><span class="fa fa-toggle-off"></span>&nbsp;&nbsp;Activate On-Site Mode</a></li>
            <?php } ?>
            <li><a href="/admin/logout.php"><span class="fa fa-power-off"></span>&nbsp;&nbsp;Logout</a></li>
        </ul>
    </nav>
</div>
<!-- End Admin Sidebar Nav -->
