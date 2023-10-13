<?php
include __DIR__ . "/../models/semester.php";
$semester = new Semester();
$semesterInfo = $semester->getSemesterList();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="logo.svg" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Đăng ký học</title>
    <style>
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: red;
        }

        .search-box {
            display: block;
            text-align: center;
        }

        .subject-box {
            margin-left: 10px;
            height: 500px;
            overflow-y: auto;
        }

        .subject-box .subject {
            padding-left: 5px;
        }

        .subject-box .subject span {
            font-size: 15px;
            color: blue;
        }

        .subject-box .subject ul {
            padding: 5px;
        }

        label {
            padding-left: 5px;
            display: inline-block;
            max-width: 100%;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 13px;
            width: 90%;
        }

        .subject-box .subject .list-class {
            font-size: 15px;
        }

        table td {
            width: 100px;
            word-break: break-word;
        }

        table th {
            width: 100px;
        }

        .loading-result {
            width: 100%;
            display: fixed;
            margin: auto;
            padding: 10px 50px;

        }

        .container .sub {
            background-color: yellow;
            vertical-align: middle;
            text-align: center;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">

        <?php if (isset($_GET["semester_id"]) && isset($_GET["student_code"]) && isset($_GET["student_name"])) { ?>
            <div class="row">
                <div class="col-sm-5">
                    <div class="title">Danh sách môn học</div>
                    <div class="search-box">
                        <div class="form-floating mb-3 mt-3 ">
                            <input type="text" id="subName" onkeyup="searchSubject()" class="form-control" placeholder="Nhập môn học cần tìm ...">
                            <label for="">Tìm kiếm môn học</label>
                        </div>
                    </div>
                    <div class="subject-box" id="subject-box"></div>
                </div>
                <div class="col-sm-7">
                    <div class="title">Thời khóa biểu</div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:fit-content;">Ca</th>
                                <th>Thứ 2</th>
                                <th>Thứ 3</th>
                                <th>Thứ 4</th>
                                <th>Thứ 5</th>
                                <th>Thứ 6</th>
                                <th>Thứ 7</th>
                                <th>Chủ nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 1; $i <= 13; $i++) {
                                echo '<tr>
                                <td id="shift" data-item="' . $i . '" style="width:fit-content;">' . $i . '</td>
                                <td id="mon_' . $i . '"></td>
                                <td id="tue_' . $i . '"></td>
                                <td id="wed_' . $i . '"></td>
                                <td id="thur_' . $i . '"></td>
                                <td id="fri_' . $i . '"></td>
                                <td id="sat_' . $i . '"></td>
                                <td id="sun_' . $i . '"></td>
                            </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="sm-12">
                    <div class="title">Môn học đã chọn</div>
                    <div class="loading-result">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Môn học</th>
                                    <th style="width:10px">Số tín</th>
                                    <th style="width:10px">Hệ số</th>
                                    <th>Người dạy</th>
                                </tr>
                            </thead>
                            <tbody id="selectedSubject"></tbody>
                            <tr>
                                <td>Tổng số tín</td>
                                <td style="width:10px" id="countCredits"></td>
                                <td style="width:10px" id="fee"></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <script src="../index.js"></script>
        <?php } else {
        ?>
            <div class="row">
                <div class="col-md-12" style="font-size: 30px; text-align:center;color:red;">Thông tin đăng ký học</div>
                <div class="col-md-12" style="font-size: 20px; text-align:center;color:red;">Nhập đúng thông tin MSV và Tên, nếu chưa tồn tại => tự động tạo user</div>
                <div class="col-sm-12">
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="semester" name="semester">
                            <option value="">---Lựa chọn---</option>
                            <?php
                            foreach ($semesterInfo as $row) {
                                echo '<option value="' . $row["id"] . '">' . $row["semester_name"] . " năm học " . $row["year"] . '</option>';
                            }
                            ?>
                        </select>
                        <label for="sel1" class="form-label">Học kỳ:</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" placeholder="Ma sinh vien" id="student_code">
                        <label for="">Mã sinh viên</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" placeholder="Ho ten" id="student_name">
                        <label for="">Họ và tên</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" name="submit" id="submit">Submit</button>
            </div>
            <script>
                const semester = document.getElementById("semester");
                const studentCode = document.getElementById("student_code");
                const studentName = document.getElementById("student_name");
                const submitBtn = document.getElementById("submit")

                submitBtn.addEventListener("click", async function() {
                    if (semester.value && studentCode.value && studentName.value) {
                        // Send to the backend to check the account
                        // If not exists, create an account and save it to the database
                        const checkAccount = async () => {
                            try {
                                const response = await fetch(`/models/account.php?check_student`, {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                    },
                                    body: JSON.stringify({
                                        studentCode: studentCode.value,
                                        studentName: studentName.value
                                    }),
                                });

                                if (!response.ok) {
                                    throw new Error("Failed");
                                }

                                const res = await response.text(); // Await here

                                if (res.trim() === "-2") {
                                    alert("Thông tin không chính xác");
                                } else {
                                    window.location.assign(`?semester_id=${semester.value}&student_code=${studentCode.value}&student_name=${studentName.value}`);
                                }
                            } catch (err) {
                                console.error(err);
                            }
                        };
                        await checkAccount(); // Await here
                    } else {
                        alert("Nhập đủ thông tin.");
                    }
                });
            </script>
        <?php } ?>
    </div>
</body>

</html>