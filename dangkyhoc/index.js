const dayMappings = {
    1: "sun",
    2: "mon",
    3: "tue",
    4: "wed",
    5: "thur",
    6: "fri",
    7: "sat",
};

const storageKey = "schedule";

const apiEndpoints = {
    subjectList: "/models/schedule_list.php",
    fee: "/models/fee.php?get_fee",
    saveToDatabase: "/models/enroll.php?save",
    loadScheduleFromDatabase: "/models/enroll.php?getSchedule",
    removeFromDatabase: "/models/enroll.php?delSchedule",
};

let semesterid = 1;
let studentCode;
let studentName;
let storageData = [];

async function getSubjectBySemester() {
    try {
        const data = await $.post(apiEndpoints.subjectList, {
            semesterID: semesterid,
        });
        const parsedData = JSON.parse(data.trim());
        const result = parsedData.reduce((acc, item) => {
            const existingSubject = acc.find((s) => s.SubID === item.SubID);

            if (!existingSubject) {
                const subject = {
                    ID: item.ID,
                    SubID: item.SubID,
                    SubName: item.SubName,
                    Credits: item.Credits,
                    Coef: item.Coef,
                    ClassList: [],
                };
                acc.push(subject);
            }
            return acc;
        }, []);
        return result;
    } catch (error) {
        throw error;
    }
}

async function getSubjectByID(subID) {
    const data = await getSubjectBySemester();
    return data.find((element) => element.SubID === subID);
}

function getClass(subID) {
    return $.post(apiEndpoints.subjectList, { semesterID: semesterid }).then(
        (data) => {
            data = JSON.parse(data.trim());
            let acc = [];
            for (let i = 0; i < data.length; i++) {
                if (data[i].SubID != subID) continue;

                let dump = data[i];
                if (!dump.ClassName.endsWith("_BT")) {
                    const classItem = {
                        ClassName: dump.ClassName,
                        Day: [],
                        Shift: [],
                        Classroom: [],
                        Teacher: [],
                        PracticalClass: [],
                    };

                    data.filter((d) => d.ClassName == dump.ClassName).forEach(
                        (d) => {
                            classItem.Day.push(d.Day);
                            classItem.Shift.push(d.Shift);
                            classItem.Classroom.push(d.Classroom);
                            classItem.Teacher.push(d.Teacher);
                        }
                    );

                    if (dump.ClassName.endsWith("_LT")) {
                        const pratJsons = data.filter(
                            (d) =>
                                d.ClassName.startsWith(
                                    dump.ClassName.replace("_LT", "")
                                ) && d.ClassName.endsWith("_BT")
                        );

                        const uniquePratJsons = pratJsons.reduce(
                            (acc, pratJson) => {
                                if (
                                    !acc.some(
                                        (item) =>
                                            item.ClassName ===
                                            pratJson.ClassName
                                    )
                                ) {
                                    const uniquePratJson = {
                                        ClassName: pratJson.ClassName,
                                        Day: [],
                                        Shift: [],
                                        Classroom: [],
                                        Teacher: [],
                                    };
                                    data.filter(
                                        (d) =>
                                            d.ClassName === pratJson.ClassName
                                    ).forEach((d) => {
                                        uniquePratJson.Day.push(d.Day);
                                        uniquePratJson.Shift.push(d.Shift);
                                        uniquePratJson.Classroom.push(
                                            d.Classroom
                                        );
                                        uniquePratJson.Teacher.push(d.Teacher);
                                    });
                                    acc.push(uniquePratJson);
                                }
                                return acc;
                            },
                            []
                        );

                        classItem.PracticalClass.push(...uniquePratJsons);
                    }

                    classItem.Teacher = [...new Set(classItem.Teacher)];
                    acc.push(classItem);
                }
            }
            return acc;
        }
    );
}

async function getInfoClass(index, subID, className) {
    const data = await getClass(subID);
    return data.find((element) => element.ClassName === className);
}

function removeDuplicates(arr) {
    const uniqueArr = [];
    const classNames = new Set();
    arr.forEach((obj) => {
        if (!classNames.has(obj.ClassName)) {
            uniqueArr.push(obj);
            classNames.add(obj.ClassName);
        }
    });
    return uniqueArr;
}

async function checkShift(subID, day, shift) {
    if (storageData.length === 0) return true;

    const splitDay = day.split(",");
    const splitShift = shift.split(",");

    for (let i = 0; i < splitDay.length; i++) {
        const strDay = dayMappings[splitDay[i]];
        const [startShift, endShift] = splitShift[i].split("-");

        for (let j = Number(startShift); j <= Number(endShift); j++) {
            const getElementShift = document.getElementById(strDay + "_" + j);

            if (
                getElementShift.hasAttribute("rowspan") &&
                !getElementShift.classList.contains(subID)
            ) {
                return false;
            }
            if (
                getElementShift.classList.contains("hidden") &&
                !getElementShift.classList.contains(subID)
            ) {
                return false;
            }
        }
    }
    return true;
}

async function checkSubject(subID) {
    return storageData.some((element) => element.SubID == subID);
}

async function checkSchedule(subID, mainClass, pracClass) {
    const mainClassDay = mainClass.Day;
    const mainClassShift = mainClass.Shift;

    let flag = false;

    storageData.forEach((element) => {
        if (element.SubID != subID) {
            if (checkShift(subID, mainClassDay, mainClassShift)) {
                flag = true;
            }
            if (pracClass) {
                const pracClassDay = pracClass.Day;
                const pracClassShift = pracClass.Shift;
                if (checkShift(subID, pracClassDay, pracClassShift))
                    flag = true;
            }
        }
    });
    return flag;
}

function addSubjectToStorage() {
    $(".subject-box").on("click", "#addSubject", async function () {
        //get dataset
        const subID = this.value;
        const mainClassName = this.dataset.mainClassName;
        const mainClassroom = this.dataset.mainClassRoom;
        const mainClassDay = this.dataset.mainClassDay;
        const mainClassShift = this.dataset.mainClassShift;
        const mainClassTeacher = this.dataset.mainClassTeacher;

        //get subject
        const data = await getSubjectByID(subID);

        const type = this.checked;
        if (!type) {
            storageData.forEach((element, index) => {
                if (element.SubID == subID) {
                    removeSubjectFromTable(element);
                    localStorage.setItem(
                        "schedule",
                        JSON.stringify(storageData)
                    );
                    storageData.splice(index, 1);
                    loadResult();
                    removeSubjectFromDatabase(element);
                }
            });
            localStorage.setItem("schedule", JSON.stringify(storageData));
            return;
        }
        //check shift
        let flag = true;
        const flagMainClass = await checkShift(
            subID,
            mainClassDay,
            mainClassShift
        );
        if (!flagMainClass) {
            this.checked = false;
            flag = false;
        }

        const mainClass = {
            ClassName: mainClassName,
            Classroom: mainClassroom,
            Day: mainClassDay,
            Shift: mainClassShift,
            Teacher: mainClassTeacher,
        };

        let pracClass;
        if (this.dataset.pracClassName) {
            const pracClassName = this.dataset.pracClassName;
            const pracClassroom = this.dataset.pracClassRoom;
            const pracClassDay = this.dataset.pracClassDay;
            const pracClassShift = this.dataset.pracClassShift;
            const pracClassTeacher = this.dataset.pracClassTeacher;
            const flagPracClass = await checkShift(
                subID,
                pracClassDay,
                pracClassShift
            );
            if (!flagPracClass) {
                this.checked = false;
                flag = false;
            }

            pracClass = {
                MainClass: mainClassName,
                ClassName: pracClassName,
                Classroom: pracClassroom,
                Day: pracClassDay,
                Shift: pracClassShift,
                Teacher: pracClassTeacher,
            };
            data.ClassList = [];
        }

        //if tick to checkbox again or click other checkbox => remove from storage
        if (checkSubject(subID) && checkSchedule(subID, mainClass, pracClass)) {
            storageData.forEach((element, index) => {
                if (element.SubID == subID) {
                    const checkbox = document.querySelectorAll(
                        `input[type="checkbox"][id="addSubject"][value="${subID}"]`
                    );
                    checkbox.forEach((rowCheck) => {
                        if (rowCheck != this) rowCheck.checked = false;
                    });

                    removeSubjectFromTable(element);
                    removeSubjectFromDatabase(element);
                    storageData.splice(index, 1);
                    loadResult();
                }
            });
        }

        if (!flag) {
            alert("Trùng lịch với môn học đã đăng ký.");
            console.log("Trung lich!");
            return;
        }
        data.ClassList.push(mainClass);
        if (pracClass) data.ClassList.push(pracClass);

        //check subject in storage
        const checkStorage = await checkSubject(subID);
        if (!checkStorage) {
            storageData.push(data);
            localStorage.setItem("schedule", JSON.stringify(storageData));
        } else {
            storageData.forEach((element) => {
                if (element.SubID == data.SubID) {
                    element = [];
                    element.push(data);
                }
            });
        }
        addSubjectToTable();
        addSubjectToDatabase();
        loadResult();
    });
}

function addSubjectToTable() {
    storageData.forEach((storage) => {
        storage.ClassList.forEach((element) => {
            const splitDay = element.Day.split(",").filter((v) => v != "");
            const splitShift = element.Shift.split(",").filter((v) => v != "");

            for (let i = 0; i < splitDay.length; i++) {
                const day = splitDay[i];
                const [startShift, endShift] = splitShift[i].split("-");
                const countRowSpan = endShift - startShift + 1;
                const rowSpanName = dayMappings[day] + "_" + startShift;
                const getRow = document.getElementById(rowSpanName);
                getRow.classList.add("sub");
                getRow.classList.add(storage.SubID);
                getRow.setAttribute("rowspan", countRowSpan);
                getRow.innerHTML =
                    element.ClassName +
                    "<br/>" +
                    element.Classroom.split(",")[i];

                for (
                    let j = Number(startShift) + 1;
                    j <= Number(endShift);
                    j++
                ) {
                    const rowHidden = dayMappings[day] + "_" + j;
                    const getRowHidden = document.getElementById(rowHidden);
                    getRowHidden.classList.add("hidden");
                    getRowHidden.classList.add(storage.SubID);
                    getRowHidden.setAttribute("data-subid", storage.SubID);
                }
            }
        });
    });
}

function addSubjectToDatabase() {
    const data = { semesterid, studentCode, studentName, data: storageData };
    try {
        const saveData = async () => {
            try {
                const response = await fetch(apiEndpoints.saveToDatabase, {
                    method: "POST", // You are sending data, so use POST method
                    headers: {
                        "Content-Type": "application/json", // Specify the content type
                    },
                    body: JSON.stringify(data), // Convert data to JSON
                });

                if (!response.ok) {
                    throw new Error("Failed to save data");
                }

                // Handle the response from the server if needed
                // const responseData = await response.text();
                // console.log(responseData);
            } catch (error) {
                console.error("Error:", error);
            }
        };
        saveData();
    } catch (error) {
        console.error("Error:", error);
    }
}

function removeSubjectFromDatabase(data) {
    try {
        const del = async () => {
            try {
                const response = await fetch(apiEndpoints.removeFromDatabase, {
                    method: "POST", // You are sending data, so use POST method
                    headers: {
                        "Content-Type": "application/json", // Specify the content type
                    },
                    body: JSON.stringify({ semesterid, studentCode, data }), // Convert data to JSON
                });

                if (!response.ok) {
                    throw new Error("Failed to save data");
                }

                // Handle the response from the server if needed
                //     const responseData = await response.text();
                //     console.log(responseData);
            } catch (error) {
                console.error("Error:", error);
            }
        };
        del();
    } catch (error) {
        console.error("Error:", error);
    }
}

function removeSubjectFromTable(objSubject) {
    objSubject.ClassList.forEach((element) => {
        const splitDay = element.Day.split(",").filter((el) => el != "");
        const splitShift = element.Shift.split(",").filter((el) => el != "");
        for (let i = 0; i < splitDay.length; i++) {
            const day = splitDay[i];
            const [startShift, endShift] = splitShift[i].split("-");
            const rowSpanName = dayMappings[day] + "_" + startShift;
            const getRow = document.getElementById(rowSpanName);
            // console.log(getRow);
            getRow.classList.remove("sub");
            getRow.removeAttribute("class");
            getRow.removeAttribute("rowspan");
            getRow.textContent = "";
            for (let j = Number(startShift) + 1; j <= endShift; j++) {
                const rowHidden = dayMappings[day] + "_" + j;
                const getRowHidden = document.getElementById(rowHidden);
                getRowHidden.classList.remove("hidden");
            }
        }
    });
}

function loadResult() {
    const selectedSubject = document.getElementById("selectedSubject");
    const credits = document.getElementById("countCredits");
    let countCredits = 0;
    if (storageData.length == 0) {
        selectedSubject.innerHTML = "";
    } else {
        let html = "";
        storageData.forEach((element) => {
            const teachers = Object.values(element.ClassList).map(
                (teacher) => teacher.Teacher
            );
            html += ` <tr>
                        <td>${element.SubName}</td>
                        <td style="width:10px">${element.Credits}</td>
                        <td style="max-width:10px"><input style="width:100%" type="number" name="creditFactor" id="creditFactor" data-credits="${element.Credits}" value="${element.Coef}" onkeyup="sumCreditFactor()"></td>
                        <td>${teachers}</td>
                    </tr>`;
            countCredits += Number(element.Credits);
        });
        selectedSubject.innerHTML = html;
    }
    credits.innerHTML = countCredits;
    sumCreditFactor();
}

async function loadSubject() {
    const subjectBox = document.querySelector(".subject-box");
    subjectBox.innerHTML = "";
    const data = await getSubjectBySemester();
    data.forEach((element) => {
        const subElement = document.createElement("div");
        subElement.classList.add("subject");
        subElement.setAttribute("data-subject", element.SubID);
        subElement.setAttribute("data-index", element.ID);
        subElement.innerHTML = `<span>${element.SubName}</span>`;

        subjectBox.appendChild(subElement);
    });
}

function loadSchedule() {
    try {
        const getData = async () => {
            try {
                const response = await fetch(
                    apiEndpoints.loadScheduleFromDatabase,
                    {
                        method: "POST", // You are sending data, so use POST method
                        headers: {
                            "Content-Type": "application/json", // Specify the content type
                        },
                        body: JSON.stringify({ semesterid, studentCode }), // Convert data to JSON
                    }
                );

                if (!response.ok) {
                    throw new Error("Failed to save data");
                }

                // Handle the response from the server if needed
                const responseData = await response.text();
                // console.log(responseData);
                // console.log(JSON.parse(responseData.trim()));
                storageData = JSON.parse(responseData.trim());
                addSubjectToTable();
                loadResult();
            } catch (error) {
                console.error("Error:", error);
            }
        };
        getData();
    } catch (error) {
        console.error("Error:", error);
    }
}

function checked(className) {
    return storageData.some((el) => {
        return el.ClassList.some((el1) => {
            if (el1.ClassName === className) {
                // console.log(
                //     el1.ClassName,
                //     className,
                //     el1.ClassName === className
                // );
                return true; // This will stop iteration and return true.
            }
            return false; // Optional, but it makes the intention clear.
        });
    });
}

document.addEventListener("load", function () {});

$(document).ready(async function () {
    const paramsString = window.location.href.split("?")[1];
    const searchParams = new URLSearchParams(paramsString);

    semesterid = searchParams.get("semester_id");
    studentCode = searchParams.get("student_code");
    studentName = searchParams.get("student_name");

    loadSubject();
    loadSchedule();
    //click to display class list
    $(".subject-box").on("click", ".subject", async function (e) {
        // Check if the element has already been clicked
        if ($(this).hasClass("clicked")) {
            return;
        }
        $(this).addClass("clicked");

        const index = this.dataset.index;
        const subID = this.dataset.subject;
        const getSubDiv = document.querySelector(
            `.subject[data-subject=${subID}]`
        );
        const startList = document.createElement("ul");

        let dataClass = await getClass(subID);
        dataClass = removeDuplicates(dataClass);

        dataClass.forEach((rowClass) => {
            const classElement = document.createElement("div");
            classElement.classList.add("list-class");
            let classInfo = `${rowClass.ClassName} (`;
            classInfo += rowClass.Day.map((day, i) => {
                return `Thứ ${day} [${rowClass.Shift[i]}]`;
            }).join(", ");
            classInfo += `)`;

            if (rowClass.PracticalClass.length != 0) {
                const practicalHtml = rowClass.PracticalClass.map(
                    (practical) => {
                        const checkedInput = checked(practical.ClassName)
                            ? "checked"
                            : "";
                        return `<input type="checkbox" id="addSubject" name="addSubject" value="${subID}" data-main-class-name="${
                            rowClass.ClassName
                        }" data-main-class-room="${
                            rowClass.Classroom
                        }" data-main-class-day="${
                            rowClass.Day
                        }" data-main-class-shift="${
                            rowClass.Shift
                        }" data-main-class-teacher="${
                            rowClass.Teacher
                        }" data-prac-class-name="${
                            practical.ClassName
                        }" data-prac-class-room="${
                            practical.Classroom
                        }" data-prac-class-day="${
                            practical.Day
                        }" data-prac-class-shift="${
                            practical.Shift
                        }" data-prac-class-teacher="${
                            practical.Teacher
                        }" ${checkedInput}><label for="${
                            rowClass.ClassName
                        }">${classInfo}, ${
                            practical.ClassName
                        } (${practical.Day.map(
                            (day, i) => `Thứ ${day} [${practical.Shift[i]}]`
                        ).join(", ")})</label>`;
                    }
                ).join("<br/>");
                classElement.innerHTML = practicalHtml;
            } else {
                const checkedInput = checked(rowClass.ClassName)
                    ? "checked"
                    : "";
                classElement.innerHTML = `<input type="checkbox" id="addSubject" name="addSubject" value="${subID}" data-main-class-name="${rowClass.ClassName}" data-main-class-room="${rowClass.Classroom}" data-main-class-day="${rowClass.Day}" data-main-class-shift="${rowClass.Shift}" data-main-class-teacher="${rowClass.Teacher}" ${checkedInput}><label>${classInfo}</label>`;
            }
            startList.appendChild(classElement);
        });
        getSubDiv.appendChild(startList);
    });
    addSubjectToStorage();
});

function searchSubject() {
    var input, filter, list, div, span, i, txtValue;
    input = document.getElementById("subName");
    filter = input.value.toUpperCase();
    list = document.getElementById("subject-box");
    div = list.getElementsByClassName("subject");
    for (i = 0; i < div.length; i++) {
        span = div[i].getElementsByTagName("span");
        if (span[0]) {
            txtValue = span[0].textContent || span[0].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                div[i].style.display = "";
            } else {
                div[i].style.display = "none";
            }
        }
    }
}

async function sumCreditFactor() {
    try {
        const getFee = async () => {
            // Send an HTTP GET request to /?get_fee
            const response = await fetch(apiEndpoints.fee);

            // Check if the response status is OK (status code 200)
            if (!response.ok) {
                throw new Error("Failed to fetch fee");
            }

            // Parse the response body as JSON and extract the number
            return parseFloat(await response.text());
        };

        const fee = await getFee();
        let sum = 0,
            totalFee = 0;
        const getValue = document.querySelectorAll("#creditFactor");
        getValue.forEach((element) => {
            sum += Number(element.value) * Number(element.dataset.credits);
        });

        totalFee = sum * fee;

        const feeElement = document.getElementById("fee");
        feeElement.textContent = new Intl.NumberFormat().format(totalFee);
    } catch (error) {
        console.error("Error:", error);
    }
}
