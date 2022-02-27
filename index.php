<?php

// include db
include("config/db.php");

// write query for all notes
$sql = 'SELECT title, id, description FROM notes ORDER BY created_at';

// make query to get all notes
$data = mysqli_query($connection, $sql);

// fetch all the data as an array from query
$notes = mysqli_fetch_all($data, MYSQLI_ASSOC);

// free the data from memory
mysqli_free_result($data);

// close the connection
mysqli_close($connection);

// get only few words from given string.
function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);  // this will return a array where the key is the position of the word in the string, and value is the actual word.
        $key   = array_keys($words);  // this will return a array containing keys.
        $text  = substr($text, 0, $key[$limit]) . '...';
    }
    return $text;
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>

<div class="container home-container p-4 text-center mt-4">
    <h2 class="text-center mb-5 main-title">Notes</h2>
    <div class="row">
        <?php foreach ($notes as $note) : ?>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize"><?php echo htmlspecialchars($note['title']) ?></h5>
                        <p class="card-text">
                            <?php echo htmlspecialchars(limit_text($note['description'],5)) ?>
                        </p>
                        <hr>
                        <div class="text-right">
                            <a href="details.php?id=<?php echo $note['id'] ?>" class="btn btn-outline-secondary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php include('templates/footer.php') ?>

</html>