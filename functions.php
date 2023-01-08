<?php 
// koneksi ke database
$dbHostName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "vsual_web"; 
$connect = mysqli_connect($dbHostName, $dbUsername, $dbPassword, $dbName);

$linkLaporBug = "https://forms.gle/AkozspsCPW5KGzhQA";

// Read
function query($query) {
    global $connect;
    $result = mysqli_query($connect, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

// getKaryaById
function getKaryaById($id) {
    global $connect;

    $result = mysqli_query($connect, "SELECT * FROM karya WHERE id_kreator = '$id'");
    $karya = mysqli_fetch_assoc($result);
    return $karya;
}

// Registrasi
function registrasi($data) {
    global $connect;

    $name = $data["name"];
    $email = strtolower($data["email"]);
    $username = strtolower(stripslashes($data["username"]));
    // $password = mysqli_real_escape_string($connect, $data["password"]);
    $password = $data["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Cek username sudah ada atau belum
    $result = mysqli_query($connect, "SELECT username FROM kreator WHERE username = '$username'");
    if ( mysqli_fetch_assoc($result) ) {
        echo "
        <script>
            alert('Username sudah terdaftar!');
        </script>
        ";
        return false;
    }

    // Enkripsi password

    // Tambahkan user baru ke database
    $defaultPhoto = 'default.jpg';
    mysqli_query($connect, "INSERT INTO kreator VALUES(
        '', '$name', '$email', '$username', '$hashedPassword', '$defaultPhoto', '-'
        )"
    );

    return mysqli_affected_rows($connect);
}

function upload($tipe, $gambarLama, $maxSize) {
    
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if( $error === 4 ) {
        echo "
        <script>
            alert('Pilih gambar terlebih dahulu!');
        </script>
        ";
        return false;
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'webp'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if ( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "
        <script>
            alert('Format file tidak sesuai!');
        </script>
        ";
        return $gambarLama;
    }

    // Cek jika ukurannya terlalu besar
    if ( $ukuranFile > $maxSize ) {
        echo "
        <script>
            alert('Ukuran gambar terlalu besar!');
        </script>
        ";

        return $gambarLama;
    }

    // Lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    $folderTujuan = "./dist/img/$tipe/";

    move_uploaded_file($tmpName, $folderTujuan . $namaFileBaru);

    return $namaFileBaru;
}

// Ubah profile kreator
function updateKreator($data) {
    global $connect;

    $tipe = "profile";
    $maxSize = 2000000;

    $id = $data["id"];
    $username = htmlspecialchars($data["username"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $bio = htmlspecialchars($data["bio"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    
    
    // cek apakah user pilih gambar baru atau tidak
    if( $_FILES['gambar']['error'] === 4 ) {
        $gambarBaru = $gambarLama;
    } else {
        $gambarBaru = upload($tipe, $gambarLama, $maxSize);
    }

    // query update data
    $query = "UPDATE kreator SET
                nama_kreator = '$nama',
                email = '$email',
                username = '$username',
                foto_profil = '$gambarBaru',
                bio = '$bio'
                WHERE id_kreator = $id
            ";
    mysqli_query($connect, $query);

    return mysqli_affected_rows($connect);    
}

// Upload Karya
function uploadKarya($data) {
    global $connect;

    $tipe = "karya";
    $maxSize = 5000000;

    $id = $data["id"];
    $judul = htmlspecialchars($data["judul"]);
    $waktu = htmlspecialchars($data["waktu"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $gambarLama = "karya_default.jpg";
    
    // cek apakah user pilih gambar baru atau tidak
    if( $_FILES['gambar']['error'] === 4 ) {
        $gambarBaru = $gambarLama;
    } else {
        $gambarBaru = upload($tipe, $gambarLama, $maxSize);
    }

    // Tambahkan karya baru ke database
    mysqli_query($connect, "INSERT INTO karya VALUES(
        '', '$id', '$judul', '$waktu', '$gambarBaru', '$deskripsi'
        )"
    );

    return mysqli_affected_rows($connect);    
}

// Tambah pengalaman
function addExperience($data) {
    global $connect;

    $id = $data["id"];
    $posisiJabatan = htmlspecialchars($data["posisi_jabatan"]);
    $namaInstitusi = htmlspecialchars($data["nama_institusi"]);
    $tahunMulai = htmlspecialchars($data["tahun_mulai"]);
    $tahunSelesai = htmlspecialchars($data["tahun_selesai"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);

    // Tambahkan user baru ke database
    mysqli_query($connect, "INSERT INTO pengalaman VALUES(
        '', '$id', '$posisiJabatan', '$namaInstitusi', '$tahunMulai', '$tahunSelesai', '$deskripsi'
        )"
    );

    return mysqli_affected_rows($connect);
}

// Tambah sertifikat
function addCertificate($data) {
    global $connect;

    $id = $data["id"];
    $judul = htmlspecialchars($data["judul"]);
    $namaInstitusi = htmlspecialchars($data["nama_institusi"]);
    $tahun = htmlspecialchars($data["tahun"]);

    // Tambahkan user baru ke database
    mysqli_query($connect, "INSERT INTO sertifikat VALUES(
        '', '$id', '$judul', '$namaInstitusi', '$tahun'
        )"
    );

    return mysqli_affected_rows($connect);
}

function delete($tabel, $id) {
    global $connect;
    mysqli_query($connect, "DELETE FROM $tabel WHERE id_$tabel = $id");

    return mysqli_affected_rows($connect);
}

?>