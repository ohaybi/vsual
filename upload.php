<?php 
session_start();
require 'functions.php';

$karya = query("SELECT * FROM karya");

// Cek status login, jika belum login maka diarahkan ke halaman login
if( !isset($_COOKIE['id']) ) {
    header("Location: login.php");
    exit;
}

// Ambil id dari cookie
if( isset($_COOKIE['id']) ) {
  $cookieId = $_COOKIE['id'];

  // Ambil data dengan id yang sama dengan cookie
  $getKreator = mysqli_query($connect, "SELECT * FROM kreator WHERE id_kreator = '$cookieId'");
  $kreator = mysqli_fetch_assoc($getKreator);
}

// Cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
    // cek apakah data berhasil diubah atau tidak
    if ( uploadKarya($_POST) > 0 ) {
            echo "
            <script>
                alert('Karya berhasil diunggah.');
                document.location.href = 'index.php';
            </script>
            ";
    } else {
        echo "
        <script>
            alert('Gagal mengunggah karya!');;
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
    <title>Upload Karya | Vsual.</title>
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
    <!-- Upload Karya -->
    <div id="upload-karya" class="w-full py-3 md:py-6">
        <div class="container max-w-5xl">
            <div>
                <a href="index.php" class="text-pink-500 flex items-center">
                    <svg class="w-6 fill-pink-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0z"/><path d="M7.828 11H20v2H7.828l5.364 5.364-1.414 1.414L4 12l7.778-7.778 1.414 1.414z"/></svg>
                    <span class="font-medium">Kembali</span>
                </a>
            </div>

            <div class="py-3 md:py-6">
                <h1 class="text-xl font-bold text-center pb-3">Unggah Karya</h1>
                
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $kreator["id_kreator"]; ?>">
                    <ul class="flex flex-col gap-8">
                        <li class="flex flex-col gap-4 w-full">
                            <div id="preview-gambar" class="w-full flex justify-center items-center"></div>
                            <label for="gambar" class="text-sm md:text-base">Gambar Karya</label>
                            <input type="file" name="gambar" id="gambar" required onchange="previewKarya(event)">
                            <ul class="text-abu text-xs md:text-sm">
                                <li>1920x1080 atau 1280x720 (disarankan)</li>
                                <li>Maksimal 5MB</li>
                                <li>Format .jpg .jpeg .png</li>
                            </ul>
                        </li>
                        <li class="flex flex-col gap-2 w-full">
                            <label for="judul" class="text-sm md:text-base">Judul Karya</label>
                            <input type="text" name="judul" id="judul" maxlength="100" placeholder="Judul karya kamu.." required class="upload_input-form">
                        </li>
                        <li class="flex flex-col gap-2 w-full">
                            <label for="waktu" class="text-sm md:text-base">Tahun</label>
                            <input type="text" name="waktu" id="waktu" placeholder="Tahun karya kamu dibuat.." pattern="\d{4,4}" maxlength="4" required class="upload_input-form">
                        </li>
                        <li class="flex flex-col gap-2 w-full">
                            <label for="deskripsi" class="text-sm md:text-base">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsikan karya.." maxlength="255" cols="10" rows="5" required class="upload_input-form"></textarea>
                        </li>
                        <li class="w-full">
                            <button type="submit" name="submit" class="w-full py-4 text-sm md:text-base font-bold bg-primary text-putih rounded-md shadow-lg">Unggah</button>
                        </li>
                        <li class="w-full flex justify-center">
                            <a href="index.php" class="w-full text-sm md:text-base text-center text-red-500">Batal</a>
                        </li>
                    </ul>
                </form>
            </div>

        </div>
    </div>
    <!-- Upload Karya -->
    <script src="app.js"></script>
  </body>
</html>
