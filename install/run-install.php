<?php if(file_exists('../db/db-config.php')) {
//  header('Location: /');
} ?>
<!doctype html>
<html>
    
<head>
    <meta charset="UTF-8">
    <title>Install PaperOut</title>
    <link rel="icon" type="image/png" href="assets/PaperOut_Favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/style.css" media="screen">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
</head>
    
<body>

    <main>
        <div class="center"><img src="assets/PaperOut_Logo_Horizontal.svg" onerror="this.src='assets/PaperOut_Logo_Horizontal.png'"></div>
        
        <br>
        
        <h1>Configuring...</h1>
        <?php 
        if (isset($_REQUEST['orgname'],$_REQUEST['mysql_host'],$_REQUEST['mysql_user'],$_REQUEST['mysql_pass'],$_REQUEST['admin_user'],$_REQUEST['admin_pass'],$_REQUEST['sigdir'])) {
          $db_host = $_REQUEST['mysql_host'];
          $db_name = $_REQUEST['mysql_db'];
          $db_user = $_REQUEST['mysql_user'];
          $db_pass = $_REQUEST['mysql_pass'];
          $site_org = $_REQUEST['orgname'];
          $admin_user = $_REQUEST['admin_user'];
          $admin_pass = $_REQUEST['admin_pass'];
          $sigdir_method = $_REQUEST['sigdir'];
          if ($sigdir_method == "no_auto") {
            $sigdir_path = $_REQUEST['sig_dir'];
          } else {
            $sigdir_path = "signatures";
          } 
        } else {
        ?><p>Some information was not captured - please go back and try again</p>
        </main></body></html>
        <?php exit();
        }
          
        $db_link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

        if(mysqli_connect_errno()) {
          print('Database connection failed: '. mysqli_connect_error());
        ?></main></body></html><?php
          exit();
        }
 
        ?><p>Successfully connected to the database on <?php print($db_host) ?>!</p>
        <?php 
          $create_db_query = "DROP TABLE IF EXISTS `company`;CREATE TABLE `company` (  `company_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(100) NOT NULL,  `contact_name` varchar(70) NOT NULL,  `contact_details` varchar(40) NOT NULL,  `description` text NOT NULL,  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',  `date_added` date NOT NULL,  PRIMARY KEY (`company_id`),  KEY `active` (`active`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `element`;CREATE TABLE `element` (  `element_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(50) NOT NULL,  `label` varchar(255) NOT NULL,  `description` varchar(100) NOT NULL,  `type` varchar(10) NOT NULL DEFAULT 'text',  `cols` tinyint(3) unsigned NOT NULL DEFAULT '1',  `plural` tinyint(1) unsigned NOT NULL DEFAULT '0',  PRIMARY KEY (`element_id`)) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `event`;CREATE TABLE `event` (  `event_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,  `status_id` tinyint(3) unsigned NOT NULL DEFAULT '1',  `date` date NOT NULL,  `note` text NOT NULL,  `location` varchar(150) NOT NULL,  PRIMARY KEY (`event_id`),  KEY `status_id` (`status_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `event_status`;CREATE TABLE `event_status` (  `status_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(30) NOT NULL,  PRIMARY KEY (`status_id`)) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `export_preset`;CREATE TABLE `export_preset` (  `preset_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(30) NOT NULL,  `ord` tinyint(3) unsigned NOT NULL,  PRIMARY KEY (`preset_id`)) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `form`;CREATE TABLE `form` (  `form_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(50) NOT NULL,  `title` varchar(50) NOT NULL,  `signature` tinyint(1) unsigned NOT NULL DEFAULT '0',  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',  PRIMARY KEY (`form_id`),  KEY `valid` (`active`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `form_element`;CREATE TABLE `form_element` (  `fe_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,  `form_id` smallint(5) unsigned NOT NULL,  `element_id` tinyint(3) unsigned NOT NULL,  `required` tinyint(3) unsigned NOT NULL DEFAULT '0',  `ord` tinyint(4) NOT NULL,  PRIMARY KEY (`fe_id`),  KEY `form_id` (`form_id`)) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `form_response`;CREATE TABLE `form_response` (  `response_id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `volunteer_id` mediumint(8) unsigned NOT NULL,  `fe_id` tinyint(3) unsigned NOT NULL,  `value` text NOT NULL,  `date_added` date NOT NULL,  `time_added` time NOT NULL,  PRIMARY KEY (`response_id`),  KEY `fe_id` (`fe_id`),  KEY `volunteer_id` (`volunteer_id`)) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `preset_element`;CREATE TABLE `preset_element` (  `pe_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,  `preset_id` tinyint(3) unsigned NOT NULL,  `element_id` tinyint(3) unsigned NOT NULL,  `ord` smallint(5) unsigned NOT NULL,  PRIMARY KEY (`pe_id`)) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `select_element`;CREATE TABLE `select_element` (  `se_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',  `element_id` tinyint(3) unsigned NOT NULL,  `text` varchar(100) NOT NULL,  PRIMARY KEY (`se_id`),  KEY `element_id` (`element_id`),  KEY `active` (`active`)) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `user`;CREATE TABLE `user` (  `user_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,  `email` varchar(254) NOT NULL,  `password` char(32) NOT NULL,  `permission_level` tinyint(3) unsigned NOT NULL DEFAULT '0',  `last_updated` datetime NOT NULL,  PRIMARY KEY (`user_id`)) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `volunteer`;CREATE TABLE `volunteer` (  `volunteer_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,  `email` varchar(254) NOT NULL,  `company_id` smallint(5) unsigned NOT NULL DEFAULT '0',  `preregistered` tinyint(1) unsigned NOT NULL DEFAULT '0',  `status_id` tinyint(3) unsigned NOT NULL DEFAULT '1',  `date_added` date NOT NULL,  `time_added` time NOT NULL,  PRIMARY KEY (`volunteer_id`),  UNIQUE KEY `email` (`email`),  KEY `company_id` (`company_id`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `volunteer_event`;CREATE TABLE `volunteer_event` (  `ve_id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `volunteer_id` mediumint(8) unsigned NOT NULL,  `event_id` mediumint(8) unsigned NOT NULL,  `signature_file_name` varchar(255) DEFAULT NULL,  `duration` decimal(4,2) unsigned NOT NULL DEFAULT '0.00',  PRIMARY KEY (`ve_id`),  UNIQUE KEY `volunteer_event` (`volunteer_id`,`event_id`),  KEY `volunteer_id` (`volunteer_id`),  KEY `event_id` (`event_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;DROP TABLE IF EXISTS `volunteer_status`;CREATE TABLE `volunteer_status` (  `status_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(30) NOT NULL,  PRIMARY KEY (`status_id`)) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8; INSERT INTO `company` VALUES (0,'Unaffiliated','','','',0,'2015-09-22'); INSERT INTO `element` VALUES (1,'firstname','First Name','','text',6,0),(2,'lastname','Last Name','','text',4,0),(3,'age','Age','If you are under 18 years of age, please click <a href=\"./under-18.php\">here</a>.','number',2,0),(4,'company','Affiliation or Company','','company',5,0),(5,'address1','Address','','text',9,0),(6,'address2','Apt/Suite/Floor','','text',3,0),(7,'city','City','','text',7,0),(8,'state','State','','select',2,0),(9,'postalcode','ZIP','','text',3,0),(10,'phone','Phone','','number',5,0),(11,'email','Email','','text',7,0),(12,'skills','Home Repair Skills','','select',12,1),(13,'future_interest','Click here to receive information about future volunteer opportunities','','checkbox',12,0),(14,'newsletter','Click here to receive a newsletter & special mailings from RT Pittsburgh','','checkbox',12,0); INSERT INTO `event_status` VALUES (1,'Open'),(2,'Completed'); INSERT INTO `export_preset` VALUES (1,'All Fields',1),(2,'For Email',2),(3,'For Physical Mail',3); INSERT INTO `form` VALUES (1,'Volunteer Registration','Registration',1,1); INSERT INTO `form_element` VALUES (1,1,1,1,1),(2,1,2,1,2),(3,1,3,1,3),(5,1,5,1,7),(6,1,6,0,8),(7,1,7,1,9),(8,1,8,1,10),(9,1,9,1,11),(10,1,10,1,5),(11,1,11,1,4),(12,1,12,0,12),(13,1,13,0,14),(14,1,14,0,13); INSERT INTO `form_response` VALUES (1,1,1,'Seth','2015-10-28','23:24:31'),(2,1,2,'Hagnott','2015-10-28','23:24:31'),(3,1,3,'51','2015-10-28','23:24:31'),(4,1,11,'whignett@rtpittsburgh.org','2015-10-28','23:24:31'),(5,1,10,'4128356630','2015-10-28','23:24:31'),(6,1,5,'2040 Washington Rd','2015-10-28','23:24:31'),(7,1,6,'','2015-10-28','23:24:31'),(8,1,7,'Pittsburgh','2015-10-28','23:24:31'),(9,1,8,'39','2015-10-28','23:24:31'),(10,1,9,'15241','2015-10-28','23:24:31'),(11,1,12,'61','2015-10-28','23:24:31'),(12,1,14,'1','2015-10-28','23:24:31'),(13,1,13,'1','2015-10-28','23:24:31'); INSERT INTO `preset_element` VALUES (1,1,1,1),(2,1,2,2),(3,1,3,3),(4,1,11,4),(5,1,10,5),(7,1,5,6),(8,1,6,7),(9,1,7,8),(10,1,8,9),(11,1,9,10),(12,1,12,11),(13,1,13,12),(14,2,1,1),(15,2,2,2),(16,2,11,3),(17,2,13,4),(25,3,6,4),(24,3,5,3),(23,3,2,2),(22,3,1,1),(26,3,7,5),(27,3,8,6),(28,3,9,7); INSERT INTO `select_element` VALUES (1,1,8,'AL'),(2,1,8,'AK'),(3,1,8,'AZ'),(4,1,8,'AR'),(5,1,8,'CA'),(6,1,8,'CO'),(7,1,8,'CT'),(8,1,8,'DE'),(9,1,8,'DC'),(10,1,8,'FL'),(11,1,8,'GA'),(12,1,8,'HI'),(13,1,8,'ID'),(14,1,8,'IL'),(15,1,8,'IN'),(16,1,8,'IA'),(17,1,8,'KS'),(18,1,8,'KY'),(19,1,8,'LA'),(20,1,8,'ME'),(21,1,8,'MD'),(22,1,8,'MA'),(23,1,8,'MI'),(24,1,8,'MN'),(25,1,8,'MS'),(26,1,8,'MO'),(27,1,8,'MT'),(28,1,8,'NE'),(29,1,8,'NV'),(30,1,8,'NH'),(31,1,8,'NJ'),(32,1,8,'NM'),(33,1,8,'NY'),(34,1,8,'NC'),(35,1,8,'ND'),(36,1,8,'OH'),(37,1,8,'OK'),(38,1,8,'OR'),(39,1,8,'PA'),(40,1,8,'PR'),(41,1,8,'RI'),(42,1,8,'SC'),(43,1,8,'SD'),(44,1,8,'TN'),(45,1,8,'TX'),(46,1,8,'UT'),(47,1,8,'VT'),(48,1,8,'VA'),(49,1,8,'WA'),(50,1,8,'WV'),(51,1,8,'WI'),(52,1,8,'WY'),(53,1,12,'Carpentry'),(54,1,12,'Masonry'),(55,1,12,'Electrical'),(56,1,12,'Plumbing'),(57,1,12,'Drywall'),(58,1,12,'Flooring'),(59,1,12,'Cleaning'),(60,1,12,'Landscaping'),(61,1,12,'Painting'); INSERT INTO `user` VALUES (1,'" . $admin_user . "',MD5('" . $admin_pass . "'),0,NOW());INSERT INTO `volunteer_status` VALUES (1,'Unregistered'),(2,'Unsigned'),(3,'Signed')";

          if(mysqli_multi_query($db_link, $create_db_query)) {
            do {
              if ($result = mysqli_store_result($db_link)) {
                mysqli_free_result($result);
              }
            } while (mysqli_more_results($db_link) && mysqli_next_result($db_link));
          }
          mysqli_close($db_link); ?>
          <p>Successfully installed the PaperOut database!</p>
          <?php

          if($cfile = fopen('../db/db-config.php', 'w')) {
            fwrite($cfile, "<?php\n\$site_org='$site_org';\n\$db_user='$db_user';\n\$db_pass='$db_pass';\n\$db_host='$db_host';\n\$db_name='$db_name';\n?>");
            fclose($cfile);
          ?><p>Successfully wrote configuration file!</p><?php
          } else {
            print("Couldn't write to db-config.php - check permissions?");
            ?></main></body></html><?php
            exit();
          }

          if(!(is_dir($sigdir_path))) {
            if($sigdir_method != "no_auto") {
              if(mkdir("../" . $sigdir_path)) {
                ?><p>Successfully created <?php print($sigdir_path) ?> directory!</p><?php
              } else {
                ?><p>Couldn't create <?php print($sigdir_path) ?> - check permissions?</p></main></body></html><?php
                exit();
              }
            } else {
              ?><p>The <?php print($sigdir_path) ?> doesn't exist - check that it's correctly created relative to your document root?</p><?php
            }
          }
          if(file_put_contents("../" . $sigdir_path . "/index.html", "<!-- this space intentionally blank -->")) {
            ?><p>Successfully wrote test file to signatures directory!</p><?php
          } else {
            ?><p>Couldn't create files in <?php print($sigdir_path) ?> - check permissions?</p></main></body></html><?php
          }
              
          
  
        
?>
          <h2>All steps completed successfully! <a href="/">Click here</a> to go to your new PaperOut homepage!</h2> 
  
    </main>
        
</body>
    
</html>
