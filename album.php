<?php include("includes/header.php"); 
if(isset($_GET['id'])) {
    echo $_GET['id'];
} else {
    "I don't set.";
}
?>

<?php include("includes/footer.php"); ?>