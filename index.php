<?php
require_once("vendor/autoload.php");
session_start();
$i=0;
setcookie('EmpCount',$i,time()+ (10 * 365 * 24 * 60 * 60));

$xml = new DOMDocument("1.0", "UTF-8") or die("Error: Cannot create object");

$xml->load("Resources/employee.xml");

$ErrorMessage="";
$SuccMessage="";
// get Employee Nodes
$Employee=$xml->getElementsByTagName("Employee");

  /////////////////////////////////////// Insert Action Start ////////////////////////////////////////////////
  if(isset($_POST["insert"])){
   
  
  $inputName=$_POST["name"];
  $inputEmail=$_POST["email"];
  $inputPhone=$_POST["phone"];
  $inputAddress=$_POST["address"];
      //create Elements
      $root=$xml->getElementsByTagName("Employees")->item(0);
      $count=getElementNumber($xml);

      if(!empty($inputName) && !empty($inputEmail) && !empty($inputPhone) && !empty($inputAddress))
  {

    //Create Node in root Element
      $employee=$xml->createElement("Employee");
      $Ename=$xml->createElement("Name",$inputName);
      $Eemail=$xml->createElement("Email",$inputEmail);
      $Ephone=$xml->createElement("Phone",$inputPhone);
      $Eaddress=$xml->createElement("Address",$inputAddress);
  
  
      // Append child elements in parent element
  
      $employee->appendChild($Ename);
      $employee->appendChild($Eemail);
      $employee->appendChild($Ephone);
      $employee->appendChild($Eaddress);
      $root->appendChild($employee);
      $attr=$xml->createAttribute("id");
      $attr->value =$count+1;
      $employee->appendChild($attr);
      $SuccMessage.="Employee data is inserted successfuly";
  }
  else{
    $ErrorMessage.="Please Insert data";
  }
      
    // save changes
    $xml->save("Resources/employee.xml");
}
  /////////////////////////////////////// Insert Action End ////////////////////////////////////////////////


// fn to get Employee node number
function getElementNumber($xml){
    $elementsNumber=$xml->getElementsByTagName("Employee")->length;
    return $elementsNumber;
}


  /////////////////////////////////////// Delete Action Start ////////////////////////////////////////////////

if(isset($_POST["delete"])){
 
  //get inserted value
 $inputName=$_POST["name"];
 $inputEmail=$_POST["email"];
 $inputPhone=$_POST["phone"];
 $inputAddress=$_POST["address"];

 $root = $xml->documentElement;
 if(!empty($inputName) && !empty($inputEmail) && !empty($inputPhone) && !empty($inputAddress))
 {
foreach($root->childNodes as $ElementEmp) {
  foreach($ElementEmp->childNodes as $ElemChilds) {

  if($ElemChilds->nodeName =="Email" && $ElemChilds->nodeValue==$inputEmail){    
      $parentElm=$ElemChilds->parentNode;

      $removedNode= $parentElm->nodeValue;

      $restult=$root->removeChild($ElementEmp);
      if($restult){
        $SuccMessage.="Data is deleted successfuly";
      }
    }
  }
  }
}
else{
    $ErrorMessage.="No data selected to delete";
  }
$xml->save("Resources/employee.xml");

 }
   /////////////////////////////////////// Delete Action End ////////////////////////////////////////////////

 



  /////////////////////////////////////// Update Action Start ////////////////////////////////////////////////

if(isset($_POST["update"]) && !empty($_POST["update"])){
 //get inserted value
 $inputName=$_POST["name"];
 $inputEmail=$_POST["email"];
 $inputPhone=$_POST["phone"];
 $inputAddress=$_POST["address"];
 
 $root = $xml->documentElement;
 $xpath = new DomXpath($xml);
$Id=$_COOKIE["EmpCount"];
if(!empty($inputName) && !empty($inputEmail) && !empty($inputPhone) && !empty($inputAddress))
{
 // traverse all results
foreach ($xpath->query("//Employee[@id='$Id']") as $EmployeeNode) {
  $EmployeeNode->getElementsByTagName("Name")[0]->textContent=$inputName;
  $EmployeeNode->getElementsByTagName("Email")[0]->textContent=$inputEmail;
  $EmployeeNode->getElementsByTagName("Phone")[0]->textContent=$inputPhone;
  $EmployeeNode->getElementsByTagName("Address")[0]->textContent=$inputAddress;
  //echo $EmployeeNode->nodeValue; // will be 'this item'
  $SuccMessage.="Employee data is updated successfuly";
 
}

}
else{
  $ErrorMessage.="Please ensure that you insert data or update it";
}
$xml->save("Resources/employee.xml");

}
  /////////////////////////////////////// Update Action End ////////////////////////////////////////////////




  /////////////////////////////////////// Next Action Start ////////////////////////////////////////////////
  if(isset($_POST["next"])){

     //get Input value
  $inputName=$_POST["name"];
  $inputEmail=$_POST["email"];
  $inputPhone=$_POST["phone"];
  $inputAddress=$_POST["address"];
  $Employee=$xml->getElementsByTagName("Employee");
  $empSize=$Employee->length;
  if($_COOKIE['EmpCount'] <$empSize-1){
    $i=++$_COOKIE['EmpCount'];
  }
    
  if($empSize == 0 ){
    $inputName="";
    $inputEmail="";
    $inputPhone="";
    $inputAddress="";
    $i=$_COOKIE["EmpCount"]=0;
    setcookie('EmpCount',$i,time()+ (10 * 365 * 24 * 60 * 60));

  }else{
    if($_COOKIE["EmpCount"] <= $empSize){
      if($i>0){
        setcookie('EmpCount',$i,time()+ (10 * 365 * 24 * 60 * 60));
        $Name=$xml->getElementsByTagName("Name")[$i-1]->nodeValue;
        $Email=$xml->getElementsByTagName("Email")[$i-1]->nodeValue;
        $Phone=$xml->getElementsByTagName("Phone")[$i-1]->nodeValue;
        $Address=$xml->getElementsByTagName("Address")[$i-1]->nodeValue;
        $inputName=$Name;
        $inputEmail=$Email;
        $inputPhone=$Phone;
        $inputAddress=$Address;

      }
      else{
        setcookie('EmpCount',$i,time()+ (10 * 365 * 24 * 60 * 60));
        $Name="";
        $Email="";
        $Phone="";
        $Address="";
      }
    }
  }
  

  }
  /////////////////////////////////////// Next Action End ////////////////////////////////////////////////



  /////////////////////////////////////// Previous Action Start ////////////////////////////////////////////////
  if(isset($_POST["prev"])){
  // get input values
  $inputName=$_POST["name"];
  $inputEmail=$_POST["email"];
  $inputPhone=$_POST["phone"];
  $inputAddress=$_POST["address"];

  $empSize=$Employee->length;
 
  if($_COOKIE['EmpCount'] <$empSize){
    $i=--$_COOKIE['EmpCount'];
  }

  if($empSize == 0 ){
    $inputName="";
    $inputEmail="";
    $inputPhone="";
    $inputAddress="";
    $i=$_COOKIE["EmpCount"]=0;
    setcookie('EmpCount',$i,time()+ (10 * 365 * 24 * 60 * 60));

  }else{
    if($_COOKIE["EmpCount"]<=$empSize){
      if($i<=0){
        $i=0;
        setcookie('EmpCount',0,time()+ (10 * 365 * 24 * 60 * 60));
        $Name="";
        $Email="";
        $Phone="";
        $Address="";
      }else{
        setcookie('EmpCount',$i,time()+ (10 * 365 * 24 * 60 * 60));
        $Name=$xml->getElementsByTagName("Name")[$i-1]->textContent;
        $Email=$xml->getElementsByTagName("Email")[$i-1]->textContent;
        $Phone=$xml->getElementsByTagName("Phone")[$i-1]->textContent;
        $Address=$xml->getElementsByTagName("Address")[$i-1]->textContent;
        $inputName=$Name;
        $inputEmail=$Email;
        $inputPhone=$Phone;
        $inputAddress=$Address;
      }
    }
  }
}
  /////////////////////////////////////// Previous Action End ////////////////////////////////////////////////



  /////////////////////////////////////// Search Action Start ////////////////////////////////////////////////
if(isset($_GET["searchbtn"])){

  // inserted email
  $emailSearchValue=$_GET["search"];
  $root = $xml->documentElement;
  $xpath = new DomXpath($xml);
  $VaildeName="";
  $ValideEmail="";
  $ValidePhone="";
  $ValideAddress="";

  // traverse all results
  foreach ($xpath->query("//Employee[Email='$emailSearchValue']") as $EmployeeNode) {
   foreach($EmployeeNode->childNodes as $childNode){
     
    if($childNode->nodeName=="Name"){
      $ValideName=$childNode->nodeValue;
    }
    if($childNode->nodeName=="Email"){
      $ValideEmail=$childNode->nodeValue;
    }
    if($childNode->nodeName=="Phone"){
      $ValidePhone=$childNode->nodeValue;
    }
    if($childNode->nodeName=="Address"){
      $ValideAddress=$childNode->nodeValue;
    }
   }  
  }
}
  /////////////////////////////////////// Search Action End ////////////////////////////////////////////////

        
require_once("Views/formDesign.php");
?>