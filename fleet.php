
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
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50" onload="clearForm()">

<?php 
     require_once './components/navbar.php';
     require_once './components/connection.php';
     $kur = simplexml_load_file("https://www.tcmb.gov.tr/kurlar/today.xml");
     if ($kur != null)
     {
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
     }
     
     $bugun = date("y-m-d");
     $bugun = '20'.$bugun;
     
     $siparis = $conn->prepare("SELECT * from orders WHERE return_date < ? ");
     $siparis->execute([$bugun]);
     if($siparis!=null){
          foreach($siparis as $result){
               
               $conn
               ->prepare("UPDATE cars SET miktar = miktar+1 WHERE names = ?")
               ->execute([$result["car"]]);
          }
          $conn
               ->prepare("DELETE from orders WHERE return_date < ?")
               ->execute([$bugun]);
     }

     $musteri = $conn->prepare("SELECT * FROM orders WHERE ")
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
                    
                    $cars = $conn->prepare("SELECT * FROM cars WHERE miktar>0");
                    $cars->execute();
                    $results = $cars->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($results as $result){
                         if ($result['miktar']>0){
                         echo "<div class='col-md-4 col-sm-4'>
                         <div class='courses-thumb courses-thumb-secondary'>
                              <div class='courses-top'>
                                   <div class='courses-image'>
                                   <img src='./images/cars/".$result['images']."' class='img-responsive'>
                                   </div>
                                   <div class=\"courses-date\">
                                   <span title=\"passegengers\"><i class=\"fa fa-user\"></i> ".$result['capacity']."</span>
                                        <span title=\"luggages\"><i class=\"fa fa-briefcase\"></i> ".$result['Bagaj']."</span>
                                        <span title=\"doors\"><i class=\"fa fa-sign-out\"></i> ".$result['Kapı']."</span>
                                        <span title=\"transmission\"><i class=\"fa fa-cog\"></i> ".$result['Vites']."</span>
                                   </div>
                              </div>
               
                              <div class=\"courses-detail\">
                                   <h3><a href=\"fleet.php\">".$result['names']."</a></h3>
                                   <p><h6>".$result['years']." Model</h6></p>
                                   <p><strong>".$result['ozellik']."</strong></p>
                                   <p class=\"lead\"><small>Günlüğü</small> <strong>$".$result['Fiyat']."</strong></p>
                                   
                              </div>
               
                              <div class=\"courses-info\">
                              <form method=\"get\">
                                   <button type=\"button\" data-toggle=\"modal\" data-target=\".bs-example-modal\" class=\"section-btn btn btn-primary btn-block\" name='small' onclick=\"aracSec('".$result['names']."','".$result['Fiyat']."')\">Rezervasyon Yap</button>
                                   </form>
                              </div>
                         </div>
                    </div>
                    
                    ";
                         }
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
                         <form action="" id="contact-form" method = 'post'>

                              <input type="hidden" id="carss" name="carss" value="" />
                              <input type="hidden" id='fiyat' name='fiyat' value=""/>
                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Teslim Edilecek yer" required name='vloc' onkeydown="return /[a-z]/i.test(event.key)">
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Geri Teslim Yapılacak Yer" required name='rloc' onkeydown="return /[a-z]/i.test(event.key)">
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
                                        <input type="date" class="form-control" placeholder="Alınacak Tarih" required name='vdate' onkeydown="return false" <?php $bugun = date("y-m-d"); echo "min = '20".$bugun."'";  $newDate = date('y-m-d',strtotime($bugun. ' + 30 days')); echo "max = '20".$newDate."'";?> >
                                        
                                   </div>

                                   <div class="col-md-6">
                                        <input type="date" class="form-control" placeholder="Geri Teslim edilecek tarih" required name='rdate' ronkeydown="return false"  <?php $bugun = date("y-m-d"); echo "min = '20".$bugun."'";  $newDate = date('y-m-d',strtotime($bugun. ' + 90 days')); echo "max = '20".$newDate."'";?>>
                                   </div>
                              </div>
                              <!--Giriş yaptıysa burası gözükmemeli-->
                              <?php 
                              if (!isset($_SESSION['admin']))
                              if (!isset($_SESSION['user']))
                              {
                              ?>
                              <div class="row">
                                   <div class="col-md-6">
                              <input type="text" class="form-control" placeholder="İsim Soyisim" required name='isim' onkeydown="return /[a-z]/i.test(event.key)">
                                   </div>
                                   <div class="col-md-6">
                                   <input type="text" class="form-control" placeholder="Tc Kimlik Numarası" required name='tc' maxlength="11" minlength="10" required pattern="\d*">
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-md-6">
                                        <input type="email" class="form-control" placeholder="Mail adresi gir" required name='mail' >
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Telefon Numarası" required name='tel' maxlength="10" minlength="10" required pattern="\d*">
                                   </div>
                              </div>
                              
                              <?php  }
                              else {
                                   
                                   
                                   $res = $conn->prepare("SELECT count(*) FROM orders WHERE customer_id = ?");
                                     $res->execute([$_SESSION['user']]);
                                     $number_of_rows = $res->fetchColumn(); 
                                     
                                   if ($number_of_rows%3 == 0){
                                        echo '<div class="alert alert-success" role="alert">%20 indiriminiz mevcut</div>';
                                   }
                              }
                              
                              ?>
                              
                              
                         
                    </div>
                    <div class="modal-footer">
                         <button type="submit" class="section-btn btn btn-primary" name='byt'>Rezervasyon Yap</button>
                    </div>
                    
                    </form>
                    <?php 
                    if(isset($_POST['fiyat'])){
                         $fiyat = $_POST['fiyat'];
                         echo $fiyat;
                    }
                     if(isset ($_POST["rloc"])){
                         
                         include("./components/connection.php");
                         $rdate = $_POST['rdate'];
                         $vdate = $_POST['vdate'];
                         
                         $rloc = $_POST['rloc'];
                         $vloc = $_POST['vloc'];

                         if (!isset($_SESSION['admin']))
                         if (!isset($_SESSION['user'])){
                         $isim = $_POST['isim'];
                         $tc = $_POST['tc'];
                         $tel = $_POST['tel'];
                         $mail = $_POST['mail'];

                         }
                         else {
                              $isim = $_SESSION['ad'];
                              $tc = $_SESSION['user'];
                              $tel = $_SESSION['tel'];
                         }
                         if($vdate>$rdate){
                              echo "<script>alert('TARİH GİRİŞLERİNİZ YANLIŞ');</script>";
                         }
                         
                         
                         

                         else if(!empty($_POST['carss'])) {
                              //araba miktarını 1 azaltıyorum
                              $selected = $_POST['carss'];
                              $conn->prepare("INSERT INTO orders (customer_id,Customer_name,Customer_num,delivered_loc,return_loc,return_date,deliver_date,car) VALUES(?,?,?,?,?,?,?,?)")->execute([$tc,$isim,$tel,$vloc,$rloc,$rdate,$vdate,$selected]);
                              $conn
                              ->prepare("UPDATE cars SET miktar = miktar-1 WHERE names = ?")
                              ->execute([$selected]);
                              
                         } 
                         else {
                              echo '<script>alert("HATA");</script>';
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
          function aracSec(arac,fiyatt) {
               document.getElementById("carss").value = arac;
               document.getElementById('fiyat').value = fiyatt; //fiyatı yazdıramıyorum
          }
          function clearForm(){
               document.getElementById("contact-form").clear();
          }
          //formu resetleme
     </script>

</body>
</html>