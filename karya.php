<?php 
session_start();
require 'functions.php';

$idKarya = $_GET["id"];
$karya = query("SELECT * FROM karya WHERE id_karya = $idKarya");

// Cek apakah ada id
if( !isset($idKarya) || $idKarya === "" ) {
    header("Location: index.php");
    exit;
}

$idKreator = $karya[0]["id_kreator"];
$kreatorKarya = query("SELECT * FROM kreator WHERE id_kreator = $idKreator");

// Ambil id dari cookie
if( isset($_COOKIE['id']) ) {
  $cookieId = $_COOKIE['id'];

  // Ambil data dengan id yang sama dengan cookie
  $getKreatorAccount = mysqli_query($connect, "SELECT * FROM kreator WHERE id_kreator = '$cookieId'");
  $kreatorAccount = mysqli_fetch_assoc($getKreatorAccount);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $karya[0]["judul_karya"]; ?> karya <?= $kreatorKarya[0]["nama_kreator"]; ?> | Vsual.</title>
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
  <body class="bg-putih text-hitam font-plus-jakarta">
    <!-- Navbar -->
    <div id="navigation-bar" class="w-full bg-putih/80 backdrop-blur-lg sticky top-0 z-[999] py-2 md:py-4">
      <div class="container max-w-5xl">
        <div class="flex flex-row justify-between items-center relative">
          <div>
            <a href="index.php">
              <h3 class="text-xs md:text-sm font-bold">Vsual.</h3>
            </a>
          </div>
          <div>
            <?php if( !isset($_SESSION["login"]) ) : ?>
              <div>
                <a href="register.php" class="text-xs md:text-sm mr-4">Daftar</a>
                <a href="login.php" class="text-xs md:text-sm bg-primary text-putih px-4 py-2 rounded-md shadow-lg shadow-primary/50">Masuk</a>
              </div>
            <?php else : ?>
              <button id="btn-account" class="flex flex-row rounded-full">
                <img src="./dist/img/profile/<?= $kreatorAccount["foto_profil"]; ?>" class="rounded-full w-8 aspect-square" />
              </button>

              <nav id="account-menu" class="hidden mt-2 md:mt-4 absolute bg-putih shadow-lg rounded-lg max-w-[130px] w-full right-0 top-full">
              <ul class="block">
                <!-- Profile -->
                <li class="group py-1 px-4 md:py-2 md:px-6 border-b border-hitam/10">
                  <a href="profile.php?username=<?= $kreatorAccount["username"]; ?>" class="flex items-center gap-x-2 text-xs md:text-sm group-hover:text-primary">
                    <span>Profile</span>
                  </a>
                </li>

                <!-- Edit -->
                <li class="group py-1 px-4 md:py-2 md:px-6 border-b border-hitam/10">
                  <a href="account.php" class="flex items-center gap-x-2 text-xs md:text-sm group-hover:text-primary">
                    <span>Edit Profile</span>
                  </a>
                </li>

                <!-- Keluar -->
                <li class="group py-1 px-4 md:py-2 md:px-6 border-b border-hitam/10">
                  <a href="logout.php" class="flex items-center gap-x-2 text-xs md:text-sm group-hover:text-pink-500">
                    <svg class="w-4 md:w-5 fill-pink-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 18h2v2h12V4H6v2H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3zm2-7h7v2H6v3l-5-4 5-4v3z"/></svg>
                    <span>Keluar</span>
                  </a>
                </li>
              </ul>
            </nav>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- Navbar -->

    <!-- Karya -->
    <div id="detail-karya" class="w-full py-5 md:py-10">
        <div class="container max-w-5xl">
            <div class="flex justify-start items-center gap-4">
                <img src="./dist/img/profile/<?= $kreatorKarya[0]["foto_profil"]; ?>" class="w-8 md:w-12 rounded-full aspect-square">
                <div class="flex flex-col">
                    <h3 class="font-bold text-sm md:text-lg"><?= $karya[0]["judul_karya"]; ?></h3>
                    <a href="profile.php?username=<?= $kreatorKarya[0]["username"]; ?>" class="text-xs md:text-sm"><?= $kreatorKarya[0]["nama_kreator"]; ?></a>
                </div>

            </div>

            <div class="py-4">
                <img src="./dist/img/karya/<?= $karya[0]["gambar"]; ?>" class="rounded-xl">
            </div>

            <div>
                <span class="text-sm md:text-base">
                <?= $karya[0]["deskripsi"]; ?>
                </span>
            </div>
        </div>
    </div>
    <!-- Karya -->
    <script src="app.js"></script>
  </body>
</html>
