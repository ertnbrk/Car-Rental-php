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
     ?>

     <section>
          <div class="container">
               <div class="text-center">
                    <h1>Görüşler</h1>

                    <br>

                    <p class="lead">Alanlarında uzman kullanıcılarımızın görüşleri</p>
               </div>
          </div>
     </section>

     <!-- TESTIMONIAL -->
     <section id="testimonial" class="section-background">
          <div class="container">
               <div class="row">
                    
                         <?php 
                         require_once './components/connection.php';
                         $test = $conn->prepare("SELECT names,title,images,comment,star FROM testimonials");
                         $test->execute();
                         $result = $test->fetchAll(PDO::FETCH_ASSOC);
                         foreach ($result as $row){
                              
                              echo " <div class='col-sm-4 col-xs-12'><div class='item' style='max-height:250px;'>
                         <div class='tst-image'>
                              <img src='data:image/jpeg;base64,".base64_encode($row['images'])."' class='img-responsive'>
                         </div>
                         <div class='tst-author'>
                              <h4>".$row['names']."</h4>
                              <span>".$row['title']."</span>
                         </div>
                         <p> <div class='tst-rating'>".$row['comment']."</p> ";
                         for ($x = 0; $x < $row['star']; $x++) {
                              echo " <i class='fa fa-star'></i>   
                              ";
                            }
                            echo " </div> </div> </div>";
                         
                         }

                         
                         
               
                    
                         ?>
                    
               </div>
               
               
               
          </div>
     </section> 

     <?php
   require_once './components/footer.php';
   
   ?>


     <!-- SCRIPTS -->
     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>