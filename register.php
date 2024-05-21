<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $existingUser = $usersCollection->findOne(['username' => $username]);

    if ($existingUser) {
        echo "Username already exists!";
    } else {
        $result = $usersCollection->insertOne([
            'username' => $username,
            'password' => $password,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);

        if ($result->getInsertedCount() > 0) {
            echo "User registered successfully!";
            header("Location: protected.php");
        } else {
            $message= "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<style>
    .gradient-custom-2 {
/* fallback for old browsers */
background: #fccb90;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
}

@media (min-width: 768px) {
.gradient-form {
height: 100vh !important;
}
}
@media (min-width: 769px) {
.gradient-custom-2 {
border-top-right-radius: .3rem;
border-bottom-right-radius: .3rem;
}
}
</style>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body>


<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <h4 class="mt-1 mb-5 pb-1">Amir Made it!</h4>
                </div>

                <form method="POST" action="register.php">
                  <p>Please login to your account</p>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control"
                       required/>
                    <label class="form-label" for="username">Username</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" required/>
                    <label class="form-label" for="password">Password</label>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Sign Up</button>
                    
                  </div>
                  <?php if ($message): ?>
                     <div class="message"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Already have an account?</p>
                    <a href="/login.php"> <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">LogIn</button></a>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">My name is AMIR a PHP/Python Programmer</h4>
                <p class="small mb-0">this is a sample of my activities using PHP stack. as a programmer I love these challenges & an actual geek for new technologies.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


    

</body>
</html>
