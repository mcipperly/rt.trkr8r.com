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
        
        <h1>Welcome</h1>
        <p>Welcome to the install of PaperOut, the web app that helps you to take the paper out of your volunteer event management! Please take a few moments to fill out the information below and you'll be on your way to using PaperOut!</p>
        <h1>Details, please!</h1>
        <form action="run-install.php" method="POST">
            <table>
                <tr class="row">
                    <td class="labels" valign="top"><label>Organization Name</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text" name="orgname"></td>
                </tr>
                
                <tr class="row">
                    <td class="labels" valign="top"><label>MySQL Host</label>
                        <br>
                        <small>Provided by your web host; if unsure, try &quot;localhost&quot;</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text" name="mysql_host" placeholder="localhost"></td>
                </tr>
               
                <tr>
                    <td class="labels" valign="top"><label>MySQL Database</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text" name="mysql_db"></td>
                </tr>
 
                <tr>
                    <td class="labels" valign="top"><label>MySQL Username</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text" name="mysql_user"></td>
                </tr> 

                <tr>
                    <td class="labels" valign="top"><label>MySQL Password</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="password" name="mysql_pass"></td>
                </tr> 
                
                <tr>
                    <td class="labels" valign="top"><label>Initial Admin Username</label>
                        <br>
                        <small>Description here. Wee this one is longer, look it me go!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text" name="admin_user"></td>
                </tr> 
                
                <tr>
                    <td class="labels" valign="top"><label>Initial Admin Password</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text" name="admin_pass"></td>
                </tr>     
                
                <tr>
                    <td class="labels" valign="top"><label>Signature Directory</label>
                        <br>
                        <small>Description here. Wee this one is longer, look it me go!</small>
                    </td>
                    <td class="inputs" valign="top">
                        <p><input type="radio" name="sigdir" id="sigdir_auto" value="try_auto" checked="true"> Attempt to auto-create</p>
                        <p><input type="radio" name="sigdir" id="sigdir_man" value="no_auto"> Specify a signatures directory (relative to document root):</p>
                        <input type="text" id="sigdir_man_input" name="sig_dir" disabled="disabled" style="background-color:WhiteSmoke">
                    </td>
                </tr> 
                
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Submit">
                    </td>
                </tr>

        </form>
  
    </main>
        
<script>
    $(document).ready(function () {
        $('#sigdir_man').click(function()
        {
          $('#sigdir_man_input').removeAttr("disabled");
          $('#sigdir_man_input').css("background-color", "white");
        });

        $('#sigdir_auto').click(function()
        {
          $('#sigdir_man_input').attr("disabled","disabled");
          $('#sigdir_man_input').css("background-color", "WhiteSmoke");
        });
    }); 
</script>
        
</body>
    
</html>
