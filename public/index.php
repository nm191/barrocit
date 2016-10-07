<?php
   require_once ('includes/header.php');
?>
<div class="container-fluid wrap">
   <div class="row">
      <div class="col-md-4 col-md-offset-4">
         <div class="logo text-center">
            <h1>BARROC IT.</h1>
         </div>
         <div class="well text-center">
            <h2>Login</h2>
            <form action="">
               <div class="form-group">
                  <input type="text" placeholder="Username" class="form-control" id="txtUsername" required>
               </div>
               <div class="form-group">
                  <input type="password" placeholder="Password" class="form-control" id="txtPassword" required>
               </div>
               <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
         </div>
      </div>
   </div>
<?php
   require_once ('includes/footer.php');
?>

