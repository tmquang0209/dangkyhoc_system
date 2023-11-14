<!--   Core JS Files   -->
<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const navProfile = document.getElementById("nav-profile");
    $(document).ready(function() {
        $.post("/controller/account.php?getInfo").done((res) => {
            const data = JSON.parse(res.trim());
            if (Object.keys(data).length) {
                const html = `
                        <li class="nav-item d-flex align-items-center">
                            <a href="/views/profile.php" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">${data.student_code||data.teacher_code||data.staff_code} ${data.student_name||data.teacher_name||data.staff_name}</span>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="/views/change-password.php" class="nav-link text-white p-0">
                                Đổi mật khẩu
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="/views/logout.php" class="nav-link text-white p-0">
                                Đăng xuất
                            </a>
                        </li>`
                navProfile.insertAdjacentHTML("afterbegin", html)
            } else {
                const html = `
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="/views/sign-in.html" class="nav-link text-white p-0">
                                Đăng nhập
                            </a>
                        </li>`
                navProfile.insertAdjacentHTML("afterbegin", html)
            }
        }).fail((err) => {
            console.error(err);
        })
    })
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/assets/js/argon-dashboard.min.js?v=2.0.4"></script>