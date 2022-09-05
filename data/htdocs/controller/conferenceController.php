<?php
    require 'model/conferenceModel.php';
    require 'model/conference.php';
    require_once 'config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class conferenceController 
	{
        function __construct() 
		{          
			$this->objconfig = new config();
			$this->obj =  new conferenceModel($this->objconfig);
		}
        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
			switch ($act) 
			{
                case 'add' :                    
					$this->insert();
					break;						
				case 'update':
					$this->update();
					break;				
				case 'delete' :					
					$this -> delete();
					break;		
                case 'current':
                    $this -> current();
                    break;						
				default:
                    $this->list();
			}
		}		
        // page redirection
		public function pageRedirect($url)
		{
			header('Location:'.$url);
		}	
        // check validation
		public function checkValidation($conferencetb)
        {    $noerror=true;          
            // Validate title            
            if(empty($conferencetb->title)){
                $conferencetb->title_msg = "Title is empty.";$noerror=false;     
            } elseif(!filter_var($conferencetb->title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[a-zA-Z0-9\s]{2,255}+$/")))){
                $conferencetb->title_msg = "Invalid entry.";$noerror=false;
            }else{$conferencetb->title_msg ="";}
            //Validate date
            if (empty($conferencetb->date)){
                $conferencetb->date_msg = "Date is empty.";$noerror=false;     
            }
            // Validate latitude
            if (empty($conferencetb->lat)){$conferencetb->lat_msg ="";
            } elseif(!filter_var($conferencetb->lat, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^-?([0-8]?[0-9]|90)(\.[0-9]{1,15})+$/")))){
                $conferencetb->lat_msg = "Invalid entry.";$noerror=false;
            }else{$conferencetb->lat_msg ="";}
            // Validate longtitude
            if (empty($conferencetb->lng)){$conferencetb->lng_msg ="";
            } elseif(!filter_var($conferencetb->lng, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^-?([0-9]{1,2}|1[0-7][0-9]|180)(\.[0-9]{1,15})+$/")))){
                $conferencetb->lng_msg = "Invalid entry.";$noerror=false;
            }else{$conferencetb->lng_msg ="";}
            return $noerror;
        }
        // add new record
		public function insert()
		{
            try{
                $conferencetb=new conference();
                if (isset($_POST['addbtn'])) 
                {   
                    // read form value
                    $conferencetb->date = trim($_POST['date']);
                    $conferencetb->title = trim($_POST['title']);
                    $conferencetb->lat = trim($_POST['lat']);
                    $conferencetb->lng = trim($_POST['lng']);
                    $conferencetb->country = trim($_POST['country']);
                    //call validation                    
                    $chk=$this->checkValidation($conferencetb);                    
                    if($chk)
                    {   
                        //call insert record            
                        $pid = $this -> obj ->insertRecord($conferencetb);
                        if($pid>0){			
                            $this->list();
                        }else{
                            echo "<p class='form-control is-invalid'>Something is wrong..., try again.</p>";
                        }
                    }else
                    {    
                        $_SESSION['conferencetbl0']=serialize($conferencetb);//add session obj           
                        $this->pageRedirect("view/insert.php");                
                    }
                }
            }catch (Exception $e) 
            {
                $this->close_db();	
                throw $e;
            }
        }
        // update record
        public function update()
		{            
            try
            {  
                if (isset($_POST['updatebtn'])) 
                {            
                    $conferencetb=unserialize($_SESSION['conferencetbl0']);
                    $conferencetb->date = trim($_POST['date']);
                    $conferencetb->title = trim($_POST['title']);
                    $conferencetb->lat = trim($_POST['lat']);
                    $conferencetb->lng = trim($_POST['lng']);
                    $conferencetb->country = trim($_POST['country']);                    
                    // check validation  
                    $chk=$this->checkValidation($conferencetb);
                    if($chk)
                    {
                        $res = $this->obj->updateRecord($conferencetb);	                        
                        if($res){			
                            $this->list();                           
                        }else{
                            echo "<p class='form-control is-invalid'>Something is wrong..., try again.</p>";
                        }
                    }else
                    {      
                        $_SESSION['conferencetbl0']=serialize($conferencetb);      
                        $this->pageRedirect("view/update.php");                
                    }
                }elseif(isset($_GET['id']) && !empty(trim($_GET['id']))){
                    $id=$_GET['id'];
                    $result=$this->obj->selectRecord($id);                    
                    $row=$result;  
                    $conferencetb=new conference(); 
                    $conferencetb->id=$id;                 ;
                    $conferencetb->title=$row[0]["title"];
                    $conferencetb->date=$row[0]["date"];
                    $conferencetb->lat=$row[0]["lat"];
                    $conferencetb->lng=$row[0]["lng"];
                    $conferencetb->country=$row[0]["country"];
                    $_SESSION['conferencetbl0']=serialize($conferencetb); 
                    $this->pageRedirect('view/update.php');
                }else{
                    echo "<p class='form-control is-invalid'>Invalid operation.</p>";
                }
            }
            catch (Exception $e) 
            {
                $this->close_db();				
                throw $e;
            }
        }
        // delete record
        public function delete()
		{
            try
            {
                if (isset($_GET['id'])) 
                {
                    
                    $id=$_GET['id'];
                    $res=$this->obj->deleteRecord($id);                
                    if($res){
                        $this->pageRedirect('index.php');
                    }else{
                        echo "<p class='form-control is-invalid'>Something is wrong..., try again.</p";
                    }
                }else{
                    echo "<p class='form-control is-invalid'>Invalid operation.</p>";
                }
            }
            catch (Exception $e) 
            {
                $this->close_db();				
                throw $e;
            }
        }
        public function list(){
            $result=$this->obj->selectRecord(0);
            include "view/conferenceView.php";                                        
        }
        public function current()
		{            
            try
            {  
                if(isset($_GET['id']) && !empty(trim($_GET['id']))){
                    $id=$_GET['id'];
                    $result=$this->obj->selectRecord($id);                    
                    $row=$result;  
                    $conferencetb=new conference(); 
                    $conferencetb->id=$id;                 ;
                    $conferencetb->title=$row[0]["title"];
                    $conferencetb->date=$row[0]["date"];
                    $conferencetb->lat=$row[0]["lat"];
                    $conferencetb->lng=$row[0]["lng"];
                    $conferencetb->country=$row[0]["country"];
                    $_SESSION['conferencetbl0']=serialize($conferencetb); 
                    $this->pageRedirect('view/current.php');
                }else{
                    echo "<p class='form-control is-invalid'>Invalid operation.</p>";
                }
            }
            catch (Exception $e) 
            {
                $this->close_db();				
                throw $e;
            }
        }
    }
?>