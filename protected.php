<?php
require 'db.php';
require 'secure_session.php';
require_login();

$collection = $database->items;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $collection->insertOne(['name' => $name]);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $collection->updateOne(['_id' => new MongoDB\BSON\ObjectID($id)], ['$set' => ['name' => $name]]);
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
</head>
<body>
    <h1>Welcome to the Data View Page using MongoDB!</h1>
    <a href="logout.php">Logout</a>
    
    <h2>Create Item</h2>
    <form method="POST" action="protected.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit" name="create">Create</button>
    </form>

    <h2>Items</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars((string) $item['_id']); ?></td>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td>
                    <form method="POST" action="protected.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $item['_id']); ?>">
                        <input type="text" name="name" value="<?php echo htmlspecialchars($item['name']); ?>">
                        <button type="submit" name="update">Update</button>
                    </form>
                    <form method="POST" action="protected.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $item['_id']); ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
