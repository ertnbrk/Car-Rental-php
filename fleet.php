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
     $kur = simplexml_load_file("https://www.tcmb.gov.tr/kurlar/today.xml");
     foreach ($kur -> Currency as $cur) {
          if ($cur["Kod"] == "USD") {
               $usdAlis  = $cur -> ForexBuying;
               $usdSatis = $cur -> ForexSelling;
          }
          
          if ($cur["Kod"] == "EUR") {
               $eurAlis  = $cur -> ForexBuying;
               $eurSatis = $cur -> ForexSelling;
          }
     }
   $cars = $conn->prepare("SELECT * FROM cars");
     $cars->execute();
     $result = $cars->fetchAll(PDO::FETCH_ASSOC);
     ?>

     <section>
          <div class="container">
               <div class="text-center">
                    <h1>Garaj</h1>

                    <br>

                    <p class="lead">Her ihtiyacın için binlerce aracımızla hizmetinizdeyiz</p>
                    <br>
                    
               </div>
               <table class="table table-dark">
  <thead>
    <tr class= "bg-success">
      <th scope="col">Doviz</th>
      <th scope="col">Alış</th>
      <th scope="col">Satış</th>
    </tr>
  </thead>
  <tbody>
    <tr class="bg-primary">
      <th scope="row">USD</th>
      <td><?php echo $usdAlis ?></td>
      <td><?php echo $usdSatis ?></td>
      
    </tr>
    <tr class="bg-info">
      <th scope="row">EUR</th>
      <td><?php echo $eurAlis ?></td>
      <td><?php echo $usdAlis ?></td>
      
    </tr>
    
  </tbody>
</table>
          </div>
     </section>

     <section class="section-background">
          <div class="container">
               <div class="row">
                    <?php
                    $sayi = count($result) -1;
                    
                    while($sayi>0){
                         echo "<div class='col-md-4 col-sm-4'>
                         <div class='courses-thumb courses-thumb-secondary'>
                              <div class='courses-top'>
                                   <div class='courses-image'>
                                   <img src='data:image/jpeg;base64,".base64_encode($result[$sayi]['image'])."' class='img-responsive'>
                                   </div>
                                   <div class=\"courses-date\">
                                   <span title=\"passegengers\"><i class=\"fa fa-user\"></i> ".$result[$sayi]['capacity']."</span>
                                        <span title=\"luggages\"><i class=\"fa fa-briefcase\"></i> ".$result[$sayi]['Bagaj']."</span>
                                        <span title=\"doors\"><i class=\"fa fa-sign-out\"></i> ".$result[$sayi]['Kapı']."</span>
                                        <span title=\"transmission\"><i class=\"fa fa-cog\"></i> ".$result[$sayi]['Vites']."</span>
                                   </div>
                              </div>
               
                              <div class=\"courses-detail\">
                                   <h3><a href=\"fleet.php\">".$result[$sayi]['name']."</a></h3>
                                   <p class=\"lead\"><small>from</small> <strong>$".$result[$sayi]['Fiyat']."</strong> <small>per weekend</small></p>
                                   
                              </div>
               
                              <div class=\"courses-info\">
                              <form method=\"get\">
                                   <button type=\"button\" data-toggle=\"modal\" data-target=\".bs-example-modal\" class=\"section-btn btn btn-primary btn-block\" name='small' onclick=\"aracSec('".$result[$sayi]['name']."')\">Rezervasyon Yap</button>
                                   </form>
                              </div>
                         </div>
                    </div>
                    
                    ";
                    $sayi-=1;
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
                         <h4 class="modal-title" id="gridSystemModalLabel">Rezervasyon Yap</h4>
                    </div>
                    
                    <div class="modal-body">
                         <form action="#" id="contact-form" method = 'post'>

                              <input type="hidden" id="carss" name="carss" value="" />

                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Teslim Edilecek yer" required name='vloc'>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Geri Teslim Yapılacak Yer" required name='rloc'>
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-md-6">
                                        <label><h6>Teslim Alınacak Tarih ↓</h6></label>
                                   </div>
                                   <div class="col-md-6">
                                   <label><h6> Geri Teslim Edilecek Tarih ↓</h6></label>

                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="date" class="form-control" placeholder="Alınacak Tarih" required name='vdate'>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="date" class="form-control" placeholder="Geri Teslim edilecek tarih" required name='rdate'>
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-md-6">
                              <input type="text" class="form-control" placeholder="İsim Soyisim" required name='isim'>
                                   </div>
                                   <div class="col-md-6">
                                   <input type="text" class="form-control" placeholder="Tc Kimlik Numarası" required name='tc' maxlength="11" minlength="10" required pattern="\d*">
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Mail adresi gir" required name='mail'>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Telefon Numarası" required name='tel' maxlength="10" minlength="10" required pattern="\d*">
                                   </div>
                              </div>
                              
                         
                    </div>
                    <div class="modal-footer">
                         <button type="submit" class="section-btn btn btn-primary" name='byt'>Rezervasyon Yap</button>
                    </div>
                    </form>
                    <?php 
                    if(isset ($_POST["isim"])){
                         include("./components/connection.php");
                         $isim = $_POST['isim'];
                         $tc = $_POST['tc'];
                         $tel = $_POST['tel'];
                         $rdate = $_POST['rdate'];
                         $vdate = $_POST['vdate'];
                         
                         $rloc = $_POST['rloc'];
                         $mail = $_POST['mail'];
                         $vloc = $_POST['vloc'];
                         
                         if($vdate>$rdate){
                              echo "Hatay";
                         }

                         else if(!empty($_POST['carss'])) {
                              $selected = $_POST['carss'];
                              $conn->prepare("INSERT INTO orders (customer_id,Customer_name,Customer_num,delivered_loc,return_loc,return_date,deliver_date,car) VALUES(?,?,?,?,?,?,?,?)")->execute([$tc,$isim,$tel,$vloc,$rloc,$rdate,$vdate,$selected]);
                          } else {
                              echo 'Araba Seçmediniz!';
                          }
                         
                    }
                    ?>
               </div>
          </div>
     </div>

     <!-- SCRIPTS -->
     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

     <script>
          function aracSec(arac) {
               document.getElementById("carss").value = arac;
          }
     </script>

</body>
</html>