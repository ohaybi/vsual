<?php 
session_start();
require 'functions.php';

// Ambil username dari $_GET
$username = $_GET["username"];

// Cek apakah ada username
if( !isset($username) || $username === "" ) {
  header("Location: index.php");
  exit;
}

// Ambil data kreator dengan username
$getKreator = mysqli_query($connect, "SELECT * FROM kreator WHERE username = '$username'");
$kreator = mysqli_fetch_assoc($getKreator);

// Ambil karya, pengalaman, dan sertifikat berdasarkan id kreator
$idKreator = $kreator["id_kreator"];
$karya = query("SELECT * FROM karya WHERE id_kreator = $idKreator");
$pengalaman = query("SELECT * FROM pengalaman WHERE id_kreator = $idKreator ORDER BY id_pengalaman DESC");
$sertifikat = query("SELECT * FROM sertifikat WHERE id_kreator = $idKreator");


// Ambil data dari cookie
if( isset($_COOKIE['id']) ) {
  $cookieId = $_COOKIE['id'];
  $cookieKey = $_COOKIE['key'];

  // Ambil data dengan id yang sama dengan cookie
  $getKreatorAccount = mysqli_query($connect, "SELECT * FROM kreator WHERE id_kreator = '$cookieId'");
  $kreatorAccount = mysqli_fetch_assoc($getKreatorAccount);

  // Cocokan username profil dengan username login
  $hashedUsername = hash('sha256', $kreator['username']);
  if( $cookieKey === $hashedUsername) {
    $owner = true;
  } else {
    $owner = false;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $kreatorAccount["nama_kreator"]; ?> di Vsual.</title>
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
  <body class="bg-putih text-hitam">
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

    <!-- Profile -->
    <div id="profile-section" class="w-full py-2 md:py-5">
      <div class="container max-w-5xl">
        <div class="w-full flex flex-col gap-y-1 justify-center items-center">
          <img src="./dist/img/profile/<?= $kreator["foto_profil"]; ?>" class="w-[60px] md:w-[120px] rounded-full aspect-square" />
          <h1 class="text-xl md:text-3xl font-bold"><?= $kreator["nama_kreator"]; ?></h1>
          <div class="justify-center items-center gap-x-4 text-abu text-xs md:text-base hidden">
            <h5>UI/UX Design</h5>
            <h5>|</h5>
            <h5>Indonesia</h5>
          </div>
        </div>
      </div>
    </div>
    <!-- Profile -->

    <!-- Tentang -->
    <div id="about-section" class="w-full pb-5 md:pb-10">
      <div class="container max-w-5xl">
        <h1 class="text-base md:text-lg font-bold pb-2 pt-5 md:pt-10 border-t border-abu">Biografi</h1>
        <h6><?= $kreator["bio"]; ?></h6>
      </div>
    </div>
    <!-- Tentang -->

    <!-- App Stack -->
    <div id="app-stack" class="w-full pb-5 md:pb-10 hidden">
      <div class="container max-w-5xl">
        <h1 class="text-base md:text-lg font-bold pb-2">App Stack</h1>
        <div class="flex flex-wrap justify-start items-center gap-4">
          <span class="px-4 py-2 md:px-6 md:py-3 rounded-md bg-putih-gelap border border-abu text-xs md:text-sm">Figma</span>
          <span class="px-4 py-2 md:px-6 md:py-3 rounded-md bg-putih-gelap border border-abu text-xs md:text-sm">Adobe Illustrator</span>
          <span class="px-4 py-2 md:px-6 md:py-3 rounded-md bg-putih-gelap border border-abu text-xs md:text-sm">Adobe Photoshop</span>
          <span class="px-4 py-2 md:px-6 md:py-3 rounded-md bg-putih-gelap border border-abu text-xs md:text-sm">After Effect</span>
        </div>
      </div>
    </div>
    <!-- App Stack -->

    <!-- Pengalaman -->
    <?php if( count($pengalaman) > 0 ) : ?>
    <div id="app-stack" class="w-full pb-5 md:pb-10">
      <div class="container max-w-5xl">
        <h1 class="text-base md:text-lg font-bold pb-2">Pengalaman</h1>
        <div class="flex flex-wrap flex-col justify-start items-center gap-4">
          <?php foreach( $pengalaman as $dataPengalaman) : ?>
          <div class="pengalaman-card w-full flex flex-row justify-start items-center gap-8 py-4 border-b border-abu">
            <h1 class="text-xl pl-8 text-abu">•</h1>

            <div>
              <h3 class="font-bold text-sm md:text-base"><?= $dataPengalaman["posisi_jabatan"]; ?></h3>
              <h6 class="text-sm md:text-base text-abu"><?= $dataPengalaman["nama_institusi"]; ?></h6>
              <h6 class="text-sm md:text-base text-abu"><?= $dataPengalaman["tahun_mulai"]; ?> - <?= $dataPengalaman["tahun_selesai"]; ?></h6>
            </div>

            <?php if( isset($owner) && $owner === true ) : ?>
            <!-- Delete -->
            <a href="delete.php?tabel=pengalaman&id=<?= $dataPengalaman["id_pengalaman"]; ?>" onclick="return confirm('Yakin ingin menghapus data?')">
              <svg class="w-4 md:w-5 fill-hitam/20 hover:fill-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg>
            </a>
            <!-- Delete -->
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <!-- Pengalaman -->

    <!-- Sertifikat -->
    <?php if( count($sertifikat) > 0 ) : ?>
    <div id="app-stack" class="w-full pb-5 md:pb-10">
      <div class="container max-w-5xl">
        <h1 class="text-base md:text-lg font-bold pb-2">Sertifikat</h1>
        <div class="flex flex-wrap flex-col justify-start items-center gap-4 ">
          <?php $i = 1 ?>

          <?php foreach( $sertifikat as $dataSertifikat) : ?>
          <div class="sertifikat-card w-full flex flex-row justify-start items-center gap-8 py-4 border-b border-abu">
            <h1 class="text-xl pl-8 text-abu"><?= $i; $i++?></h1>

            <div>
              <h3 class="font-bold text-sm md:text-base"><?= $dataSertifikat["judul_sertifikat"]; ?></h3>
              <h6 class="text-sm md:text-base text-abu"><?= $dataSertifikat["nama_institusi"]; ?></h6>
              <h6 class="text-sm md:text-base text-abu"><?= $dataSertifikat["tahun_terbit"]; ?></h6>
            </div>

            <?php if( isset($owner) && $owner === true ) : ?>
            <!-- Delete -->
            <a href="delete.php?tabel=sertifikat&id=<?= $dataSertifikat["id_sertifikat"]; ?>" onclick="return confirm('Yakin ingin menghapus sertifikat?')">
              <svg class="w-4 md:w-5 fill-hitam/20 hover:fill-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg>
            </a>
            <!-- Delete -->
            <?php endif; ?>
          </div>
          <?php endforeach; ?>

        </div>
      </div>
    </div>
    <?php endif; ?>
    <!-- Sertifikat -->

    <!-- Karya -->
    <div id="karya-section" class="w-full pb-5 md:pb-10">
      <div class="container max-w-5xl">
        <h1 class="text-base md:text-lg font-bold py-4">Karya <?= $kreator["nama_kreator"]; ?></h1>
        <div class="w-full grid gap-x-8 gap-y-8 grid-cols-1 md:grid-cols-3 auto-rows-auto">
          <?php if( count($karya) > 0 ) : ?>

          <?php foreach( $karya as $dataKarya) : ?>
          <div class="karya-card flex flex-col justify-start items-start">
              <a href="karya.php?id=<?= $dataKarya["id_karya"]; ?>" class="group w-full rounded-md overflow-hidden aspect-video relative">
                <img class="w-full h-auto" src="./dist/img/karya/<?= $dataKarya["gambar"]; ?>" alt="<?= $dataKarya["judul_karya"]; ?>">
                <span class="absolute w-full h-auto bottom-0 left-0 p-4 font-bold bg-gradient-to-t from-black/70 to-transparent text-putih duration-300 ease-in-out opacity-70 md:opacity-0 group-hover:opacity-100"><?= $dataKarya["judul_karya"]; ?></span>
              </a>

              <?php if( isset($owner) && $owner === true ) : ?>
              <!-- Delete -->
              <div class="flex justify-center items-center w-full gap-x-4 py-2 md:py-4">
                <a href="delete.php?tabel=karya&id=<?= $dataKarya["id_karya"]; ?>" onclick="return confirm('Yakin ingin menghapus karya?')">
                  <svg class="w-4 md:w-5 fill-hitam/20 hover:fill-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg>
                </a>
              </div>
              <!-- Delete -->
              <?php endif; ?>

            </div>
          <?php endforeach; ?>

          <?php else : ?>
            <h1>Kreator belum mengunggah karya.</h1>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-- Karya -->

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
