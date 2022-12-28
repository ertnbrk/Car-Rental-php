
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
               <div class="sm-6">
                    <div class="text-left">
                         <h1 name="joinUs" style="text-align:center;">Gösterge PANELİ</h1>

                         <br>
                         <br>
                         <br>
                         <div class="modal-body">
                         <div class="row">
                    <div class="col-md-4">
                        <div class="main-box mb-red" style='height:170px;'>
                            <a href="#"style="text-align:center;">
                            <div class="d-flex justify-content-center"><i class="fa fa-bolt fa-5x"></i></div>
                                <h5>Kirada olan Araçlar <br><?php 
                                $bugun = date("y-m-d");
                                $bugun = '20'.$bugun;
                                
                                $res = $conn->prepare("SELECT count(*) FROM orders WHERE return_date > ? ");
                                $res->execute([$bugun]);
                                   
                                    
                                    $number_of_rows = $res->fetchColumn(); 

                                    
                                        echo $number_of_rows;
                                    
                                    
                                    
                                    ?></h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="main-box mb-dull" style='height:170px;'>
                            <a href="#" style="text-align:center;">
                            <div class="d-flex justify-content-center"><i class="fa fa-plug fa-5x"></i></div>
                                <h5>Gelen Mesajlar<br>
                                
                                
                                <?php 
                                     $res = $conn->prepare("SELECT count(*) FROM contact");
                                     $res->execute();
                                     $number_of_rows = $res->fetchColumn(); 
                                     echo $number_of_rows;
                                ?>
                                </h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="main-box mb-pink" style='height:170px;'>
                            <a href="#" style="text-align:center;">
                            <div class="d-flex justify-content-center"><i class="fa fa-dollar fa-5x"></i></div>
                                <h5>KAZANÇ
                                <br>
                                <?php 
                                $res = $conn->prepare("SELECT Fiyat,return_date,deliver_date
                                FROM orders
                                INNER JOIN cars
                                ON orders.car = cars.id;");
                                $res->execute();
                                $res = $res->fetchAll(); 
                                
                                $kazanc = 0;
                                foreach ($res as $result){
                                    $rdate = strtotime($result['return_date']);
                                    $vdate = strtotime($result['deliver_date']);
                                    $fark = ($rdate - $vdate) / 86400;
                                    if ($fark>0){
                                        $kazanc += $fark * $result['Fiyat'];
                                    }
                                    
                                }
                                echo $kazanc." $";
                                ?>
                                </h5>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- /. ROW  -->

                <div class="row">
                    <div class="col-md-7
                    ">
                    <div class="embed-responsive embed-responsive-16by9">
                        <div class="table-responsive" >
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th>Müşteri Numarası</th>
                                        <th>İsim</th>
                                        <th>Numarası</th>
                                        <th>TEslim yeri</th>
                                        <th>Geri teslim yeri</th>
                                        <th>Süre(gün)</th>
                                        <th>Araba</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                   $bugun = date("y-m-d");
                                   $bugun = '20'.$bugun;
                                    $orders = $conn->prepare("SELECT customer_id, Customer_name,Customer_num,delivered_loc,return_loc,return_date,deliver_date,names
                                    FROM orders
                                    INNER JOIN cars ON orders.car = cars.id WHERE return_date > ?");
                                    $orders->execute([$bugun]);
                                    $results = $orders->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($results as $item){
                                        $rdate = strtotime($item['return_date']);
                                        $vdate = strtotime($item['deliver_date']);
                                        $fark = ($rdate - $vdate) / 86400;
                                   echo " 
                                   <tr>
                                        <td>".$item['customer_id']."</td>
                                        <td><span class='label label-success'>".$item['Customer_name']."</span></td>
                                        <td>".$item['Customer_num']."</td>
                                        <td>".$item['delivered_loc']."</td>
                                        <td><span class='label label-info'>".$item['return_loc']."</span></td>
                                        <td>".$fark."</td>
                                        <td>".$item['names']."</td>
                                        
                                    </tr>";
                                    }
                                    ?>
 
                                </tbody>
                            </table>
                        </div>
                        </div>
                        
                    </div>
                    <div class="col-md-5" id="messtable">
                        <!--Mesajlar buraya gelicek -->
                        <div class="table-wrapper-scroll-y my-custom-scrollbar" style="max-height:360px; overflow:auto;">
                        <table class="table">
                        <thead>
                            <tr>
                            <th>Gönderen</th>
                                <th></th>
                            <th>E-posta</th>
                            <th>Mesaj</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  $contact = $conn->prepare("SELECT * FROM contact");
                                $contact->execute();
                                $results = $contact->fetchAll(PDO::FETCH_ASSOC);
                                function getmessage($message) {
                                   $mesaj =  $message;
                                 }
                                foreach ($results as $result){
                                    $parca =substr($result['messag'],0,10);
                                    
                                  echo '  
                                
                        
                        
                        
<!-- Table -->

  
    
    <tr class="list-group-item-info">
      <td>'.$result["fullname"].'</td>
          <td><input type="checkbox" value="" /></td>
      <td>'.$result["email"].'</td>
      <td>'.$parca.'...</td>
      <td><button class="btn btn-primary" data-toggle="modal" data-target="#readmessage" onclick"mesajcek("'.$result["messag"].'")">Oku</button></td>
      
  
</div>
             </div>
               






';}?></tbody>
</table> </div>
                    </div>
                    
                                   </div>
                                   <!-- mesaj okuma modal -->
                                   <div class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id ='readmessage'>
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         <h4 class="modal-title" id="gridSystemModalLabel">Mesaj Oku</h4>
                    </div>
                    
                    <div class="modal-body">
                    

                              
                              <div class="row" style="margin-top:5px;">
                                   <div class="col-md-12">
                                        <label><i>
                                          
                                        </i></label>
                                   </div>
       
                    </div>
                                </div>
                                </div>
                                </div>
                                </div>
                
                <!--/.Row-->
                <hr />
                <div class="row">

                    <div class="col-md-12">
                                   
                    <?php
                    require_once '../car-rental/components/connection.php';
                    $cars = $conn->prepare("SELECT * FROM cars");
                    $cars->execute();
                    $results = $cars->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($results as $result){
                        
                         echo "<div class='col-md-4 col-sm-4' style='margin-bottom:25px;'>
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
                                   <button type=\"button\" data-toggle=\"modal\" data-target=\"#myModal\" class=\"section-btn btn btn-primary btn-block\" name='small' onclick=\"aracSec('".$result['names']."','".$result['id']."')\">Düzenle</button>
                                   </form>
                              </div>
                         </div>
                    </div>
                    
                    ";
                    
                    }
                    
?>
                        
                         <button type="button" data-toggle="modal" data-target="#myModal" class="section-btn btn btn-primary btn-block" name='ekle'><img src="../car-rental/images/add.png" style='width:50px;height:50px;'></button></h1>


                                   </div>
                    
                </div>
                

                </div>
                </div>
                </div>
                <div class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id ='myModal'>
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         <h4 class="modal-title" id="gridSystemModalLabel">Düzenle</h4>
                    </div>
                    
                    <div class="modal-body">
                         <form action="admin.php" id="contact-form" method = 'post' enctype="multipart/form-data">

                              <input type="hidden" id="carss" name="carss" value="" />
                                <input type="hidden" id="aracid" name="aracid" value =""/>
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="MARKA"   name='marka'>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="MODEL"  name='model'>
                                   </div>
                              </div>
                              
                              
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                        <input type="text" placeholder='FİYAT' class="form-control" name="fiyat" >
                                        
                                   </div>

                                   <div class="col-md-6">
                                   <input type="text" placeholder='ARAÇ BİLGİSİ' class="form-control" name="bilgi">

                                   </div>
                              </div>
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                              <input type="text" class="form-control" placeholder="Kapı Sayısı"  name='kapi' maxlength='30' pattern="\d*">
                                   </div>
                                   <div class="col-md-6">
                                   <input type="text" class="form-control" placeholder="Bagaj Kapasitesi"  name='bagaj'maxlength='15'  pattern="\d*">
                                   </div>
                              </div>
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Kapasite"  name='Kapasite'   pattern="\d*">
                                   </div>
                                   <div class="col-md-6"> 
                                   <input type="text" class="form-control" placeholder="Miktar"  name='miktar'   pattern="\d*">
                                    
                                    
                               </div>
                                   
                              </div>
                              <div class="row" style="margin-top:10px;">
                                   
                                
                                <div class="col-md-6">
                                        <select style="margin-top:10px" name="sanziman">
                                            <option selected disabled hidden>Şanzıman Türü</option>
                                            <option value="A">Otomatik</option>
                                            <option value="M">Manual</option>
                                            
                                        </select>
                                   </div>
                                   
                                   <div class="col-md-6">
                                        <input type="file" class="form-control" placeholder="Kapasite"  name='myimage' accept="image/png, image/gif, image/jpeg" />
                                    
                                    
                                   </div>

                                </div>
                                
                                
                                
                                    
                                    
                                </div>
                         
                    </div>
                    <div class="modal-footer">
                         <button type="submit" class="section-btn btn btn-primary" name='duzenle'>Düzenle</button>
                         <button type="submit" class="section-btn btn btn-primary" name='delete' onclick="return confirm('Silmek istediğine emin misin ?')">Sil</button>
                         <button type="submit" class="section-btn btn btn-primary" name='ekle' >Ekle</button>

                    </div>
                    </form>
                    <?php 
                if(isset($_POST['delete'])){
                    $conn
                    ->prepare("DELETE FROM cars WHERE id = ?")
                    ->execute([$_POST['aracid']]);
                    echo "<script>alert('Silme İşlemi Başarılı'".$_POST['aracid']."');</script>";
                }
                else if (isset($_POST['ekle'])){
                    $marka = $_POST['marka'];
                    $model = $_POST['model'];
                    $fiyat = $_POST['fiyat'];
                    $bilgi = $_POST['bilgi'];
                    $kapi = $_POST['kapi'];
                    $bagaj = $_POST['bagaj'];
                    $kapasite = $_POST['Kapasite'];
                    $sanziman = $_POST['sanziman'];
                    $miktar = $_POST['miktar'];
                    
                    

          $fileName = $_FILES["myimage"]["name"]; 
          $tmpname = $_FILES["myimage"]["tmp_name"]; 
          $filesize = $_FILES["myimage"]["size"]; 
          
          $image_ex = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif');
        $imageExtension = explode('.',$fileName);
        $imageExtension = strtolower(end($imageExtension)); 

        if(!in_array($imageExtension, $allowTypes)){ 
            echo "hata";
                             
        }
        else if ($filesize >10000000000){
          echo "<script>alert('Boyutu çok fazla');</script>";
        }
        else{
          $yeniresim = uniqid("IMG-",true). '.'.$imageExtension;
         
          $path = 'images/cars/' . $yeniresim;
          move_uploaded_file($tmpname, $path);
          
          $conn->prepare("INSERT INTO cars (names,years,images,capacity,Kapı,Bagaj,Vites,ozellik,Fiyat,miktar) VALUES(?,?,?,?,?,?,?,?,?,?)")->execute([$marka,$model,$yeniresim,$kapasite,$kapi,$bagaj,$sanziman,$bilgi,$fiyat,$miktar]);
         
        }
                             

                }
                else if (isset($_POST['duzenle'])){
                    if(isset($_POST['aracid'])){
                        $marka = $_POST['marka'];
                        $model = $_POST['model'];
                        $fiyat = $_POST['fiyat'];
                        $bilgi = $_POST['bilgi'];
                        $kapi = $_POST['kapi'];
                        $bagaj = $_POST['bagaj'];
                        $kapasite = $_POST['Kapasite'];
                        $sanziman = $_POST['sanziman'];
                        $miktar = $_POST['miktar'];

                        $fileName = $_FILES["myimage"]["name"]; 
                        $tmpname = $_FILES["myimage"]["tmp_name"]; 
                        $filesize = $_FILES["myimage"]["size"]; 
                        
                      $image_ex = pathinfo($fileName, PATHINFO_EXTENSION);
                      $allowTypes = array('jpg','png','jpeg','gif');
                      $imageExtension = explode('.',$fileName);
                      $imageExtension = strtolower(end($imageExtension)); 
              
                      if(!in_array($imageExtension, $allowTypes)){ 
                          echo "hata";
                                           
                      }
                      else if ($filesize >10000000000){
                        echo "<script>alert('Boyutu çok fazla');</script>";
                      }
                      else{
                        $yeniresim = uniqid("IMG-",true). '.'.$imageExtension;
                       
                        $path = 'images/cars/' . $yeniresim;
                         move_uploaded_file($tmpname, $path);
                        
                        $conn->prepare("UPDATE cars
                    SET names = ?, years= ?,images = ?,capacity = ?,Kapı = ?,Bagaj = ?,Vites = ?, ozellik = ?,Fiyat = ?,miktar = ?
                    WHERE id = ?")->execute([$marka,$model,$yeniresim,$kapasite,$kapi,$bagaj,$sanziman,$bilgi,$fiyat,$miktar,$_POST['aracid']]);
                       
                      }


                    
                    }
                    else {
                        echo "<script>alert('Araç id yok');</script>";
                    } 
                }
                ?>
                <!--/.Row-->
                <hr />
                         </div>
                         

                    </div>
                    <div class="sm-6">
                    <div class="text-right">
                              
                              </div>
                    </div>
               </div>
               
          </div>
     </section>
     

<?php
   require_once './components/footer.php';
   require_once './components/contactpackage.php';
   ?>
     <script>
          function aracSec(arac,aracid) {
               document.getElementById("carss").value = arac;
                document.getElementById('aracid').value = aracid; //fiyatı yazdıramıyorum
          }
          function clearForm(){
               document.getElementById("contact-form").clear();
          }
          function mesajcek(mesaj){
               <?php $mesajm = "<script>mesaj</script>"; ?>
            var message = mesaj;
            alert(message);
            
          }
          //formu resetleme
     </script>
     <!-- SCRIPTS -->
     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/owl.carousel.min.js"></script>
     <script src="js/smoothscroll.js"></script>
     <script src="js/custom.js"></script>

</body>
</html>