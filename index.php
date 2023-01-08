<?php 
session_start();
require 'functions.php';

$karya = query("SELECT * FROM karya");
$statistik = query("SELECT * FROM statistik");

// Ambil id dari cookie
if( isset($_COOKIE['id']) ) {
  $cookieId = $_COOKIE['id'];

  // Ambil data dengan id yang sama dengan cookie
  $getKreatorAccount = mysqli_query($connect, "SELECT * FROM kreator WHERE id_kreator = '$cookieId'");
  $kreatorAccount = mysqli_fetch_assoc($getKreatorAccount);
}

// Ambil karya secara random
$randomInt = rand(0, count($karya) - 1);
$randomKarya = $karya[$randomInt]["gambar"];
$randomKaryaId = $karya[$randomInt]["id_kreator"];
$kreatorRandomKarya = query("SELECT nama_kreator FROM kreator WHERE id_kreator = $randomKaryaId");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vsual. - Karya Kreator Indonesia 🇮🇩</title>
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
              <h3 class="flex items-center gap-2 text-xs md:text-sm font-bold">Vsual.</h3>
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

    <!-- Hero -->
    <div id="hero-section" class="w-full">
      <div class="container max-w-5xl">
        <img src="" alt="">
        <div class="w-full px-4 py-16 md:py-40 flex flex-col justify-center items-center rounded-xl relative bg-cover bg-center overflow-hidden" style="background-image:url('<?= "./dist/img/karya/".$randomKarya ?>');">
          <h1 class="text-putih font-bold text-xl md:text-3xl mb-4 text-center z-20">Dari Kreator Untuk Indonesia 🇮🇩</h1>
          <h3 class="text-putih text-center text-xs md:text-base z-20">Koleksi karya visual dari orang-orang kreatif Indonesia. Tunjukan karyamu dan saling menginspirasi.</h3>
          <span class="absolute z-20 right-2 bottom-2 md:right-4 md:bottom-4 text-[0.7rem] md:text-sm text-putih/30">Karya <?= $kreatorRandomKarya[0]["nama_kreator"]; ?></span>
          <div class="w-full h-full bg-hitam/50 absolute z-10"></div>
        </div>
      </div>
    </div>
    <!-- Hero -->

    <!-- Statistik -->
    <div id="statistik-section" class="w-full pt-6">
      <div class="container">
        <div class="flex justify-center gap-16 items-center">
          <div class="statistik-kreator text-center">
            <h1 class="font-bold text-xl md:text-2xl"><?= $statistik[0]["jumlah"]; ?>+</h1>
            <span>Kreator</span>
          </div>
          <div class="statistik-karya text-center">
          <h1 class="font-bold text-xl md:text-2xl"><?= $statistik[1]["jumlah"]; ?>+</h1>
            <span>Karya</span>
          </div>
        </div>
      </div>
    </div>
    <!-- Statistik -->

    <!-- Karya -->
    <div id="karya-section" class="w-full py-3 md:py-6">
      <div class="container max-w-5xl">
        <div class="w-full">
          <h1 class="text-xl font-bold pb-3">Karya Kreator</h1>
          <div class="w-full grid gap-6 grid-cols-1 md:grid-cols-3 auto-rows-auto">
            <!-- Koleksi Karya -->
            <?php foreach( $karya as $dataKarya) : ?>
              <?php 
                  // Ambil data kreator yang sesuai dengan data karya
                  $getKreator = mysqli_query($connect, "SELECT * FROM kreator WHERE id_kreator = $dataKarya[id_kreator]");
                  $kreator = mysqli_fetch_assoc($getKreator);
              ?>
              
              <div class="karya-card flex flex-col justify-start items-start">
              <a href="karya.php?id=<?= $dataKarya["id_karya"]; ?>" class="group w-full rounded-md overflow-hidden aspect-video relative">
                <img class="w-full h-auto" src="./dist/img/karya/<?= $dataKarya["gambar"]; ?>" alt="<?= $dataKarya["judul_karya"]; ?>">
                <span class="absolute w-full h-auto bottom-0 left-0 p-4 font-bold bg-gradient-to-t from-black/70 to-transparent text-putih duration-300 ease-in-out opacity-70 md:opacity-0 group-hover:opacity-100"><?= $dataKarya["judul_karya"]; ?></span>
              </a>
              <div class="flex flex-row justify-start items-center gap-x-4 py-4">
                <img src="./dist/img/profile/<?= $kreator["foto_profil"]; ?>" class="rounded-full w-6 md:w-8 aspect-square" />
                <a href="profile.php?username=<?= $kreator["username"]; ?>" class="text-xs md:text-base font-semibold"><?= $kreator["nama_kreator"]; ?></a>
              </div>
            </div>
            <?php endforeach; ?>
            <!-- Koleksi Karya -->
          </div>
        </div>
      </div>
    </div>
    <!-- Karya -->

    <!-- Upload Button -->
    <?php if( isset($_SESSION["login"]) ) : ?>
      <div class="flex justify-center items-center fixed bottom-4 right-4 md:right-8">
          <a href="upload.php" class="flex items-center text-sm md:text-base bg-primary text-putih p-2 md:p-4 rounded-xl shadow-lg shadow-primary/50">
            <svg class="w-6 fill-putih" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
            <span>Upload</span>
          </a>
      </div>
    <?php endif; ?>
    <!-- Upload Button -->

    <!-- Footer -->
    <div id="footer-section" class="w-full py-3 md:py-6 bg-hitam text-putih">
      <div class="container max-w-5xl flex flex-col md:flex-row justify-start items-start md:items-center gap-4 md:gap-8">
        <a href="about-us.php" class="hover:text-primary text-sm md:text-base font-medium duration-500 ease-in-out">Tentang Vsual.</a>
        <a href="<?= $linkLaporBug; ?>" target="_blank" class="hover:text-red-500 text-sm md:text-base font-medium duration-500 ease-in-out">Laporkan Bug</a>
      </div>
    </div>
    <!-- Footer -->

    <script src="app.js"></script>
  </body>
</html>
