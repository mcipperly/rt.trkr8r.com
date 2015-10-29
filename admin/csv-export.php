<?php
include('validate.php');
require_once('../db/db.php');
if($_REQUEST['element_ids'] || $_REQUEST['preset_id']) {
        $element_ids = ($_REQUEST['preset_id']) ? get_export_preset($_REQUEST['preset_id']) : $_REQUEST['element_ids'];
        if($_REQUEST['event_id'])
                $search['event_id'] = $_REQUEST['event_id'];
        if(isset($_REQUEST['org_ids']) && !($_REQUEST['event_id'] || $_REQUEST['start_date']))
                $search['org_ids'] = $_REQUEST['org_ids'];
        if($_REQUEST['start_date'] && $_REQUEST['end_date']) {
                $search['start_date'] = $_REQUEST['start_date'];
                $search['end_date'] = $_REQUEST['end_date'];
        }
        $csv_content = export_csv($element_ids, $search);
}

Header("Content-type: application/octet-stream");
Header("Content-Disposition: attachment; filename=\"export-" . time() . ".csv\"");
if (isset($csv_content) && !(empty($csv_content))) {
        print($csv_content);
} else {
        print("No data was available for export");
}
?>
