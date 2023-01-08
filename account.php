<?php 
session_start();
require 'functions.php';

// Cek status login, jika belum login maka diarahkan ke halaman login
if( !isset($_COOKIE['id']) ) {
    header("Location: login.php");
    exit;
}

// Ambil id dari cookie
if( isset($_COOKIE['id']) ) {
  $cookieId = $_COOKIE['id'];

  // Ambil data kreator dengan id yang sama dengan cookie
  $getKreatorAccount = mysqli_query($connect, "SELECT * FROM kreator WHERE id_kreator = '$cookieId'");
  $kreatorAccount = mysqli_fetch_assoc($getKreatorAccount);
}

// Cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
    // cek apakah data berhasil diubah atau tidak
    if ( updateKreator($_POST) > 0 ) {
            echo "
            <script>
                alert('Data berhasil diubah!');
                document.location.href = 'account.php';
            </script>
            ";
    } else {
        echo "
        <script>
            alert('Data gagal diubah!');;
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Akun <?= $kreatorAccount["nama_kreator"]; ?> | Vsual.</title>
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
    <div id="profile-setting" class="w-full py-3 md:py-6">
        <div class="container max-w-5xl">
            <h1 class="text-xl font-bold pb-3">Pengaturan</h1>
            <div class="flex flex-col md:flex-row gap-4 md:gap-16">
                <div class="flex flex-row md:flex-col text-xs md:text-sm">
                    <a href="account.php" class="font-bold text-primary bg-primary/10 p-4 rounded-xl">Profile</a>
                    <a href="experience.php" class="hover:bg-primary/10 p-4 rounded-xl">Pengalaman</a>
                    <a href="certificate.php" class="hover:bg-primary/10 p-4 rounded-xl">Sertifikat</a>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $kreatorAccount["id_kreator"]; ?>">
                    <input type="hidden" name="username" value="<?= $kreatorAccount["username"]; ?>">
                    <input type="hidden" name="gambarLama" value="<?= $kreatorAccount["foto_profil"]; ?>">
                    <ul class="flex flex-col gap-8">
                        <li class="flex items-center justify-center gap-8 max-w-lg">
                            <img src="./dist/img/profile/<?= $kreatorAccount["foto_profil"]; ?>" class="w-14 md:w-20 aspect-square rounded-full"/>
                            <div>
                              <input type="file" name="gambar" id="gambar">
                              <ul class="text-abu text-xs md:text-sm py-1">
                                <li>100x100 atau 1:1 (disarankan)</li>
                                <li>Maksimal 2MB</li>
                                <li>Format .jpg .jpeg .png</li>
                              </ul>
                            </div>
                        </li>
                        <li class="flex flex-col gap-2 max-w-lg">
                            <label for="uname">Username</label>
                            <input type="text" name="uname" id="uname" value="<?= $kreatorAccount["username"]; ?>" disabled class="text-abu ring-1 ring-abu focus:ring-primary focus:outline-none rounded-lg px-4 py-2">
                        </li>
                        <li class="flex flex-col gap-2 max-w-lg">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" value="<?= $kreatorAccount["nama_kreator"]; ?>" maxlength="50" required class="ring-1 ring-abu focus:ring-primary focus:outline-none rounded-lg px-4 py-2">
                        </li>
                        <li class="flex flex-col gap-2 max-w-lg">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?= $kreatorAccount["email"]; ?>" maxlength="100" required class="ring-1 ring-abu focus:ring-primary focus:outline-none rounded-lg px-4 py-2">
                        </li>
                        <li class="flex flex-col gap-2 max-w-lg">
                            <label for="bio">Bio</label>
                            <textarea name="bio" id="bio" cols="10" rows="5" maxlength="255" class="ring-1 ring-abu focus:ring-primary focus:outline-none rounded-lg px-4 py-2"><?= $kreatorAccount["bio"]; ?></textarea>
                        </li>
                        <li class="self-end">
                            <button type="submit" name="submit" class="text-xs md:text-sm bg-primary text-putih px-4 py-2 rounded-md shadow-lg">Simpan Profile</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <!-- Profile -->

    <script src="app.js"></script>
  </body>
</html>
