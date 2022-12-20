<!DOCTYPE html>
<html lang="en">
<head>

     <title>Ertan Rent a Car</title>

     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/owl.carousel.css">
     <link rel="stylesheet" href="css/owl.theme.default.min.css">

     <!-- MAIN CSS -->
     <link rel="stylesheet" href="css/style.css">

</head>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

<?php 
     require_once './components/navbar.php';
     require_once './components/connection.php';
     $team = $conn->prepare("SELECT * FROM team");
     $team->execute();
     $result = $team->fetchAll(PDO::FETCH_ASSOC);
     ?>
     <section>
          <div class="container">
               <div class="text-center">
                    <h1><b>Ekibimiz</b></h1>

                    <br>

                    <p class="lead">Ekibe dahil olabilmek için bizimle iletişme geçiniz</p>
                    
                    <p class="lead">
                    <form id="contact-form" role="form" action="contact.php" method="post">
                    <input type="submit" class="form-control" name="yönlendir" value="İletişim" style="background-color:#29ca8e; border-radius: 15px; color:white; width:250px;margin-left:445px;">
                    </form>
                    </p>
               </div>
          </div>
     </section>

     <section id="team" class="section-background">
          <div class="container">
               <div class="row">
                    <?php 
                    foreach($result as $row) {
                    echo "<div class='col-md-3 col-sm-6'>
                    <div class='team-thumb'>
                         <div class='team-image'>
                         <img src='data:image/jpeg;base64,".base64_encode($row['image'])."' style = ' width:345px;height:300px;'class='img-responsive'>
                         </div>
                         <div class='team-info'>
                         <h3>".$row['isim']." ".$row['soyisim']."</h3>
                              <span>".$row['Pozisyon']."</span>
                         </div>
                         
                    </div>
               </div>";
                    }
                    echo "</div>
                    </div>
                    </section>";
                    ?>
                    
          <?php
   require_once './components/footer.php';
   
   ?>

     <div class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         <h4 class="modal-title" id="gridSystemModalLabel">Book Now</h4>
                    </div>
                    
                    <div class="modal-body">
                         <form action="#" id="contact-form">
                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Pick-up location" required>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Return location" required>
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Pick-up date/time" required>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Return date/time" required>
                                   </div>
                              </div>
                              <input type="text" class="form-control" placeholder="Enter full name" required>

                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Enter email address" required>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Enter phone" required>
                                   </div>
                              </div>
                         </form>
                    </div>

                    <div class="modal-footer">
                         <button type="button" class="section-btn btn btn-primary">Book Now</button>
                    </div>
               </div>
          </div>
     </div>

     <!-- SCRIPTS -->
     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>