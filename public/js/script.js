const body = document.querySelector("body");
const overlay = document.querySelector("#overlay");

// Sidebar toggle
const side_menu_toggle = document.querySelector(".menu-toggle");
const sidebar = document.querySelector(".sidebar");
const close_sidebar_menu = document.querySelector("aside .close-sidebar-btn");

if (side_menu_toggle) {
    side_menu_toggle.addEventListener("click", (e) => {
        e.preventDefault();
        sidebar.classList.add("show");
        overlay.style.display = "block";
    })
}

if (close_sidebar_menu) {
    close_sidebar_menu.addEventListener("click", (e) => {
        e.preventDefault();
        sidebar.classList.remove("show");
        overlay.style.display = "none";
    });
}
if (overlay) {
    overlay.addEventListener("click", (e) => {
        sidebar.classList.remove("show");
        overlay.style.display = "none";
    });
}

// Show, hide password
const toggle_password_btns = document.querySelectorAll("i.toggle-password");

if (toggle_password_btns) {
    toggle_password_btns.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            btn.classList.toggle("fa-eye");
            btn.classList.toggle("fa-eye-slash");
            const element = btn.nextElementSibling;
            element.type = element.type === "password" ? "text" : "password";
        })
    });
}

// Swip on nav link Function
function swip_category(nav, first_container, second_container) {
    if (nav.classList.contains("active")) {
        first_container.classList.add("show");
        second_container.classList.remove("show");
    } else {
        first_container.classList.remove("show");
        second_container.classList.add("show");
    }
}

// income & expense categories
const income_nav = document.querySelector(".categories-section .income-nav");
const expense_nav = document.querySelector(".categories-section .expense-nav");
const income_categories_container = document.querySelector(".categories-section .income-categories-container")
const expenses_categories_container = document.querySelector(".categories-section .expense-categories-container")

// Swip categories
if (income_nav && expense_nav) {
    swip_category(income_nav, income_categories_container, expenses_categories_container);
    income_nav.addEventListener("click", (e) => {
        income_nav.classList.add("active");
        expense_nav.classList.remove("active");
        swip_category(income_nav, income_categories_container, expenses_categories_container);
    });

    expense_nav.addEventListener("click", (e) => {
        income_nav.classList.remove("active");
        expense_nav.classList.add("active");
        swip_category(income_nav, income_categories_container, expenses_categories_container);
    });
}

// Swip categoriy pie graph
const income_category_pie_nav = document.querySelector(".income-category-pie-nav");
const expense_category_pie_nav = document.querySelector(".expense-category-pie-nav");
const income_category_pie_container = document.querySelector(".income-category-pie-container");
const expense_category_pie_container = document.querySelector(".expense-category-pie-container");

if (income_category_pie_nav && expense_category_pie_nav) {
    swip_category(income_category_pie_nav, income_category_pie_container, expense_category_pie_container);
    income_category_pie_nav.addEventListener("click", (e) => {
        income_category_pie_nav.classList.add("active");
        expense_category_pie_nav.classList.remove("active");
        swip_category(income_category_pie_nav, income_category_pie_container, expense_category_pie_container);
    });

    expense_category_pie_nav.addEventListener("click", (e) => {
        income_category_pie_nav.classList.remove("active");
        expense_category_pie_nav.classList.add("active");
        swip_category(income_category_pie_nav, income_category_pie_container, expense_category_pie_container);
    });
}

function checkPasswordMatch(pwdField, confirmPwdField) {
    if (pwdField) {
        pwdField.addEventListener("focus", (e) => {
            e.preventDefault();
            const smallText = e.target.parentNode.querySelector("small");
            if (e.target.value.length < 6) {
                smallText.classList.add("minus");
                smallText.textContent = "At least 6 characters";
            }
            document.addEventListener("keyup", () => {
                if (e.target.value.length >= 6) {
                    smallText.classList.remove("minus");
                    smallText.textContent = "Enough";
                } else {
                    smallText.classList.add("minus");
                    smallText.textContent = "At least 6 characters";
                }
            });
        });
        pwdField.addEventListener("blur", (e) => {
            e.preventDefault();
            const smallText = pwdField.parentNode.querySelector("small");
            if (pwdField.value.length >= 6) {
                smallText.classList.remove("minus");
                smallText.textContent = "Enough";
            } else {
                smallText.classList.add("minus");
                smallText.textContent = "At least 6 characters";
            }
        })
    }

    if (confirmPwdField) {
        confirmPwdField.addEventListener("focus", (e) => {
            e.preventDefault();
            const pwd = pwdField.value;
            const smallText = e.target.parentNode.querySelector("small");
            smallText.classList.add("minus");
            document.addEventListener("keyup", () => {
                if (e.target.value == pwd) {
                    smallText.classList.remove("minus");
                    smallText.textContent = "Match";
                } else {
                    smallText.classList.add("minus");
                    smallText.textContent = "Password does't match";
                }
            });
        });
    }
}
//Password Match
const pwdField = document.querySelector(".register-section #password");
const confirmPwdField = document.querySelector(".register-section #confirmPassword");

checkPasswordMatch(pwdField, confirmPwdField);

const newPwdField = document.querySelector(".reset-password-section #new-password");
const confirmNewPwdField = document.querySelector(".reset-password-section #confirmPassword");

checkPasswordMatch(newPwdField, confirmNewPwdField);

const newPassword = document.querySelector(".change-password-section #new-password");
const confirmNewPassword = document.querySelector(".change-password-section #confirmPassword");

checkPasswordMatch(newPassword, confirmNewPassword);

// Select Icon
const icons = document.querySelectorAll(".icons-container i");
const selected_icon = document.querySelector(".add-categories-section #selected-icon i");
const icon_id = document.querySelector(".add-categories-section input#icon-id");

icons.forEach(icon => {
    icon.addEventListener("click", (e) => {
        e.preventDefault();
        const classArr = e.target.classList.value.split(" ");
        classArr.pop();
        classArr.pop();
        selected_icon.classList.value = classArr.join(" ");
        selected_icon.style.backgroundColor = e.target.style.backgroundColor;
        icon_id.value = e.target.dataset.id;
    })
});

// Alert hide
const alert = document.querySelector(".alert");

if (alert) {
    setTimeout(() => {
        alert.style.display = "none";
    }, 3000);
}

const backToTopBtn = document.querySelector(".back-to-top");
if (backToTopBtn) {
    window.onscroll = function () {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop) {
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    }

    backToTopBtn.addEventListener("click", (e) => {
        e.preventDefault();
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
}

const baseUrl = 'http://localhost:8000';
const app = document.getElementById("app");
function changeDate() {
    const requestMonth = $("#month").val().split("/");
    location.replace(`${baseUrl}/home?time=${requestMonth[0]}+${requestMonth[1]}`);
}

function changeYear() {
    const requestYear = $("#year").val();
    console.log(requestYear)
    location.replace(`${baseUrl}/statistics/${requestYear}`);
}

$(function () {
    $('#month').datepicker(
        {
            dateFormat: "M/yy",
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function (dateText, inst) {


                function isDonePressed() {
                    return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
                }

                if (isDonePressed()) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');

                    $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
                }
            },
            beforeShow: function (input, inst) {

                inst.dpDiv.addClass('month_year_datepicker')

                if ((datestr = $(this).val()).length > 0) {
                    year = datestr.substring(datestr.length - 4, datestr.length);
                    month = datestr.substring(0, 2);
                    $(this).datepicker('option', 'defaultDate', new Date(year, month - 1, 1));
                    $(this).datepicker('setDate', new Date(year, month - 1, 1));
                    $(".ui-datepicker-calendar").hide();
                }
            }
        });
    $('#year').datepicker(
        {
            dateFormat: "yy",
            changeYear: true,
            showButtonPanel: true,
            onClose: function (dateText, inst) {


                function isDonePressed() {
                    return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
                }

                if (isDonePressed()) {
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, 1, 1)).trigger('change');

                    $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
                }
            },
            beforeShow: function (input, inst) {

                inst.dpDiv.addClass('month_year_datepicker')

                if ((datestr = $(this).val()).length > 0) {
                    year = datestr.substring(datestr.length - 4, datestr.length);
                    month = datestr.substring(0, 2);
                    $(this).datepicker('option', 'defaultDate', new Date(year, month - 1, 1));
                    $(this).datepicker('setDate', new Date(year, month - 1, 1));
                    $(".ui-datepicker-calendar").hide();
                }
            }
        });
    $("#pick-month-btn").click(function () {
        $("#month").datepicker("show");
    });
    $("#pick-year-btn").click(function () {
        $("#year").datepicker("show");
    });
    $("#pick-date").datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        onClose: function (dateText, inst) {


            function isDonePressed() {
                return ($('#ui-datepicker-div').html().indexOf('ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all ui-state-hover') > -1);
            }

            if (isDonePressed()) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1)).trigger('change');

                $('.date-picker').focusout()//Added to remove focus from datepicker input box on selecting date
            }
        },
        beforeShow: function (input, inst) {

            inst.dpDiv.addClass('month_year_datepicker')

            if ((datestr = $(this).val()).length > 0) {
                year = datestr.substring(datestr.length - 4, datestr.length);
                month = datestr.substring(0, 2);
                $(this).datepicker('option', 'defaultDate', new Date(year, month - 1, 1));
                $(this).datepicker('setDate', new Date(year, month - 1, 1));
                $(".ui-datepicker-calendar").hide();
            }
        }
    });
    $("#startdatepicker").datepicker({
        changeMonth: true,
        changeYear: true,
    });
    $("#enddatepicker").datepicker({
        changeMonth: true,
        changeYear: true,
    });
});

const languageModal = document.getElementById("language-modal");
const languageRadioBtns = document.querySelectorAll('#language-modal input[type="radio"]');
languageRadioBtns.forEach(radio => {
    radio.addEventListener("change", () => {
        setTimeout(updateSettingRequest('language', { language: radio.value }), 500);
        showLoaderIcon(document.querySelector('#language-modal .loading-spinner'));
    });
});

const unitModal = document.getElementById("unit-modal");
const unitRadioBtns = document.querySelectorAll('#unit-modal input[type="radio"]');
unitRadioBtns.forEach(radio => {
    radio.addEventListener("change", () => {
        setTimeout(updateSettingRequest('unit', { unit: radio.value }), 500);
        showLoaderIcon(document.querySelector('#unit-modal .loading-spinner'));
    });
});

function updateSettingRequest(setting_name, reqbody) {
    fetch(`${baseUrl}/setting/edit/${setting_name}`, {
        method: 'POST',
        headers: {
            'content-type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(reqbody),
    }).then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showErrors(data.errors);
                hideAlert();
            }
        })
        .catch(err => showError(err))
}
function showAlert(type, message) {
    const alert = document.createElement('div');
    alert.classList.value = `alert alert-${type}`;
    alert.textContent = message;
    app.appendChild(alert);
}

function hideAlert() {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = "none";
        }, 3000);
    })
}

function showError(err) {
    showAlert('warning', err)
}

function showErrors(errors) {
    const ol = document.createElement('ol');
    for (const key in errors) {
        const li = document.createElement('li');
        li.textContent = errors[key];
        ol.appendChild(li);
    }

    const alert = document.createElement('div');
    alert.classList.value = `alert alert-warning`;
    alert.appendChild(ol);
    app.appendChild(alert);
}

function showLoaderIcon(element) {
    element.classList.remove('d-none');
}


// // return "<?= htmlspecialchars($formatted_number) ?> {{ __(auth()->user()->setting->budget_unit) }}";