<?php
        require '../model/conference.php'; 
        session_start();             
        $conferencetb=isset($_SESSION['conferencetbl0'])?unserialize($_SESSION['conferencetbl0']):new conference();             
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$conferencetb->title?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
    <script>
        var myMap;
        function initMap() {
                document.getElementById("map").style.height = "500px";
                myMap = new google.maps.Map(document.getElementById("map"), {
                center:new google.maps.LatLng(<?=$conferencetb->lat?>,<?=$conferencetb->lng?>),
                zoom: 14,
            });
            var tmp=new google.maps.Marker({ 
                position: new google.maps.LatLng(<?=$conferencetb->lat?>,<?=$conferencetb->lng?>),
                map: myMap, 
                title:'<?=$conferencetb->title?>',
            });
        }
    </script>
</head>
<body onload="initMap()">
    <div class="text-center my-5">
        <h2><i><?=$conferencetb->title?></i></h2>
    </div> 
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row ">           
                <div class="col-md-12">                                                           
                    <form action="../index.php?act=update" method="post" >                        
                        <div class="form-group">
                            <h4>Conference Date : <?=$conferencetb->date?></h4>
                        </div>
                        <?php if (!empty($conferencetb->lat) && !empty($conferencetb->lng)) { ?>
                            <div class="form-group">
                                <h4>Address (latitude) : <?=$conferencetb->lat?></h4> 
                            </div>
                            <div class="form-group">
                                <h4>Address (longitude) : <?=$conferencetb->lng?></h4> 
                            </div>
                            <div class="form-group">                        
                                <div  id="map" style="height:500px"></div>
                            </div>
                        <?php } else { ?><br/> <?php } ?>	
                        <div class="form-group">
                            <h4>Conference Country : <?=$conferencetb->country?></h4>
                        </div>
                        <div class="col text-center my-5">
                        <a href="../index.php" class="btn btn-primary">Back</a>
                        <a href="../index.php?delete=<?=$conferencetb->id ?>" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?=$conferencetb->id ?>">Delete Record</a>
						<!-- DELETE MODAL -->
                        <div class="modal fade" id="deleteModal<?=$conferencetb->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content shadow">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Are you sure for delete conference "<?=$conferencetb->title ?>" ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form action="?id=<?=$conferencetb->id ?>" method="post">
                                <a href="../index.php?act=delete&id=<?=$conferencetb->id ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash" > Delete Record</i></a>
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>

                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>    
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD07tZ0jOR0o228qArJKMcdrheYUEyYL2s&callback=initMap"></script>

</body>
</html>