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
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50" >

<?php 
     require_once './components/navbar.php';
     require_once './components/connection.php';

     ?>

     <!-- HOME -->
     <section id="home" >
          <div class="row">
               <div class="owl-carousel owl-theme home-slider" style="position:relative;" >
                    <?php 
                    $slider = $conn->prepare("SELECT * FROM slider");
                    $slider->execute();
                    $result = $slider->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                    foreach ($result as $row){
                         echo '
                    
                    
                    <img src="./images/'.$row["resim"].'" style="height:100%;">
                         
                    ';
                    
                    }
                    ?>

                    
               </div>
          </div>
     </section>

     <main>
          <section>
               <div class="container" >
                    <div class="row">
                         <div class="col-md-12 col-sm-12" >
                              <div class="text-center">
                                   <h2>Hakkımızda</h2>

                                   <br>

                                   <p class="lead">Özel araçlardan kargo kamyonetlerine kadar geniş bir yelpazede kiralama seçenekleri sunuyoruz.Prestijli kiralık arabalarımızdan biriyle şık bir şekilde gelin. Dünyanın önde gelen üreticilerinden özel, lüks ve sportif kiralık araç yelpazemizi keşfedin.</p>
                                   <a href="page.php?id=1" class="section-btn btn btn-primary btn-block">Daha fazla öğren</a>
                              </div>
                         </div>
                    </div>
               </div>
          </section>

          
          
               
                    
          <section id="testimonial">
               <div class="container">
                    <div class="row">

                         <div class="col-md-12 col-sm-12">
                              <div class="section-title text-center">
                                   <h2>Görüşler <small>Ülkemizin her bir köşesinden</small></h2>
                              </div>

                              <div class="owl-carousel owl-theme owl-client">
                                   <?php 
                         $test = $conn->prepare("SELECT names,title,images,comment,star FROM testimonials");
                         $test->execute();
                         $result = $test->fetchAll(PDO::FETCH_ASSOC);
                         foreach ($result as $row){
                              
                              echo " <div class='col-md-4 col-sm-4'>
                              <div class='item'>
                                   <div class='tst-image'>
                                   <img src='./images/".$row['images']."' class='img-responsive'>
                                   </div>
                                   <div class='tst-author'>
                                   <h4>".$row['names']."</h4>
                                   <span>".$row['title']."</span>
                                   </div>
                                   <p>".$row['comment']."</p>
                                   <div class='tst-rating'>";
                                        
                                   
                         for ($x = 0; $x < $row['star']; $x++) {
                              echo " <i class='fa fa-star'></i>   
                              ";
                            }
                            echo "</div>
                              </div>
                         </div>";
                         
                         }

                         ?>

                              </div>
                        </div>
                    </div>
               </div>
          </section> 
     </main>

     <?php
   require_once './components/footer.php';
   require_once './components/contactpackage.php';
   ?>

     <!-- SCRIPTS -->
     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>