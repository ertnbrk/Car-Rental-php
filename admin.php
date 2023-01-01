<?php 
 if(!isset($_SESSION['ad'])){
    // header("Location:index.php");
 }

?>
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
                            <a style="text-align:center;">
                            <div class="d-flex justify-content-center"><i class="fa fa-car fa-5x"></i></div>
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
                            <a style="text-align:center;">
                            <div class="d-flex justify-content-center"><i class="fa fa-inbox fa-5x"></i></div>
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
                            <a  style="text-align:center;">
                            <div class="d-flex justify-content-center"><i class="fa fa-dollar fa-5x"></i></div>
                                <h5>KAZANÇ
                                <br>
                                <?php 
                                $res = $conn->prepare("SELECT Fiyat,return_date,deliver_date,indirim
                                FROM orders
                                INNER JOIN cars
                                ON orders.car = cars.id;");
                                $res->execute();
                                $res = $res->fetchAll(); 
                                
                                $kazanc = 0;
                                
                                foreach ($res as $result){
                                   if($result['indirim'] == '0'){
                                        $rdate = strtotime($result['return_date']);
                                    $vdate = strtotime($result['deliver_date']);
                                    $fark = ($rdate - $vdate) / 86400;
                                    if ($fark>0){
                                        $kazanc += $fark * $result['Fiyat'];
                                    }
                                   }
                                   else {
                                        $rdate = strtotime($result['return_date']);
                                    $vdate = strtotime($result['deliver_date']);
                                    $fark = ($rdate - $vdate) / 86400;
                                    if ($fark>0){
                                        $kazanc += $fark * (($result['Fiyat'] * (100-$result['indirim']))/100);
                                    }
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
                    <div class="embed-responsive embed-responsive-16by9" style="overflow:auto;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0" >
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
                                
                            <th>E-posta</th>
                            <th>Mesaj</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                        <?php  $contact = $conn->prepare("SELECT * FROM contact");
                                $contact->execute();
                                $results = $contact->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($results as $result){
                                    $parca =substr($result['messag'],0,10);
                                    
                                  echo '  
                                
                        
                        
                        
<!-- Table -->

  
    
    <tr class="list-group-item-info">
      <td>'.$result["fullname"].'</td>
      <td>'.$result["email"].'</td>
      <td>'.$parca.'...</td>
      <td><button class="btn btn-primary" data-toggle="modal" data-target="#readmessage" value="'.$result["messag"].'" id="'.$result["id"].'" onclick = mesajcek("'.$result["id"].'")>Oku</button></td>
      
  
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
                         
                    </div>
                    
                    <div class="modal-body">
                    

                              <form method ="POST" action="admin.php">
                              <input type="hidden" name="ids" id="ids" value="" />
                              <div class="row" style="margin-top:5px;">
                                   <div class="col-md-12">
                                        <label><i id ='myLabel'>
                                          
                                        </i></label>
                                   </div>
                                   
                    </div>
                                   <div class="row">
                                        <div class="col-md-12" style="text-align:right;">
                                        <button type="submit" class="btn btn-danger" name="okundu">OKUNDU</button>
                                        </div>
                                   </div>
                                </form>
                                   <?php 
                                   if(isset($_POST['okundu'])){
                                        echo $_POST['ids'];
                                        $id = $_POST['ids'];

                                        
                                        $conn->prepare("DELETE FROM contact WHERE id= ? ;")->execute([$id]);
                                   
                              }
                                   ?>
                                </div>
                                </div>
                                </div>
                                </div>
                
                <!--/.Row-->
                <hr />
                <div class="row">

                    <div class="col-md-12">
                    <button type="button" data-toggle="modal" data-target="#myModal" style="margin-bottom:10px;" class="section-btn btn btn-primary btn-block" name='ekle' onclick="modalsec('EKLE');clearForm()"><img src="../car-rental/images/add.png"  style='width:50px;height:50px;'></button></h1>         
                    <?php
                    require_once '../car-rental/components/connection.php';
                    $cars = $conn->prepare("SELECT * FROM cars");
                    $cars->execute();
                    $results = $cars->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach($results as $result){
                        
                         echo "<div class='col-md-4 col-sm-4' style='margin-bottom:25px'>
                         <div class='courses-thumb courses-thumb-secondary'>
                              <div class='courses-top'>
                                   <div class='courses-image'>
                                   <img src='./images/cars/".$result['images']."' class='img-responsive'  style ='max-width: 100%;
                                   height: 250px'>
                                   </div>
                                   <div class=\"courses-date\">
                                   <span title=\"passegengers\"><i class=\"fa fa-user\"></i> ".$result['capacity']."</span>
                                        <span title=\"luggages\"><i class=\"fa fa-briefcase\"></i> ".$result['Bagaj']."</span>
                                        <span title=\"doors\"><i class=\"fa fa-sign-out\"></i> ".$result['Kapı']."</span>
                                        <span title=\"transmission\"><i class=\"fa fa-cog\"></i> ".$result['Vites']."</span>
                                        <span title=\"transmission\"><i class=\"fa fa-car\"></i> ".$result['miktar']."</span>
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
                                   <button type=\"button\" data-toggle=\"modal\" data-target=\"#myModal\" class=\"section-btn btn btn-primary btn-block\" name='small' onclick=\"aracSec('".$result['names']."','".$result['id']."','".$result['Kapı']."','".$result['Bagaj']."','".$result['years']."','".$result['ozellik']."','".$result['Fiyat']."','".$result['capacity']."','".$result['Vites']."','".$result['miktar']."');modalsec('DUZENLE')\">Düzenle</button>
                                   </form>
                              </div>
                         </div>
                    </div>
                    
                    ";
                    
                    }
                    
?>
                        
                         


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
                         <h4 class="modal-title" id="gridSystemModalLabel">Araba Menüsü</h4>
                    </div>
                    
                    <div class="modal-body">
                         <form action="admin.php" id="contact-form" class="contact-form" method = 'post' enctype="multipart/form-data">

                              <input type="hidden" id="carss" name="carss" value="" />
                                <input type="hidden" id="aracid" name="aracid" value =""/>
                                
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="MARKA" id="marka"  name='marka'>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="MODEL" id="model" name='model'>
                                   </div>
                              </div>
                              
                              
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                        <input type="text" placeholder='FİYAT' class="form-control"id="fiyat" name="fiyat" >
                                        
                                   </div>

                                   <div class="col-md-6">
                                   <input type="text" placeholder='ARAÇ BİLGİSİ' class="form-control"id="bilgi" name="bilgi">

                                   </div>
                              </div>
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                              <input type="text" class="form-control" placeholder="Kapı Sayısı" id="kapi" name='kapi' maxlength='30' pattern="\d*">
                                   </div>
                                   <div class="col-md-6">
                                   <input type="text" class="form-control" placeholder="Bagaj Kapasitesi"  id="bagaj" name='bagaj'maxlength='15'  pattern="\d*">
                                   </div>
                              </div>
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Kapasite" id="kapasite" name='Kapasite'   pattern="\d*">
                                   </div>
                                   <div class="col-md-6"> 
                                   <input type="text" class="form-control" placeholder="Miktar" id="miktar" name='miktar'   pattern="\d*">
                                    
                                    
                               </div>
                                   
                              </div>
                              <div class="row" style="margin-top:10px;">
                                   
                                
                                <div class="col-md-6">
                                        <select style="margin-top:10px" name="sanziman" required id="sansizman">
                                            <option selected disabled hidden>Şanzıman Türü</option>
                                            <option value="A">Otomatik</option>
                                            <option value="M">Manual</option>
                                            
                                        </select>
                                   </div>
                                   
                                   <div class="col-md-6">
                                        <input type="file" class="form-control" placeholder="Kapasite" id="myimage"  name='myimage' accept="image/png, image/gif, image/jpeg" />
                                    
                                    
                                   </div>

                                </div>
                                
                                
                                
                                    
                                    
                                </div>
                         
                    </div>
                    <div class="modal-footer">
                         <input type="submit" class="section-btn btn btn-primary" name='duzenle' id="degisken" value="düzenle">
                         <input type="submit" class="section-btn btn btn-primary" id='delete' name='delete' onclick="return confirm('Silmek istediğine emin misin ?')" value="sil">
                         

                    </div>
                    </form>
                    <?php 
                if(isset($_POST['delete'])){
                    $conn
                    ->prepare("DELETE FROM cars WHERE id = ?")
                    ->execute([$_POST['aracid']]);
                    echo "<script>alert('Silme İşlemi Başarılı'".$_POST['aracid']."');</script>";
                }
                else if (isset($_POST['EKLE'])){
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
                else if (isset($_POST['DUZENLE'])){
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
                    <div class="row">
                              <div class="col-md-4">
                              <button type="button" data-toggle="modal" data-target="#teammodal" style="margin-bottom:20px; width:90px;height:90px; text-align:center;" class="section-btn btn btn-primary btn-block" name='ekle' onclick=clearForm();modalsec("ekleteam")><img src="../car-rental/images/add.png" style='width:30px;height:30px;  align:center;'></button></h1>
                                   <?php 
                                   
                                   $team = $conn->prepare("SELECT * FROM team");
          $team->execute();
          $result = $team->fetchAll(PDO::FETCH_ASSOC);
          echo " 
          <div class='container'>
               <div class='row'> <form action='admin.php' id='contact-form' class='contact-form' method = 'post' enctype='multipart/form-data'>" ;
               foreach($result as $row) {
                    echo "<div class='col-md-3 col-sm-6'>
                    <div class='team-thumb'>
                         <div class='team-image'>
                         <img src='./images/".$row['images']."' style = ' width:345px;height:300px;'class='img-responsive'>
                         </div>
                         <div class='team-info'>
                         <h3>".$row['isim']." ".$row['soyisim']."</h3>
                              <span>".$row['Pozisyon']."</span>
                         </div>
                         
                    </div>
                    <div class='row'>
                    
                    <div class='col-md-6'>

                    <input type=\"hidden\" name=\"teamid\" value='".$row['id']."' id=\"takimid\"/>
                    <button type='submit'  name='silt'  style='width:100%; height:30px;' class='btn btn-danger' >SİL</button>
                    
                    </div>
                    
                    <div class='col-md-6'>
                    <button type='button' data-toggle='modal' data-target='#teammodal'onclick=teammodals('".$row['isim']."','".$row['soyisim']."','".$row['Pozisyon']."','team');modalsec('teamduzen') name='duzenlet' style='width:100%; height:30px;' class='btn btn-info' >Düzenle</button>

                    </div></div>
               </div>";
               
                    }
                    echo " </form> </div> 
                    </div>
                   ";
                   
                         
                                   ?>
                              </div>
                         </div>
               
          </div>
     </section>
                    <?php 
                    
                    if(isset($_POST['silt'])){
                         
                         $id = $_POST['teamid'];
                         $conn->prepare("DELETE FROM team WHERE id = ? ;")->execute([$id]);
                    }
                    ?>
                    

                    <?php 
                    if (isset($_POST['pozisyon'])){
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

                    
                    $isim = $_POST['isim'];
                    $soy = $_POST['soyisim'];
                    $pozisyon = $_POST['pozisyon'];


                    $yeniresim = uniqid("IMG-",true). '.'.$imageExtension;
                   
                    $path = 'images/' . $yeniresim;
                     move_uploaded_file($tmpname, $path);
                    
                    if(isset($_POST['teamduzen'])){
                     //UPDATE işlemi

                    }
                    else{
                         $conn->prepare("INSERT INTO team (isim,soyisim,Pozisyon,images) VALUES(?,?,?,?)")->execute([$isim,$soy,$pozisyon,$yeniresim]);
                    }


                  }
               }
               
                               
                    ?>
                    





                    <!--Team modal-->
     <div class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id ='teammodal'>
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         <h4 class="modal-title" id="gridSystemModalLabel">Takım arkadaşı ekle</h4>
                    </div>
                    
                    <div class="modal-body">
                         <form action="admin.php" id="contact-form" class="contact-form" name="tmodal" method = 'post' enctype="multipart/form-data">

                              
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="İsim" id='isim'   name='isim' onkeydown="return /[a-z]/i.test(event.key)" required>
                                   </div>

                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Soy isim" id='soyisim' value='' name='soyisim' onkeydown="return /[a-z]/i.test(event.key)" required>
                                   </div>
                              </div>
                              
                              
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                        <input type="text" placeholder='Pozisyon' id='poz' class="form-control" name="pozisyon" required>
                                        
                                   </div>

                                   <div class="col-md-6">
                                   <label style="margin-top:40px;">Vesikalık resim ekleyiniz</label>
                                   

                                   </div>
                              </div>
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6"></div>
                                   <div class="col-md-6"><input type="file" name="myimage" id="img" style="display:block;" accept="image/png, image/gif, image/jpeg"/></div>
                              </div>

                              <div class="row">
                                  <input type="submit" class="btn btn-info" name="teambut" id="teambut" value="Gönder">
                              </div>
                              
               </form>
                              
                              
               </div></div></div>

                                </div>
                                

                    
                    

<div class="row" >
<div class="col-md-6">
 
<div class="col-md-12" >

               
               <br><br>
               
               
               <div class="owl-carousel owl-theme home-slider">
               
                    <?php 
                    $slider = $conn->prepare("SELECT * FROM slider");
                    $slider->execute();
                    $result = $slider->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                    foreach ($result as $row){

                         echo '
                         
                    <div class="item-slider">
                    
                    <img src="./images/'.$row["resim"].'" stlye="max-height:100px;">
                     
                    <form action="admin.php" method = "post">
                     <input type="hidden" name="sliderid" value="'.$row["idslider"].'"/>
                      
                     <button  type="submit" class ="btn btn-danger" id="slidersil" value="'.$row["idslider"].'" name="slidersil" style="margin-top:20px;"> SİL </button>
                     
                     </div>
                     </form>
                    ';
                    
                    
                    
               }

                    if(isset($_POST["slidersil"])){
                         $conn->prepare("DELETE FROM slider WHERE idslider = ?")->execute([$_POST['sliderid']]);
                    }
                    
                    ?>

                    
              
          </div>
               
                    


               <form method = "post" action="admin.php" enctype="multipart/form-data">
               <button class="btn btn-primary" name="sliderekle" style="margin-top:10px;">EKLE</button>
               <label style="margin-top:11px;">1920x700 önerilir</label>
               <input type="file" name="sliderekle"  id= accept="image/png, image/gif, image/jpeg" class="form-control" style="width:30%;" required>
                    </form>
                    <?php 
                    if(isset($_POST['sliderekle'])){   
                         
                         $fileName = $_FILES["sliderekle"]["name"]; 
                         $tmpname = $_FILES["sliderekle"]["tmp_name"]; 
                         $filesize = $_FILES["sliderekle"]["size"]; 
                         
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
                        
                         $path = 'images/' . $yeniresim;
                         move_uploaded_file($tmpname, $path);

                         $conn->prepare("INSERT INTO slider (resim) VALUES(?)")->execute([$yeniresim]);

                       }

                    }
                    ?>
               </div>
               </div>
                    <!--Görüşler modal-->
                    <div class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id ='modalgorus'>
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         <h4 class="modal-title" id="gridSystemModalLabel">Değerli görüşler</h4>
                    </div>
                    
                    <div class="modal-body">
                         <form action="admin.php" id="contact-form" class="contact-form" name='gorusmodal' method = 'post' enctype="multipart/form-data">

                              
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="İsim" id='gorusisim'   name='isim' onkeydown="return /[a-z]/i.test(event.key)" required>
                                   </div>

                                   <div class="col-md-6">
                                   <input type="text" placeholder='Unvan' id='goruspoz' class="form-control" name="pozgorus" required>
                                   
                                   </div>
                              </div>
                              
                              
                              <div class="row" style="margin-top:10px;">
                                   <div class="col-md-6">
                                   <textarea name="yorum" id="yorum" style="overflow:auto;resize:none" cols="30" rows="5"></textarea>
                                        
                                   </div>

                                   
                              
                                   
                                   <div class="col-md-6"><input type="file" name="myimage" id="img" style="display:block;" accept="image/png, image/gif, image/jpeg"/></div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6"><select id="yildiz" name="yildiz" style="width:200px;height:40px;">
                                   <option value="1" style="font-family:FontAwesome;">&#xf005;</option>
                                        <option value="2" style="font-family:FontAwesome;">&#xf005;&#xf005;</option>
                                        <option value="3" style="font-family:FontAwesome;">&#xf005;&#xf005;&#xf005;</option>
                                        <option value="4" style="font-family:FontAwesome;">&#xf005;&#xf005;&#xf005;&#xf005;</option>
                                        <option value="5" style="font-family:FontAwesome;">&#xf005;&#xf005;&#xf005;&#xf005;&#xf005; </option>
                                   </select>
</div>
                                   <div class="col-md-6">
                                        <button type="submit" id="gorusbut"  class="btn btn-info" >ONAYLA</button>
                                   </div>
                                  
                              </div>
                              
               </form>
                              
                              
               </div></div></div>

                                </div>
                                
                                

               <div class="col-md-6">
                    <!--Değerli yorumlar-->
                    <form action='admin.php' id='contact-form'  class="contact-form" method = 'post' enctype='multipart/form-data'> 
                    <button type='button' class='btn btn btn-primary'data-toggle='modal' onclick=modalsec("testekle") data-target='#modalgorus' name='ekle'>EKLE</button>
                    <br><br>
                    
                              <div class="owl-carousel owl-theme owl-client">
                                   <?php 

                         $test = $conn->prepare("SELECT * FROM testimonials");
                         $test->execute();
                         $result = $test->fetchAll(PDO::FETCH_ASSOC);
                         foreach ($result as $row){
                              $yorum =substr($row["comment"],0,20);
                              
                              echo " <div class='col-md-4 col-sm-4'>
                              <div class='item'>
                                   <div class='tst-image'>
                                   <img src='./images/".$row['images']."' class='img-responsive'>
                                   </div>
                                   <div class='tst-author'>
                                   <h4>".$row['names']."</h4>
                                   <span>".$row['title']."</span>
                                   </div>
                                   <p>".$yorum."</p>
                                   <div class='tst-rating'>
                                   
                                   <input type=\"hidden\" name=\"yorumlar\" value='".$row['count']."' id=\"yorumlar\"/>
                                   
                                   ";
                                   
                                   
                         for ($x = 0; $x < $row['star']; $x++) {
                              echo " <i class='fa fa-star'></i>   
                              ";
                            }
                            echo "<br>
                            <button class='btn btn-danger'>SİL</button>
                                   <button  type ='button' onclick =modalsec(\"testduzenle\") class='btn btn-info' data-toggle='modal' data-target='#modalgorus' >Düzenle</button>
                                   
                                   
                            </div>
                              </div>
                         </div>
                         ";
                         
                         }
                         





                         if (isset($_POST['slidersil'])){
                              $sliderid = $_POST['sliderid'];
                              echo "<alert>".$sliderid."</alert>";
                             // $conn->prepare("DELETE FROM slider WHERE sliderid = ? ")->execute([$sliderid]);
                         }
                         else if (isset($_POST['sliderekle'])){

                         }
                         else if (isset($_POST['sliderduzen'])){
                              $sliderid = $_POST['sliderid'];
                         }
                         ?>
                         <?php 
                    if (isset($_POST['pozgorus'])){
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

                    
                    $isim = $_POST['isim'];
                    $pozisyon = $_POST['pozgorus'];
                    $yorumlar = $_POST['yorum'];
                    $degerlendirme = $_POST['yildiz'];
                    $yeniresim = uniqid("IMG-",true). '.'.$imageExtension;
                   
                    $path = 'images/' . $yeniresim;
                     move_uploaded_file($tmpname, $path);
                    
                    if(isset($_POST["testduzenle"])){
                     //UPDATE işlemi
                         echo "<script>alert('duzeniçi')</script>";
                    }
                    else if (isset($_POST['testekle'])){
                         echo "<script>alert('ekleiç')</script>";

                         $conn->prepare("INSERT INTO testimonials (names,title,images,comment,star) VALUES(?,?,?,?,?)")->execute([$isim,$pozisyon,$yeniresim,$yorumlar,$degerlendirme]);
                    }


                  }
               }
               
                               
                    ?>
                         

                              </div>
                              
                              </form>
               </div>
          </div>
     








                                
     <script>
          
          function aracSec(arac,aracid,kapi,bagaj,yil,ozellik,fiyat,kapasite,vites,model,miktar) {
               document.getElementById("carss").value = arac;
                document.getElementById('aracid').value = aracid; //fiyatı yazdıramıyorum
                document.getElementById('kapi').value = kapi;
                document.getElementById('marka').value = arac;
                document.getElementById('model').value = model;
                document.getElementById('fiyat').value = fiyat;
                document.getElementById('bilgi').value = ozellik;
                document.getElementById('bagaj').value = bagaj;
                document.getElementById('kapasite').value = kapasite;
                document.getElementById('model').value = yil;
                document.getElementById('miktar').value = miktar;
          }
          
          function clearForm(){
               alert("clear");
               document.getElementById("contact-form").reset();
               
               document.getElementsByName("tmodal").reset();
               //document.getElementsByClassName("contact-form").reset();
          }
          function mesajcek(id){
          
            var myid = id;
            
            document.getElementById('myLabel').innerHTML = document.getElementById(myid).value;
            document.getElementById('ids').value = myid;
            
          }
          function modalsec(modal){
                    if (modal =="DUZENLE" || modal == "EKLE"){

                    
                    document.getElementById('degisken').value = modal;
                    document.getElementById('degisken').name = modal;
                    
               }
               if (modal == "teamduzen" || modal=="ekleteam"){
                    
                    document.getElementById('teambut').name = modal;
                    
               }
               if (modal =="testekle" || modal =="testduzenle"){
                    document.getElementById('gorusbut').name = modal;
               }
                    
               
               
          }
          function teammodals(isim,soyisim,poz,type){
               alert(isim);
               if  (type =="team"){
                    document.getElementById('isim').value = isim;
                    document.getElementById('soyisim').value = soyisim;
                    document.getElementById('poz').value = poz;
               }
               else{
                    document.getElementById('gorusisim').value = isim;
                    document.getElementById('gorussoyisim').value = soyisim;
                    document.getElementById('goruspoz').value = poz;
               }
               
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