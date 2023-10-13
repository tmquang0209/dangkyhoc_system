<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="./login_template/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login_template/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login_template/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login_template/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login_template/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login_template/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login_template/css/util.css">
    <link rel="stylesheet" type="text/css" href="./login_template/css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="./login_template/images/img-01.png" alt="IMG">
                </div>

                <div class="login100-form validate-form">
                    <span class="login100-form-title">
                        Login
                    </span>
                    <div id="message"></div>
                    <div class="wrap-input100 validate-input" data-validate="Nhập tên đăng nhập">
                        <input class="input100" type="text" name="username" id="username" placeholder="Username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Nhập mật khẩu">
                        <input class="input100" type="password" name="password" id="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="login" id="login">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Forgot
                        </span>
                        <a class="txt2" href="#">
                            Username / Password?
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="#">
                            Create your Account
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!--===============================================================================================-->
    <script src="./login_template/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="./login_template/vendor/bootstrap/js/popper.js"></script>
    <script src="./login_template/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="./login_template/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="./login_template/vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <!--===============================================================================================-->
    <script src="./login_template/js/main.js"></script>

    <script>
        const message = document.getElementById("message");
        const loginBtn = document.getElementById("login");
        const username = document.getElementById("username");
        const password = document.getElementById("password");

        loginBtn.addEventListener("click", async () => {
            console.log(username.value, password.value);
            if (username.value && password.value) {
                try {
                    const response = await fetch("/models/login.php?checkAccount", {
                        username,
                        password
                    })

                    const responseText = await response.text();
                    const json = cleanedResponse(responseText);
                    console.log(json);
                    if (json.msgCode === -1) {
                        message.innerHTML = `<div class="alert alert-danger" role="alert">${json.message}.</div>`
                    } else {
                        message.innerHTML = `<div class="alert alert-success" role="alert">${json.message}.</div>`
                        setTimeout(() => {
                            window.location = "/";
                        }, 2000);
                    }
                } catch (err) {
                    console.error(err);
                }
            } else {
                message.innerHTML = `<div class="alert alert-danger" role="alert">Please fill full information.</div>`
            }
        })

        function cleanedResponse(text) {
            const cleaned = text.replace(/^\ufeff/, '');
            return JSON.parse(cleaned);
        }
    </script>

</body>

</html>