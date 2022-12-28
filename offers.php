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
     ?>
     <section>
          <div class="container">
               <div class="text-center">
                    <h1>Teklifler ve Fırsatlar</h1>

                    <br>

                    <p class="lead">En cazip teklfiler için takipte kalınız.</p>
               </div>
          </div>
     </section>

     <section class="section-background">
          <div class="container">
               <div class="row">
                    
               <?php 
               $offers = $conn->prepare("SELECT * FROM offers");
               $offers->execute();
               $result = $offers->fetchAll(PDO::FETCH_ASSOC);
               foreach ($result as $row){
                    echo '<div class="col-md-4 col-sm-4">
                    <div class="courses-thumb courses-thumb-secondary">
                         <div class="courses-top">
                              <div class="courses-image">
                              <img src=\'data:image/jpeg;base64,'.base64_encode($row['offerimage']).'\' class="img-responsive">
                              </div>
                         </div>

                         <div class="courses-detail">
                              <h3><a href="fleet.php">'.$row['Caption'].'</a></h3>
                              <p class="lead"><strong>'.$row['offer'].'</strong></p>
                              <p>'.$row['Description'].'</p>
                         </div>
                    </div>
               </div>';
               }
               
               ?>
                    
               </div>
          </div>
     </section>

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
                                        <input type="text" class="form-control"
                                        name='alinacak' placeholder="Teslim edilecek yer" required>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" name='verilecek' class="form-control" placeholder="Geri teslim yapılacak yer" required>
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" name='alinacak_tarih' placeholder="Alınacak tarih/saat" required>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" name= 'verilecek_tarih'class="form-control" placeholder="Geri Verilecek tarih/saat" required>
                                   </div>
                              </div>
                              <input type="text" class="form-control" placeholder="İsim Soyisim" name='fullname' required>

                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Email gir" name='email' required>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" name='tel' placeholder="Enter phone" required>
                                   </div>
                              </div>
                         </form>
                    </div>
                    
               
                    <div class="modal-footer">
                         <button type="button" class="section-btn btn btn-primary" name='mybt'>Rezerve et</button>
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