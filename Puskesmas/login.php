<?php
session_start();
require_once 'dbkoneksi.php';

$usernameErr = $passwordErr = $authenticationErr = '';
$username = $password = '';

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['username'])) {
        $usernameErr = 'Username tidak boleh kosong!';
    } else {
        $username = test_input($_POST['username']);
    }
    if (empty($_POST['password'])) {
        $passwordErr = 'Password tidak boleh kosong!';
    } else {
        $password = md5(test_input($_POST['password']));
    }

    $authenticated = false;

    if (!$usernameErr && !$passwordErr) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $query = $dbh->prepare($sql);
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        if ($user && $user->password === $password) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $user->name;
            $_SESSION['role'] = $user->role;
            $authenticated = true;
        } else {
            $authenticationErr = 'Username atau password salah!';
        }
    }


    if ($authenticated) {
        header("location: index.php");
    } else {
        $authenticationErr = 'Username atau password salah!';
    }
}
?>

<?php
require_once 'dbkoneksi.php';

$nameErr = $usernameErr = $passwordErr = $konfPasswordErr = $authenticationErr = ''; // Mengubah variabel error menjadi sesuai dengan yang di definisikan di atas
$name = $username = $password = $konfPassword = '';

function test_input1($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name1'])) {
        $nameErr = 'nama tidak boleh kosong!'; // Mengubah variabel error menjadi sesuai dengan yang di definisikan di atas
    } else {
        $name = test_input1($_POST['name1']);
    }
    if (empty($_POST['username1'])) {
        $usernameErr = 'Username tidak boleh kosong!'; // Mengubah variabel error menjadi sesuai dengan yang di definisikan di atas
    } else {
        $username = test_input1($_POST['username1']);
    }
    if (empty($_POST['password1'])) {
        $passwordErr = 'Password tidak boleh kosong!'; // Mengubah variabel error menjadi sesuai dengan yang di definisikan di atas
    } else {
        $password = md5(test_input1($_POST['password1']));
    }
    if (empty($_POST['konfirmasi-password1'])) {
        $konfPasswordErr = 'Konfirmasi Password tidak boleh kosong!'; // Mengubah variabel error menjadi sesuai dengan yang di definisikan di atas
    } else {
        $konfPassword = test_input1($_POST['konfirmasi-password1']);
        if ($password !== md5($konfPassword)) {
            $konfPasswordErr = 'Konfirmasi password harus sesuai';
        }
    }

    if (!$nameErr && !$usernameErr && !$passwordErr && !$konfPasswordErr) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $query = $dbh->prepare($sql);
        $query->execute([$username]);
        $user = $query->fetchObject();

        if ($user) {
            $authenticationErr = 'Username sudah dipakai';
        } else {
            $sql = "INSERT INTO user (username, name, password) VALUES (?, ?, ?)";
            $query = $dbh->prepare($sql);
            $query->execute([$username, $name, $password]);
            exit();
        }
    } else {
        $authenticationErr = 'Username atau password salah!';
    }
}
?>
<style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
    box-sizing: border-box;
}

body {
    background: #f6f5f7;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-family: 'Montserrat', sans-serif;
    height: 100vh;
    margin: -20px 0 50px;
}

h1 {
    font-weight: bold;
    margin: 0;
}

h2 {
    text-align: center;
}

p {
    font-size: 14px;
    font-weight: 100;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin: 20px 0 30px;
}

span {
    font-size: 12px;
}

a {
    color: #4ad66d; /* Warna hijau army */
    font-size: 14px;
    text-decoration: none;
    margin: 15px 0;
}

button {
    border-radius: 20px;
    border: 1px solid #1a7431; /* Warna untuk tombol Sign In dan Sign Up */
    background: linear-gradient(to right, #1a7431, #4ad66d); /* Gradasi dari #1a7431 ke #4ad66d */
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
}

button:active {
    transform: scale(0.95);
}

button:focus {
    outline: none;
}

button.ghost {
    background-color: transparent;
    border-color: #FFFFFF;
}

form {
    background-color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    text-align: center;
}

input {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
}

.container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
            0 10px 10px rgba(0,0,0,0.22);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 480px;
}

.form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in-container {
    left: 0;
    width: 50%;
    z-index: 2;
}

.container.right-panel-active .sign-in-container {
    transform: translateX(100%);
}

.sign-up-container {
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.container.right-panel-active .sign-up-container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
}

@keyframes show {
    0%, 49.99% {
        opacity: 0;
        z-index: 1;
    }
    
    50%, 100% {
        opacity: 1;
        z-index: 5;
    }
}

.overlay-container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 100;
}

.container.right-panel-active .overlay-container{
    transform: translateX(-100%);
}

.overlay {
    background: #4ad66d; /* Warna hijau army */
    color: #FFFFFF;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
    transform: translateX(50%);
}

.overlay-panel {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    text-align: center;
    top: 0;
    height: 100%;
    width: 50%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.overlay-left {
    transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
    transform: translateX(0);
}

.overlay-right {
    right: 0;
    transform: translateX(0);
}

.container.right-panel-active .overlay-right {
    transform: translateX(20%);
}

.social-container {
    margin: 20px 0;
}

.social-container a {
    border: 1px solid #DDDDDD;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 5px;
    height: 40px;
    width: 40px;
}

footer {
    background-color: #222;
    color: #fff;
    font-size: 14px;
    bottom: 0;
    position: fixed;
    left: 0;
    right: 0;
    text-align: center;
    z-index: 999;
}

footer p {
    margin: 10px 0;
}

footer i {
    color: red;
}

footer a {
    color: #3c97bf;
    text-decoration: none;
}

</style>


<div class="container" id="container">
<!-- Bagian Form Registrasi -->
<div class="form-container sign-up-container">
<form id="signUpForm" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1>Create Account</h1>
        <span>or use your email for registration</span>
        <input type="text" name="name1" placeholder="Name" />
        <span class="text-red"><?= $nameErr ?></span>
        <input type="text" name="username1" placeholder="username" />
        <span class="text-red"><?= $usernameErr ?></span>
        <input type="password" name="password1" placeholder="Password" />
        <span class="text-red"><?= $passwordErr ?></span>
        <input type="password" name="konfirmasi-password1" placeholder="Konfirmasi Password" />
        <span class="text-red"><?= $konfPasswordErr ?></span>
        <button type="submit"  id="signIn1" >Sign Up</button>
        <!-- <span class="text-red"><?= $authenticationErr ?></span> --> <!-- hapus baris ini karena variabel $authenticationErr tidak digunakan -->
    </form>
</div>

<!-- Bagian Form Login -->
<div class="form-container sign-in-container">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1>Sign in</h1>
        <span>or use your account</span>
        <input type="text" name="username" placeholder="Username" />
        <input type="password" name="password" placeholder="Password" />
        <button type="submit">Sign In</button>
    </form>
    <span class="text-red"><?= $usernameErr ?></span>
</div>
    
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>Untuk tetap terhubung dengan kami, silakan login dengan informasi pribadi Anda</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello!</h1>
				<p>Masukkan detail pribadi Anda dan mulailah perjalanan bersama kami</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>



<script>
    const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const signInButton1 = document.getElementById('signIn1');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});
signInButton1.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});
</script>
 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Tangkap formulir registrasi
        var signUpForm = document.getElementById("signUpForm");

        // Tambahkan event listener untuk menangani pengiriman formulir
        signUpForm.addEventListener("submit", function (event) {
            // Menghentikan perilaku default dari form submission (refresh halaman)
            event.preventDefault();

            // Dapatkan data formulir
            var formData = new FormData(signUpForm);

            // Kirim data formulir menggunakan AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", signUpForm.getAttribute("action"), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Handle respon yang diterima dari server jika perlu
                    console.log(xhr.responseText);
                }
            };
            xhr.send(formData);
        });
    });
</script>