<?php
// connect with database
$connection = mysqli_connect('localhost', 'sam', 'qazwsx12', 'keepnotes');

// check connection
if (!$connection) {
    print 'Connection Error: ' . mysqli_connect_error();
}
?>

