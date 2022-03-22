<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <title>Employees Managements</title>
        <link rel="stylesheet" href="Resources/style.css">
      
    </head>
    
    <body>
        <form method="get" class="Search">
            
        <input  type="text" id="search" name="search" placeholder="Search by Employee Email" >
        <input   id="searchbtn" type="submit" value="Search" name="searchbtn" >
        </form>
    
       
         <div  id="divcont" class="container">
         <div>
       <h2 style='background-color:#7bda7b;'><?php if(!empty($SuccMessage)) echo $SuccMessage;?></h2>
       <h2 style='background-color:#ff5757;'><?php if(!empty($ErrorMessage)) echo $ErrorMessage;?></h2>
       
         </div>
           <form method="post" >
                <input  type="text" id="name" name="name" placeholder="Name" value="<?php if(isset($_POST["next"]) || isset($_POST["prev"]))echo $Name;elseif(isset($_GET["searchbtn"]) && !empty($_GET["search"])){echo $ValideName;} ?>">
                <input  type="text" id="email" name="email" placeholder="Email" value="<?php if(isset($_POST["next"]) || isset($_POST["prev"]))echo $Email;elseif(isset($_GET["searchbtn"]) && !empty($_GET["searchbtn"])){echo $ValideEmail;} ?>" >
                <input  type="text" id="phone" name="phone" placeholder="Phone" value="<?php if(isset($_POST["next"]) || isset($_POST["prev"]))echo $Phone;elseif(isset($_GET["searchbtn"]) && !empty($_GET["searchbtn"])){echo $ValidePhone;} ?>"> 
                <input  type="text" id="address" name="address" placeholder="Address" value="<?php if(isset($_POST["next"]) || isset($_POST["prev"]))echo $Address;elseif(isset($_GET["searchbtn"]) && !empty($_GET["searchbtn"])){echo $ValideAddress;} ?>">
                <input   id="insert" type="submit" value="Insert" name="insert" style="background-color: yellowgreen;">
                <input  id="update" type="submit" value="Update" name="update" style="background-color: cornflowerblue;">
                <input   id="delete" type="submit" value="Delete" name="delete" style="background-color: tomato;">
                <div class="change">
                    <input id="prev" type="submit" value="<<<  Prev" name="prev" style="background-color: #ec9cec;">
                    <input  id="next" type="submit" value="Next  >>>" name="next" style="background-color: #ec9cec;">
            
                </div>
                

           </form>
                
        </div> 
       
    </body>

</html>



