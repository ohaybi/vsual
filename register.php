<?php 
require 'functions.php';

if( isset($_POST["register"]) ) {
    if( registrasi($_POST) > 0 ) {
        echo "
        <script>
            alert('Berhasil mendaftar. Silakan Log In.')
            document.location.href = 'login.php';
        </script>
        ";
    } else {
        echo mysqli_error($connect);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Vsual.</title>
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
          <h1 class="text-2xl font-bold pb-2 text-center">Registrasi</h1>
          <h6 class="text-center text-sm md:text-lg">Bergabung dan tunjukan karyamu.</h6>
        </div>
        <form action="" method="post" class="w-full flex flex-col gap-y-4 pb-4">
          <!-- Nama -->
          <input type="text" name="name" id="name" placeholder="Nama Lengkap" maxlength="50" required class="daftar_input-form">
          
          <!-- Email -->
          <input type="email" name="email" id="email" placeholder="Email" maxlength="100" required class="daftar_input-form">

          <!-- Username -->
          <input type="text" name="username" id="username" placeholder="Username" maxlength="50" pattern="\w{3,50}" required class="daftar_input-form group">
          <label for="username" class="group-focus:block">
            <ul class="text-abu">
                <li>Huruf & angka saja</li>
                <li>3 - 50 karakter</li>
            </ul>
          </label>

          <!-- Password -->
          <input type="password" name="password" id="password" placeholder="Password" maxlength="50" pattern="\w{5,50}" required class="daftar_input-form">
          <label for="username">
            <ul class="text-abu">
                <li>Huruf dan angka saja</li>
                <li>5 - 50 karakter</li>
            </ul>
          </label>

          <!-- Submit button -->
          <button type="submit" name="register" class="px-8 py-4 bg-primary text-putih rounded-lg font-medium">Daftar</button>
        </form>
        <h1 class="text-center">Sudah punya akun? <a href="login.php" class="text-primary">Masuk</a></h1>
    </div>
    <!-- Form -->
</body>
</html>