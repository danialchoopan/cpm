$(document).ready(function () {
    const time_slide_up = 150;
    const cp_box_background = $("#cp-box-background");
    const cp_login_box = $("#cp-login-box");
    const cp_register_box = $("#cp-register-box");
    const cp_register_validate_sms_box = $("#cp-register-validate-sms-box");
    const id_cp_box_loader_ajax = $("#id-cp-box-loader-ajax");
    const SITE_URL_API = 'http://127.0.0.1/car%20project%20mvc/api/';
    const SITE_URL = 'http://127.0.0.1/car%20project%20mvc/';
    hook();
    //login box section
    $("#btn-opn-login").click(function () {
        before_show_box();
        cp_login_box.slideDown(time_slide_up);

    });
    //register box section
    $("#btn-opn-register").click(function () {
        before_show_box();
        cp_register_box.slideDown(time_slide_up);

    });

    //this part written by legendary BIG M
    cp_box_background.click(function (e) {
        if (e.target.id == "cp-box-background") {
            cp_box_background.hide();
        }
    });
    //login
    $("#lgn-button-login-run").click(function () {
        const lgn_phone_number_input = $("#lgn-email-phone-input").val();
        const lgn_password_input = $("#lgn-password-input").val();
        const msg_box = $('#box-msg-login');
        show_loader();
        $.ajax({
            type: 'POST',
            url: `${SITE_URL_API}user/login`,
            data: {lgn_phone_number: lgn_phone_number_input, lgn_password: lgn_password_input},
            success: function (data) {
                hide_loader();
                if (data == false) {
                    msg_box_register.css({color: 'red'});
                    msg_box.text("نام کاربری یا رمز عبور اشتباه است");
                } else {
                    msg_box_register.css({color: 'green'});
                    msg_box.text("خوش آمدید !");
                }
            }
        });
    });
    //register
    $("#rgr-button-register-run").click(function () {
        const rgr_email = $("#rgr-email-input").val();
        const rgr_full_name = $("#rgr-full-name").val();
        const rgr_password = $("#rgr-password-input").val();
        const rgr_r_password = $("#rgr-re-password-input").val();
        const rgr_phone = $("#rgr-phone-input").val();
        const msg_box_register = $("#box-msg-register");
        if (rgr_password == "" && rgr_email == "" && rgr_full_name == "" && rgr_phone == "" && rgr_r_password == "") {
            msg_box_register.css({color: 'red'});
            msg_box_register.text("لطفا فیلد های مورد نظر را کامل کنید!!!!");
            return;
        }
        if (rgr_r_password != rgr_password) {
            msg_box_register.css({color: 'red'});
            msg_box_register.text("رمز عبور شما یکسان نیست !!!!!!!!!");
            return;
        }
        show_loader();
        $.ajax({
            type: 'POST',
            url: `${SITE_URL_API}user/register`,
            data: {
                rgr_name: rgr_full_name,
                rgr_email: rgr_email,
                rgr_phone_number: rgr_phone,
                rgr_password: rgr_password
            },
            success: function (data) {
                hide_loader();
                if (data != false) {
                    cp_register_box.css({color: 'green'});
                    cp_register_box.html("</h1> شما با موفقیت نام نویسی شدید ! <h1>");
                    show_loader();
                    setTimeout(() => {
                        hide_loader();
                        window.location = `${SITE_URL}user/validate/phone/${rgr_phone}`;
                    }, 1000);
                    // setTimeout(() => {
                    //     cp_register_box.slideUp(100);
                    //     cp_register_validate_sms_box.slideDown(100);
                    // }, 200)
                    // $("#p-phone").text(rgr_phone);
                    $("#box-msg-register-validate_sms").text(`کد تایید ارسال شده به : ${rgr_phone} \n لطفا صبر کنید ممکن تا 5 دقیقه طول بکشید`);
                } else {
                    msg_box_register.css({color: 'red'});
                    msg_box_register.text("مشکلی پیش آمده این لطفا بعدا امتحان کنید");
                }
            }
        });
    });
    //check validate code
    $("#rgr-v-button-register-validate-run").click(function () {
        const rgr_v_code = $("#rgr-v-code").val();
        const p_phone = $("#p-phone").val();
        const box_msg_sms_validate = $("#box-msg-register-validate_sms");
        show_loader();
        $.ajax({
            type: 'POST',
            url: `${SITE_URL_API}user/validate/phone`,
            data: {rgr_v_code: rgr_v_code, p_phone: p_phone},
            success: function (data) {
                console.log(data)
                hide_loader();
                box_msg_sms_validate.css({color: 'red'})
                if (data == 1) {
                    box_msg_sms_validate.text(`کد شما منقطی شده است !`);
                } else if (data == 2) {
                    box_msg_sms_validate.text(`تلفن شما قبلا تایید شده است!`);
                } else if (data == 3) {
                    box_msg_sms_validate.text(`کد وارد شده اشتباه است`);
                } else if (data == 4) {
                    box_msg_sms_validate.css({color: 'green'})
                    box_msg_sms_validate.text(`حساب شما با موفقیت تایید شد خوش آمدید!`);
                    window.location = SITE_URL;
                } else {
                    box_msg_sms_validate.text(`مشکلی پیش آمده است لطفا بعدا امتحان کنید`);
                }
            }
        });
    });

    //functions
    function hook() {
        cp_box_background.hide();
        cp_box_background.css({visibility: 'visible'});
        cp_login_box.css({visibility: 'visible'});
        cp_register_box.css({visibility: 'visible'});
        cp_register_validate_sms_box.css({visibility: 'visible'});
    }

    function before_show_box() {
        cp_login_box.hide();
        cp_register_box.hide();
        cp_register_validate_sms_box.hide();
        cp_box_background.show();
    }

    function hide_loader() {
        id_cp_box_loader_ajax.css({visibility: "hidden"})
    }

    function show_loader() {
        id_cp_box_loader_ajax.css({visibility: "visible"})
    }
});