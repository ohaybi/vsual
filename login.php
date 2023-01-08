<?php 
session_start();
require 'functions.php';

// Cek cookie
if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  // Ambil username berdasarkan id
  $result = mysqli_query($connect, "SELECT username FROM kreator WHERE id_kreator = $id");
  $row = mysqli_fetch_assoc($result);

  // Cek cookie dan username
  if( $key === hash('sha256', $row['username']) ) {
    
    // Set session login
      $_SESSION['login'] = true;
  }
} 

// Cek session, jika true akan diarahkan ke halaman beranda
if ( isset($_SESSION['login']) ) {
    header("Location: index.php");
    exit;
}

if ( isset($_POST["login"]) ) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($connect, "SELECT * FROM kreator WHERE username = '$username'");
    $row = mysqli_fetch_assoc($result);


    // Cek username
    if( mysqli_num_rows($result) === 1 ) {

        // Cek password
        if (password_verify($password, $row["password"])) {

            // Buat Session
            $_SESSION["login"] = true;

            // Buat cookie
            setcookie('id', $row['id_kreator'], time()+3600);
            setcookie('key', hash('sha256', $row['username']), time()+3600);

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Vsual.</title>
    <link href="dist/output.css" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png" />
    <link rel="manifest" href="icon/site.webmanifest" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DX4RS0KTX2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
      gtag("js", new Date());

      gtag("config", "G-DX4RS0KTX2");
    </script>
</head>
<body>
    <!-- Form -->
    <div id="about-section" class="w-[100vw] h-[100vh] flex justify-center items-center">
      <div class="container max-w-xl">
        <div class="pb-8">
            <h1 class="text-2xl font-bold pb-2 text-center">Log In</h1>
            <h6 class="text-center text-sm md:text-lg">Tunjukan karyamu dan saling menginspirasi.</h6>
        </div>

        <form action="" method="post" class="w-full flex flex-col gap-y-4 pb-4">
          <?php if( isset($error) ) : ?>
            <h6 class="text-center text-sm md:text-lg text-pink-500 font-medium">Username atau Password salah!</h6>  
          <?php endif ?>

          <!-- Username -->
          <input type="text" name="username" id="username" placeholder="Username" required class="ring ring-abu focus:ring-primary focus:outline-none rounded-lg px-8 py-4">

          <!-- Password -->
          <input type="password" name="password" id="password" placeholder="Password" required class="ring ring-abu focus:ring-primary focus:outline-none rounded-lg px-8 py-4">

          <!-- Login -->
          <button type="submit" name="login" class="px-8 py-4 bg-primary text-putih rounded-lg font-medium">Masuk</button>
        </form>
        <h1 class="text-center">Belum punya akun? <a href="register.php" class="text-primary">Daftar</a></h1>
      </div>
    </div>
    <!-- Form -->

    <!-- Footer -->
    <div id="footer-section" class="w-full py-3 md:py-6 bg-hitam text-putih">
      <div class="container max-w-5xl flex flex-col md:flex-row justify-start items-start md:items-center gap-4 md:gap-8">
        <a href="about-us.php" class="hover:text-primary text-sm md:text-base font-medium duration-500 ease-in-out">Tentang Vsual.</a>
        <a href="<?= $linkLaporBug; ?>" target="_blank" class="hover:text-red-500 text-sm md:text-base font-medium duration-500 ease-in-out">Laporkan Bug</a>
      </div>
    </div>
    <!-- Footer -->
</body>
</html>