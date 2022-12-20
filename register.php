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
                    <h1 name="joinUs">Join Us</h1>

                    <br>

                    <div class="modal-body">
                         <form id="contact-form" method="post">
                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Ad" name="ad" required style="background-color:#3f51b5; border-radius: 15px; color:white;">
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Soyad" name="soyad" required style="background-color:#3f51b5; border-radius: 15px; color:white;">
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="TC NO" required minlength="11" maxlength="11" name="tcno" style="background-color:#3f51b5; border-radius: 15px; color:white;" pattern="\d*">
                                   </div>

                                   <div class="col-md-6">
                                   <input type="email" style="background-color:#3f51b5; border-radius: 15px; color:white;" class="form-control" placeholder="Email Adresi" name="email" required>
                                   </div>
                              </div>
                              <textarea class="form-control" style="background-color:#3f51b5; border-radius: 15px; color:white;" placeholder="Adres" required name="adres" style="width:%100; height:80px;resize: none;"></textarea>
                              
                              <div class="row">
                                   <div class="col-md-6">
                                   <input type="password" style="background-color:#3f51b5; border-radius: 15px; color:white;" class="form-control" value="root" name="sifre"  minlength="6" maxlength="15" required>
                                   </div>

                                   <div class="col-md-6">
                                   <input type="text" style="background-color:#3f51b5; border-radius: 15px; color:white;" class="form-control" placeholder="Telefon Numarası" minlength="10" name="tel" maxlength="10" required >
                                        
                                   </div>
                              </div>
                              
                              <div class="row">
                                   <div class="col-md-12">
                                        <input type="submit" style="background-color:#29ca8e;font-weight: bold; border-radius: 15px; color:white;" class="form-control" value="Kaydol" name="kaydet" required>
                                   </div>
                         </form>
                    </div>

               </div>
          </div>
     </section>
     <?php
     if(isset ($_POST["kaydet"])){
     require_once './components/connection.php';
     $name = $_POST['ad'];
     $soyad = $_POST['soyad'];
     $tc = $_POST['tcno'];
     $adres = $_POST['adres'];
     $email = $_POST['email'];
     $telno = $_POST['tel'];
     $sifre = $_POST['sifre'];
     $conn->prepare("INSERT INTO üye (üyeTc,üyeAd,üyeSoyad,üyeTelefon,üyeAdres,üyeMail,üyeSifre) VALUES(?,?,?,?,?,?,?)")->execute([$tc,$name,$soyad,$telno,$adres,$email,$sifre]);
     
     $_SESSION['user'] = $tc;
     $_SESSION['password'] = $sifre;


     echo'<meta http-equiv="refresh" content="0;URL=index.php">';     //! Header çalışmadı
     }
     ?>
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