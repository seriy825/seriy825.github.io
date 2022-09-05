<?php

class conferenceModel{
    //set db config for mysql
    function __construct($consetup)
    {        
        $this->user=$consetup->user;
        $this->host=$consetup->host;
        $this->pass=$consetup->pass;
        $this->db=$consetup->db;
    }
    //open mysql db
    public function open_db(){
        try{
            $this->condb = new PDO("mysql:host=$this->host; dbname=$this->db",$this->user,$this->pass);
        }catch  (PDOException $e){
            die( 'Error connecting with DB : '.$e->getMessage());
        }

    }
    // close database
	public function close_db()
	{
		$this->condb = null;
	}	

    //insert record
    public function insertRecord($obj){
        try
        {	
            $this->open_db();            
            $query=$this->condb->prepare("INSERT INTO conference (title,date,lat,lng,country) VALUES (?, ?, ?, ?, ?)");
            if  ((empty($obj->lat) && empty($obj->lng)) || (empty($obj->lat)) || (empty($obj->lng))){
                $query->execute(array($obj->title,$obj->date,0,0,$obj->country));
            }else $query->execute(array($obj->title,$obj->date,$obj->lat,$obj->lng,$obj->country));
            $res= $query->fetchAll();
            $last_id=$this->condb->lastInsertId();
            $query=null;
            $this->close_db();
            return $last_id;
        }
        catch (Exception $e) 
        {
            $this->close_db();
            print($e);	
            throw $e;
        }
    }
    //update record
    public function updateRecord($obj){
        try
			{	
				$this->open_db();
				$query=$this->condb->prepare("UPDATE conference SET title=?, date=?,lat=?,lng=?,country=? WHERE id=?");
				$query->execute(array($obj->title,$obj->date,$obj->lat,$obj->lng,$obj->country,$obj->id));
				$res=$query->fetchAll();						
				$query=null;
				$this->close_db();
				return true;
			}
			catch (Exception $e) 
			{
                $this->close_db();
                throw $e;
            }
    }
    //delete record
    public function deleteRecord($id){
        try{
            $this->open_db();
            $query=$this->condb->prepare("DELETE FROM conference WHERE id=?");
            $query->execute(array($id));
            $res=$query->fetchAll();            
            $query=null;
            /*$last_id=$this->condb->lastInsertId();            
            $q=$this->condb->prepare("ALTER TABLE conference AUTO_INCREMENT = ?");
            $q->execute(array($last_id));*/
            $query=$this->condb->prepare("ALTER TABLE conference MODIFY COLUMN id INT(10) UNSIGNED; COMMIT;
            ALTER TABLE conference MODIFY COLUMN id INT(10) UNSIGNED AUTO_INCREMENT;
            COMMIT;");
            $query->execute();
            $res=$query->fetchAll();
            
            $this->close_db();
            return true;	
        }
        catch (Exception $e) 
        {
            $this->closeDb();
            throw $e;
        }
    }
    //select record
    public function selectRecord($id){
        try
        {
            $this->open_db();
            if($id>0)
            {	
                $query=$this->condb->prepare("SELECT * FROM conference WHERE id=?");
                $query->bindParam(1,$id);
                //$query->execute(array($id));
            }
            else
            {$query=$this->condb->prepare("SELECT * FROM conference");	/*$query->execute();*/}		
            
            $query->execute();
            $res=$query->fetchAll();	
            $query=null;				
            $this->close_db();                
            return $res;
        }
        catch(Exception $e)
        {
            $this->close_db();
            throw $e; 	
        }
    }

}
?>