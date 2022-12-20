<!-- CONTACT -->
<section id="contact">
          <div class="container">
               <div class="row">

                    <div class="col-md-6 col-sm-12">
                         <form id="contact-form" role="form" action="" method="post">
                              <div class="col-md-12 col-sm-12">
                                   <input type="text" class="form-control" placeholder="Tam isminizi giriniz" name="name" required>
                    
                                   <input type="email" class="form-control" placeholder="Email adresinizi giriniz" name="email" required>

                                   <textarea class="form-control" rows="6" placeholder="Mesajınızı giriniz" name="message" required></textarea>
                              </div>

                              <div class="col-md-4 col-sm-12">
                                   <input type="submit" class="form-control" name="sendmessage" value="Gönder">
                              </div>

                         </form>
                         <?php
                         require_once './components/connection.php';
                         if(isset ($_POST["sendmessage"])){
                              $name = $_POST['name'];
                              $email = $_POST['email'];
                              $message = $_POST['message'];
                              $conn->prepare("INSERT INTO contact (id,fullname,email,messag) VALUES(?,?,?,?)")->execute([0,$name,$email,$message]);
                         }
                         ?>

                    </div>

                    <div class="col-md-6 col-sm-12">
                         <div class="contact-image">
                              <img src="images/contact-1-600x400.jpg" class="img-responsive" alt="">
                         </div>
                    </div>

               </div>
          </div>
     </section> 