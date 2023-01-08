<?php 
session_start();
require 'functions.php';

if ( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

$tabel = $_GET["tabel"];
$id = $_GET["id"];

if( delete($tabel, $id) > 0 ) {
    echo "
        <script>
            alert('$tabel berhasil dihapus!');
            document.location.href = 'index.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Gagal menghapus $tabel!');
            document.location.href = 'index.php';
        </script>
    ";
}
?>