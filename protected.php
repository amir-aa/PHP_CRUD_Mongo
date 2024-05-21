<?php
require 'db.php';
require 'secure_session.php';
require_login();

$collection = $database->items;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $message= $_POST['message'];
        $title = $_POST['title'];
        $collection->insertOne(['username'=> $_SESSION['username'],'title' => $title,'message'=>$message,'created_at' => new MongoDB\BSON\UTCDateTime()]);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        //$title = $_POST['title'];
        $message= $_POST['message'];
        $collection->updateOne(['_id' => new MongoDB\BSON\ObjectID($id)], ['$set' => ['message'=>$message]]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($id)]);
    }
}

$items = $collection->find();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DataView</title>
    <link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />
    <link rel="stylesheet" href="css/vendor/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="css/vendor/datatables.responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="css/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/vendor/component-custom-switch.min.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>
<body id="app-container" class="menu-default">
    <nav class="navbar fixed-top">
        <div class="d-flex align-items-center navbar-left">
            <h1>Mongo CRUD</h1>
            <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block" href="logout.php">Logout</a>
            
            
        </div>
        <nav class="navbar-right">

            <h3>Create message</h3>
                <form method="POST" action="protected.php">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                    <label for="message">Message:</label>
                    <input type="text" id="message" name="message" required>
                    <button type="submit" name="create" class="btn btn-success mb-1">Create</button>
                </form>
        </nav>
    </nav>

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Datatable</h1>
       
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <table class="data-table data-table-feature">
                                <thead>
                                    <tr>
                                        <th>Oid</th>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>Message</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars((string) $item['_id']); ?></td>
                                            <td><?php echo htmlspecialchars((string) $item['title']); ?></td>
                                            <td><?php echo htmlspecialchars((string) $item['username']); ?></td>
                                            <td><?php echo htmlspecialchars((string) $item['message']); ?></td>
                                            <td>    
                                                <form method="POST" action="protected.php" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $item['_id']); ?>">
                                                    <input type="text" name="message" value="<?php echo htmlspecialchars($item['message']); ?>">
                                                <button type="submit" class="btn btn-info mb-1" name="update">Update</button>
                                                </form>
                                                    <form method="POST" action="protected.php" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $item['_id']); ?>">
                                                    <button type="submit" class="btn btn-danger mb-1" name="delete">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>





</body>
    <script src="js/vendor/jquery-3.3.1.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/vendor/perfect-scrollbar.min.js"></script>
    <script src="js/vendor/datatables.min.js"></script>
    <script src="js/dore.script.js"></script>
    <script src="js/scripts.js"></script>
</html>
