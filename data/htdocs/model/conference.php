<?php
class Conference{

    //table fields
    public $id;
    public $date;
    public $title;
    public $lat;
    public $lng;
    public $country;

    //message string
    public $id_msg;
    public $date_msg;
    public $title_msg;
    public $lat_msg;
    public $lng_msg;
    public $country_msg;
    function __construct()
    {
        $id=0;$date=getdate();$title="";$lat=0.0;$lng=0.0;$country="";
        $id_msg=$date_msg=$title_msg=$lat_msg=$lng_msg=$country_msg="";
    }
}
?>