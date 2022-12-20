<!-- PRE LOADER -->
<?php
session_start();
?>
<section class="preloader">
          <div class="spinner">

               <span class="spinner-rotate"></span>
               
          </div>
     </section>


     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">

               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="index.php" class="navbar-brand">DPU Car Rental</a>
               </div>

               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-nav-first">
                         <li class="active"><a href="index.php">Ana Ekran</a></li>
                         <li><a href="fleet.php">Garaj</a></li>
                         <li><a href="offers.php">Teklifler</a></li>
                         <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Daha Fazla<span class="caret"></span></a>
                              
                              <ul class="dropdown-menu">
                                   
                                   <li><a href="about-us.php">Hakkımızda</a></li>
                                   <li><a href="team.php">Team</a></li>
                                   <li><a href="testimonials.php">Görüşler</a></li>
                                   <li><a href="terms.php">Sözleşme</a></li>
                              </ul>
                         </li>
                         <li><a href="contact.php">İletişim</a></li>
                         
                              <?php 
                                   
                                   if (isset($_SESSION['user'])){
                                        echo '<li><a href="logout.php" class="register">Çıkş</a></li>';
                                        
                                   }
                                   if (isset($_SESSION['admin'])){
                                        echo '<li><a href="admin.php" class="login">Admin</a></li>';      
                                        }
                                   else {
                                        echo '<li><a href="register.php" class="register">Kayıt Ol</a></li>
                                        <li><a href="login.php" class="login">Giriş</a></li>';
                                        
                                   }
                              ?>
                              <!-- -->
                         
                         
                         
                         
                         
                    </ul>
               </div>

          </div>
     </section>