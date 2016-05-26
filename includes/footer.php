<script type="text/javascript">
function adminLogin() {
vex.dialog.open({
  message: 'Please Log in:',
  input: '<div class=\"vex-custom-input-wrapper\">\n<input name=\"user\" type=\"text\" placeholder=\"Username\" autocomplete=\"off\"></div><div class=\"vex-custom-input-wrapper\"><input name=\"pass\" type=\"password\" placeholder=\"Password\" autocomplete=\"off\"></div>',
  callback: function(data) {
    if (data === false) {
      return console.log('Cancelled');
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange=function() {
      if (xhr.readyState==4 && xhr.status==200) {
        if (xhr.responseText==1) {
          onsiteModeModal();
        } else {
          adminLoginFail();
        }
      }
    }
    xhr.open('POST','/admin_login.php',true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('user='+data.user+'&pass='+data.pass);
  }
});
}
function adminLoginFail() {
vex.dialog.open({
  message: '<div style="color:#FF0000">Authentication Failed, please try again:</div>',
  input: '<div class=\"vex-custom-input-wrapper\">\n<input name=\"user\" type=\"text\"></div><div class=\"vex-custom-input-wrapper\"><input name=\"pass\" type=\"password\"></div>',
  callback: function(data) {
    if (data === false) {
      return console.log('Cancelled');
    }
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange=function() {
      if (xhr.readyState==4 && xhr.status==200) {
        if (xhr.responseText==1) {
          onsiteModeModal();
        } else {
          adminLoginFail();
        }
      }
    }
    xhr.open('POST','/admin_login.php',true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('user='+data.user+'&pass='+data.pass);
  }
});
}

<?php
$search['date'] = date("Y-m-d");
$events = get_events($search);
?>

function onsiteModeModal() {
vex.dialog.open({
  message: 'Login successful - select destination:',
  buttons: [
      $.extend({}, vex.dialog.buttons.NO, { className: 'vex-dialog-button-primary', text: 'Admin Page', click: function($vexContent, event) {
          $vexContent.data().vex.value = 'adminpage';
          vex.close($vexContent.data().vex.id);
      }}),
      <?php if(count($events) == 0) {
        ?>
      $.extend({}, vex.dialog.buttons.NO, { className: 'vex-dialog-button-secondary', text: 'On-site Mode' }),
      <?php } else { ?>
      $.extend({}, vex.dialog.buttons.NO, { className: 'vex-dialog-button-primary', text: 'On-site Mode', click: function($vexContent, event) {
          $vexContent.data().vex.value = 'onsite';
          vex.close($vexContent.data().vex.id);
      }}),
      <?php } ?>
      $.extend({}, vex.dialog.buttons.NO, { className: 'vex-dialog-button-primary', text: 'Logout', click: function($vexContent, event) {
          window.location.replace('/admin/logout.php');
      }})
  ],
  callback: function(data) {
    var xhra = new XMLHttpRequest();
    xhra.onreadystatechange=function() {
      if(xhra.readyState==4 && xhra.status==200) {
        if (data=='onsite') {
          document.location = "/";
        } else if (data=='adminpage') {
          document.location = "/admin/";
        } else {
          return;
        }
      }
    }
    xhra.open('POST','/admin_login.php',true);
    xhra.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhra.send('mode='+data);
  }
});
}
<?php

if($_SESSION['mode'] == 'onsite') {

if(isset($_SESSION['event_id']) && $_SESSION['event_id'] != "undefined") {
  $cur_event = get_event($_SESSION['event_id']);
  if($cur_event['date'] != date("Y-m-d")) {
    unset($_SESSION['event_id']);
  }
}

if(count($events) != 0 ) {
?>
function eventSelectModal() {
vex.dialog.open({
  message: 'Please select your event:',
  input: '<?php foreach($events as $key => $event) { ?><input type=\"radio\" name=\"event\" id=\"event_<?php print($event['event_id']) ?>\" value=\"<?php print($event['event_id']); ?>\"><label style=\"display:inline\" for=\"event_<?php print($event['event_id']) ?>\"> <?php print(htmlentities($event['note'], ENT_QUOTES)); ?></label><br> <?php } ?><br>',
  callback: function(data) {
    if (data === false) {
      return console.log('Cancelled');
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST','/admin_login.php',true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('user=<?php print($_SESSION['user']) ?>&event_id='+data.event);
  }
});
}
<?php
  if(!isset($_SESSION['event_id']) || $_SESSION['event_id'] == "undefined") { ?>
    window.onload = eventSelectModal();
  <?php
  }
}
} ?>

</script>
        <footer>
          <div class="row">
                <div class="twelve cols center">
                    <p>PaperOut is brought to you by <a href="http://www.rtpittsburgh.org/"><?php print($site_org) ?></a><br><a href="http://steelcitycodefest.org/success-stories">Learn More</a>&nbsp;&nbsp;/<?php if(isset($_SESSION['user']) && isset($_SESSION['event_id']) && $_SESSION['event_id'] != "undefined" ) { ?>&nbsp;&nbsp;<a href="javascript:eventSelectModal()">Event: <?php if(!isset($cur_event)) { $cur_event = get_event($_SESSION['event_id']); } print($cur_event['note'] . "&nbsp;&nbsp;/"); } elseif (count($events) == 0 && $_SESSION['mode'] != 'adminpage' && isset($_SESSION['user'])) { ?></a>&nbsp;&nbsp;No events scheduled for today &nbsp;&nbsp;/<?php } ?>&nbsp;&nbsp;<a href="mailto:HBundy@rtpittsburgh.org">Got Questions?</a></p>

                </div>
        </footer>
    </div><!-- /container -->
</body>

</html>
