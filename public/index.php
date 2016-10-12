<?php
   require_once ('includes/header.php');

    //Message handling
    if(isset($_GET['error'])){
        $error = $_GET['error'];
    }
    if($user->isLoggedIn){
        $user->redirect('home.php');
    }
    
?>
<div class="container-fluid wrap">
   <div class="row">
      <div class="col-md-4 col-md-offset-4">
         <div class="logo text-center">
            <h1>BARROC IT.</h1>
         </div>
         <div class="well text-center">
             <?php
                 if(!empty($error)){
                     ?>
                     <div class="alert alert-danger" role="alert">Error: <?php echo $error; ?></div>
                     <?php
                 }
             ?>
            <h2>Login</h2>
            <form method="POST" action="<?php echo BASE_URL; ?>/app/controllers/authController.php">
               <div class="form-group">
                  <input type="text" placeholder="Username" class="form-control" id="txtUsername" name="txtUsername" required>
               </div>
               <div class="form-group">
                  <input type="password" placeholder="Password" class="form-control" id="txtPassword" name="txtPassword"required>
               </div>
               <input type="submit" value="Login" name="type" class="btn btn-primary btn-block">
            </form>
         </div>
      </div>
   </div>
<?php
   require_once ('includes/footer.php');
?>

