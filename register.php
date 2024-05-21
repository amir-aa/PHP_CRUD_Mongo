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
        } else {
            echo "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
                    <input type="email" id="username" name="username" class="form-control"
                       required/>
                    <label class="form-label" for="username">Username</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" required/>
                    <label class="form-label" for="password">Password</label>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log
                      in</button>
                    
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <a href="/register.php"> <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Create new</button></a>
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
