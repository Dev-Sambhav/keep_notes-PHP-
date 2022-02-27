<?php

//include db
include('config/db.php');

$name = $title = $description = '';
$errors = array('title' => "", 'name' => "", 'description' => "");

if (isset($_POST['submit'])) {

    // check name
    if (empty($_POST['name'])) {
        $errors['name'] = "Please Enter Your Name";
    } else {
        $name = htmlspecialchars($_POST['name']);
        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $errors['name'] = "Invalid name Format";
        }
    }
    // check title
    if (empty($_POST['title'])) {
        $errors['title'] = "Please Enter Note Title";
    } else {
        $title = htmlspecialchars($_POST['title']);
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            $errors['title'] = "Title must be Letters and Space only";
        }
    }
    // check description
    if (empty($_POST['description'])) {
        $errors['description'] = "Please Write Your Notes";
    }

    // Redirect to the User if there is no errors and saving data into database
    if (!array_filter($errors)) {
        $name = mysqli_real_escape_string($connection,$_POST['name']);
        $title = mysqli_real_escape_string($connection,$_POST['title']);
        $description = mysqli_real_escape_string($connection,$_POST['description']);

        // create sql
        $sql = "INSERT INTO notes(title,name,description) VALUES ('$title','$name','$description')";

        // check and save data into db
        if(mysqli_query($connection,$sql)){
            //success
            header("Location: index.php");
        }else{
            //error
            echo "Could not save your data: " . mysqli_error($connection);
        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<section class="container add-container form-section mt-3 p-3">
    <h2 class="text-center mb-3">
        Add a Note
    </h2>
    <form class="add-form container" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $name ?>" class="form-control" id="name" placeholder="Enter Your Name">
            <small class="form-text text-danger"><?php echo $errors['name'] ?></small>
        </div>
        <div class="form-group">
            <label for="note-title">Note Title:</label>
            <input type="text" name="title" value="<?php echo $title ?>" class="form-control" id="note-title" placeholder="Enter Note Title">
            <small class="form-text text-danger"><?php echo $errors['title'] ?></small>
        </div>
        <div class="form-group mb-4">
            <label for="description">Description:</label>
            <textarea name="description" value="<?php echo $description ?>" class="form-control" id="description" placeholder="Write here..."></textarea>
            <small class="form-text text-danger"><?php echo $errors['description'] ?></small>
        </div>
        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-outline-success">ADD</button>
        </div>
    </form>
</section>
</body>
</html>