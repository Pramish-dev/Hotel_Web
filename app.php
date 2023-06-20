<?php require "../config/config.php"; ?>
<?php
// creating app class and connecting to DB
 class App {

    public $host = HOST;
    public $dbname = DBNAME;
    public $user =USER;
    public $pass = PASS;

    public $link;

    //constructor
    public function __construct(){
     
        $this -> connect();
    }
    public function connect(){
        $this-> link = new PDO("mysql: host=".$this->host.";dbname=".$this->dbname."",$this->user, $this->pass);
  
     if($this->link){
      echo "db connection is working";
     }
    }
    // selecting data from DB
    public function selectAll($query){
      $rows = $this-> link ->query($query);
      $rows-> execute();
      $allRows =$rows->fetchAll(PDO:: FETCH_OBJ);
      if($allRows){
         return $allRows;
      } 
      else {
         return false;
      }
    }
    // to select one row
    public function selectOne($query){
      $row = $this-> link ->query($query);
      $row-> execute();
      $singleRow =$row->fetch(PDO::FETCH_OBJ);
      if($singleRow){
         return $singleRow;
      } 
      else {
         return false;
      }
    }

    // performing CRUD operation 
    //insert query
    public function insert($query,$arr,$path)
    {
      if($this-> validate($arr)=="empty"){
         echo "<script> alert('one or more inputs are empty')</script>";

      }else {
         
         $insert_record= $this-> link-> prepare($query);
         $insert_record-> execute($arr);

         header("location: ".$path." ");
      }
    }
     //update query
    public function update($query,$arr,$path)
    {
      if($this-> validate($arr)=="empty"){
         echo "<script> alert('one or more inputs are empty')</script>";

      }else {
         
         $update_record= $this-> link-> prepare($query);
         $update_record-> execute($arr);

         header("location: ".$path." ");
      }
    }
    //delete query
    public function delete($query,$path)
    {
         
         $delete_record= $this-> link-> query($query);
         $delete_record-> execute();

         header("location: ".$path." ");
      }
    
     public function validate($arr)
     {
      if(in_array(" ",$arr)){
         echo "empty";
      }
     }
    // creating Registration and login methods
    
public function register($query,$arr,$path){

if($this->validate($arr)=="empty"){
  echo "<script> alert('one or more inputs are empty')</script>";

}else{
   $register_user=$this->link->prepare($query);
   $register_user->execute($arr);

   header("location : ".$path."");
}
}
// login portal
public function login($query,$data,$path)
{
// email
$login_user=$this->link->query($query);
$login_user-> execute();
$fetch =$login_user->fetch(PDO:: FETCH_OBJ);

if ($login_user->rowCount()>0){
   if(password_verify($data['password'],$fetch['password'])){
      
      header("location: ".$path."");
   }

}}
// starting and validating sessions
//starting session 
public function staringSession(){
   session_start();

}
//validating sessions
public function validateSession($path){
 if(isset($_SESSION['id'])){
   header("location: ".$path." ");
 }
}
  
 }
 $obj = new App;
