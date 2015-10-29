<!doctype html>
<html>
    
<head>
    <meta charset="UTF-8">
    <title>Install PaperOut</title>
    <link rel="icon" type="image/png" href="assets/PaperOut_Favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/style.css" media="screen">
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
</head>
    
<body>

    <main>
        <div class="center"><img src="assets/PaperOut_Logo_Horizontal.svg" onerror="this.src='assets/PaperOut_Logo_Horizontal.png'"></div>
        
        <br>
        
        <h1>Welcome</h1>
        <p>Welcome to the install of PaperOut, the web app that helps you to take the paper out of your volunteer event management! Please take a few moments to fill out the information below and you'll be on your way to using PaperOut!</p>
        <h1>Details, please!</h1>
        <form>
            <table>
                <tr class="row">
                    <td class="labels" valign="top"><label>Organization Name</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text"></td>
                </tr>
                
                <tr class="row">
                    <td class="labels" valign="top"><label>MySQL Host</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text"></td>
                </tr>
                
                <tr>
                    <td class="labels" valign="top"><label>MySQL Username</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text"></td>
                </tr> 

                <tr>
                    <td class="labels" valign="top"><label>MySQL Password</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text"></td>
                </tr> 
                
                <tr>
                    <td class="labels" valign="top"><label>MySQL Table Prefix</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text"></td>
                </tr> 
                
                <tr>
                    <td class="labels" valign="top"><label>Initial Admin Username</label>
                        <br>
                        <small>Description here. Wee this one is longer, look it me go!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text"></td>
                </tr> 
                
                <tr>
                    <td class="labels" valign="top"><label>Initial Admin Password</label>
                        <br>
                        <small>Description here if applicable. If not, please remove!</small>
                    </td>
                    <td class="inputs" valign="top"><input type="text"></td>
                </tr>     
                
                <tr>
                    <td class="labels" valign="top"><label>Signature Directory</label>
                        <br>
                        <small>Description here. Wee this one is longer, look it me go!</small>
                    </td>
                    <td class="inputs" valign="top">
                        <p><input type="radio" name="sigdir" id="sigdir_auto" checked="true"> Attempt to auto-create</p>
                        <p><input type="radio" name="sigdir" id="sigdir_man"> Specify a signatures directory:</p>
                        <input type="text" id="sigdir_man_input" placeholder="sample of how it should look here" disabled="disabled">
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
        });

        $('#sigdir_auto').click(function()
        {
          $('#sigdir_man_input').attr("disabled","disabled");
        });
    }); 
</script>
        
</body>
    
</html>