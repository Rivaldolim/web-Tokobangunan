<?php
session_start();
include 'database.php';
$conn = connectDB();

if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
  echo '<div class="alert alert-success" role="alert">Registrasi berhasil!</div>';
  unset($_SESSION['registration_success']); // Hapus flag sesi
}
if (isset($_SESSION['login_error'])) {
  echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';
  unset($_SESSION['login_error']);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Pilih tabel yang sesuai berdasarkan peran (role)
    $table_name = ($role == 'admin') ? 'admin_login' : (($role == 'superadmin') ? 'superadmin' : 'user_login');


    // Query untuk memeriksa keberadaan pengguna berdasarkan username dan password di tabel yang sesuai dengan peran
    $sql = "SELECT * FROM $table_name WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Jika login berhasil, tetapkan variabel session dan arahkan pengguna ke halaman yang sesuai
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        
        if ($role == 'admin') {
            header("Location: admin.php");
            exit();
        } 
        elseif ($role == 'user') {
            header("Location: user.php");
            exit();
        }
        elseif ($role == 'superadmin') {
          header("Location: superadmin.php");
          exit();
      }
     else {
        $error_message = "Login failed. Please try again.";
       }

      }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  /* Gaya umum */
  body {
    background-color: #f8f9fa;
  }

  /* Kontainer form */
  .login-container {
    margin-top: 100px;
    display: flex;
    justify-content: center;
  }

  /* Form login */
  .login-form {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px; /* Lebar maksimum form */
  }

  /* Judul form */
  .login-heading {
    text-align: center;
    margin-bottom: 40px;
  }

  /* Link dan tombol */
  .btn-primary,
  .login-form a {
    color: #ffc107; /* Warna teks kuning */
  }

  /* Tombol */
  .btn-primary {
    background-color: #343a40; /* Warna latar belakang abu-abu tua */
    border-color: #343a40; /* Warna garis tepi abu-abu tua */
    border-radius: 20px; /* Bentuk tombol bulat */
    padding: 12px 20px; /* Padding di dalam tombol */
    width: 100%; /* Tombol mengisi lebar form */
  }

  /* Tombol saat dihover */
  .btn-primary:hover {
    background-color: #ffc107; /* Warna latar belakang kuning saat dihover */
    border-color: #ffc107; /* Warna garis tepi kuning saat dihover */
  }

  /* Link saat dihover */
  .login-form a:hover {
    color: #ffc107; /* Warna teks kuning saat dihover */
  }

  /* Teks tambahan */
  .mt-3,
  .text-center {
    margin-top: 20px;
  }

  /* Tombol back to home */
  .back-to-home-btn {
    background-color: #ffc107; /* Warna latar belakang kuning */
    color: #343a40; /* Warna teks abu-abu tua */
    border: none; /* Tidak ada garis tepi */
    border-radius: 20px; /* Bentuk tombol bulat */
    padding: 10px 20px; /* Padding di dalam tombol */
    transition: all 0.3s ease; /* Transisi saat dihover */
    width: 100%; /* Tombol mengisi lebar form */
  }

  /* Tombol saat dihover */
  .back-to-home-btn:hover {
    background-color: #ffdc52; /* Warna latar belakang kuning terang saat dihover */
  }
</style>


</head>
<body>
  <div class="container">
    <div class="row justify-content-center login-container">
      <div class="col-lg-4">
        <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="login-heading">
            <h2>Welcome!</h2>
          </div>
          <?php if(isset($error_message)) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $error_message; ?>
            </div>
          <?php } ?>
          <div class="mb-3">
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
          </div>
          <div class="mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
          </div>
          <div class="mb-3">
            <select name="role" id="role" class="form-select">
              <option value="admin">Admin</option>
              <option value="user">User</option>
            </select>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <div class="mt-3 text-center">
            <p>If you don't have an account, please <a href="registrasi.php">Register</a>.</p>
          </div>
          <div class="text-center">
            <button onclick="window.location.href='index.php'" class="back-to-home-btn">Back to Home</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
