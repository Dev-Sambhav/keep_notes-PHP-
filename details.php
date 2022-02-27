<?php

// include database
include('config/db.php');
// check GET request or not for ID params
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection,$_GET['id']);

    // create sql
    $sql = "SELECT * FROM notes WHERE id = $id";

    // make a query
    $data = mysqli_query($connection,$sql);

    // fetch all the data and store as a array
    $note = mysqli_fetch_assoc($data);

    // free the data from memory
    mysqli_free_result($data);

    // close the connection
    mysqli_close($connection);
}

// Delete Data
if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($connection,$_POST['id_to_delete']);

    // create sql
    $sql = "DELETE FROM notes WHERE id = $id_to_delete";

    if(mysqli_query($connection,$sql)){
        // Success
        header("Location: index.php");
    }else{
        // Error
        echo 'Query Error:' . mysqli_error($connection);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<div class="container details-container mt-5 mb-5">
    <div class="detail-box card-body text-center">
        <?php if($note): ?>
            <h3 class="card-title note-title text-capitalize"><?php echo htmlspecialchars($note['title']) ?></h3>
            <div class="card-des">
                <h4 class="card-title">Description: </h4>
                <p class="card-text"><?php echo htmlspecialchars($note['description']) ?></p>
            </div>
            <div class="created-by">
                <span class="card-subtitle mb-2 text-muted">Created by: <?php echo htmlspecialchars($note['name']) ?></span>
            </div>
            <!-- DELETE Data -->
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="btn-delete">
                <input type="hidden" name="id_to_delete" value="<?php echo $note['id'] ?>">
                <input type="submit" name="delete" value="DELETE" class="btn btn-outline-danger mt-3">
            </form>
        <?php else: ?>
            <p>No such Note Exists.</p>
        <?php endif; ?>
    </div>
</div>
<?php include('templates/footer.php') ?>
</html>