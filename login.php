
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
          <div class="container" name="contact">
               <div class="text-center">
                    <h1 name="joinUs">Login</h1>

                    <br>

                    <div class="modal-body">
                         <form id="contact-form" method="post">
                              <div class="row">
                                   <div class="col-md-6">
                                   <input type="text" class="form-control" placeholder="TC NO" required maxlength = '11' minlength='11'style="background-color:#3f51b5; border-radius: 15px; color:white;" name="tcno" pattern="\d*">
                                   </div>

                                   <div class="col-md-6">
                                   <input type="password" class="form-control" value="root" name="sifre"  minlength="6"style="background-color:#3f51b5; border-radius: 15px; color:white;" maxlength="15" required>
                                   </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" name="giris" value="Login" style="background-color:#29ca8e; border-radius: 15px; color:white; width:250px">
                                </div>
                              </div>

                             
                         </form>
                    </div>

               </div>
          </div>
     </section>
     <?php
     if(isset ($_POST["giris"])){
     include("./components/connection.php");
     $tc = $_POST['tcno'];
     $sifre = $_POST['sifre'];
     $admin = $conn->prepare("SELECT * FROM üye WHERE üyeTc = ? AND üyeSifre = ?");
    $admin->execute([$tc,$sifre]);
    $result = $admin->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($result as $row){
     
     if($row['üyeTc'] !==NULL)
        {
          
          $_SESSION['user'] = $row['üyeTc'];
          $_SESSION['password'] = $row['üyeSifre'];
          echo $row['üyeTc'];
          if ($row['admin'] == '1'){
               $_SESSION['admin'] = "1";
                   
             }
             else{
                 echo "üye";
             }
             echo'<meta http-equiv="refresh" content="0;URL=index.php">';     //! Header çalışmadı
        }
     else{
          echo 'Giriş Başarısız';

     }
     //
    }
        
    
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