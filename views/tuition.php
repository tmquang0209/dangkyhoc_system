<?php
// for student
session_start();
if (!isset($_SESSION["account"])) {
    header('Location: /views/sign-in.html');
    exit;
}
if (!isset($_SESSION["account"]["student_code"])) {
    header("Location: /");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <title>
        Học phí
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <?php include_once("header.php"); ?>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Trang</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Học phí</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Học phí</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here...">
                        </div>
                    </div>
                    <ul class="navbar-nav  justify-content-end" id="nav-profile">
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Học phí</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Học kỳ</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số tiền</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tình trạng</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="list"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const semesterList = document.getElementById("list");
        $(document).ready(async function() {
            get();
        });

        function get() {
            $.post(`/controller/tuition.php?student`).done(function(res) {
                const data = JSON.parse(res.trim()).result;
                let total = 0;
                data.forEach((item) => {
                    render(item);
                    total += item.total_tuition;
                })

                const html = `<tr>
                                <td class="align-middle text-center">Tổng</td>
                                <td>
                                    <p class="text-s font-weight-bold mb-0">${data.length} kỳ</p>
                                </td>
                                <td class="align-middle text-center text-s">
                                    ${total.toLocaleString('vi-VN',{
                                                        style: 'currency',
                                                        currency: 'VND',
                                                    })}
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold"></span>
                                </td>
                                <td class="align-middle"></td>
                            </tr>`

                semesterList.insertAdjacentHTML("beforeend", html);
            });
        }

        function render(item) {
            console.log(item);
            const html = `
            <tr>
                <td class="align-middle text-center">${item.tuition_id}</td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">${item.semester_name} năm học ${item.year}</p>
                </td>
                <td class="align-middle text-center text-sm">
                    ${item.total_tuition.toLocaleString('vi-VN',{
                                                        style: 'currency',
                                                        currency: 'VND',
                                                    })}
                </td>
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">${item.status}</span>
                </td>
                <td class="align-middle">
                    <a href="/views/tuition-detail.php?id=${item.tuition_id}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        Xem chi tiết
                    </a>
                </td>
            </tr>
            `
            semesterList.insertAdjacentHTML("beforeend", html);
        }
    </script>
    <?php
    include_once("footer.php");
    ?>

</body>

</html>