<footer class="cp-footer">
    فوتتر سایت
</footer>

<!-- Modal login-->
<div class="modal fade" id="login_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title ">ورود</h5>
                <div class="d-flex justify-content-between">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body rtl">
                <div id="login_show_messages_box">

                </div>
                <div class="form-group">
                    <label for="input_username_login">پست الکترونیک: </label>
                    <input type="email" class="form-control" id="input_username_login"
                           placeholder="example@example.com ..."
                           required>
                </div>

                <div class="form-group">
                    <label for="input_password_login">گذرواژه: </label>
                    <input type="password" class="form-control" id="input_password_login"
                           placeholder="******************* ..." required>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block" onclick="click_login_model()">ورود</button>
                </div>
                <p class="m-2"><a href="{{route('forget/password/user')}}">پسورد خود را فراموش کرده ام!</a></p>

                <p class="m-2"><a href="{{route('register/user')}}"> نام نویسی نکرده اید همین حالا نام نویسی کنید!</a>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>
<!-- end Modal login-->

<script src="{{assets('js/jquery-3.5.1.min.js')}}"></script>
<script src="{{assets('js/bootstrap.min.js')}}"></script>
{{--<script src="{{assets('js/main.js')}}"></script>--}}
<script>
    $('#Modal_show_msg').modal('show')
    $('#Modal_show_msg_user').modal('show')
    const SITE_URL_API = 'http://127.0.0.1/cpm/api/';

    function click_login_model() {
        const lgn_phone_number_input = $("#input_username_login").val();
        const lgn_password_input = $("#input_password_login").val();
        const msg_box = $('#login_show_messages_box');
        if (lgn_phone_number_input == "" && lgn_password_input == "") {
            msg_box.html(`
            <div class="alert alert-warning" role="alert">
            فیلد خالی مجاز نیست
            </div>
            `)
            return;
        }
        $.ajax({
            type: 'POST',
            url: `${SITE_URL_API}user/login`,
            data: {lgn_phone_number: lgn_phone_number_input, lgn_password: lgn_password_input},
            success: function (data) {
                msg_box.html(`
                    <div class="alert alert-info" role="alert">
                        درحال ارسال اطلاعات
                    </div>
                    `);
                if (data == "false") {
                    msg_box.html(`
                    <div class="alert alert-danger" role="alert">
                        رمز عبور یا پست الکترونیک اشتباه است!
                    </div>
                    `);
                } else {
                    msg_box.html(`
                    <div class="alert alert-success" role="alert">
                        خوش آمدید
                    </div>
                    `);
                    location.reload();
                }
            }
        });
    }
</script>
</div>
</body>
</html>
