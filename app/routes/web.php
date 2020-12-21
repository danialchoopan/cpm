<?php

use App\controller\admin\AdminApplyCarController;
use App\controller\admin\AdminAuthController;
use App\controller\admin\AdminBlogCommentsController;
use App\controller\admin\AdminBlogPostsController;
use App\controller\admin\AdminBrandCarController;
use App\controller\admin\AdminCarController;
use App\controller\admin\AdminCategoryPostsController;
use App\controller\admin\AdminConditionCarSellController;
use App\controller\admin\AdminDashController;
use App\controller\admin\AdminGestController;
use App\controller\admin\setting\AdminAboutUsSetting;
use App\controller\admin\setting\AdminContactUsSetting;
use App\controller\admin\setting\AdminEditSettingController;
use App\controller\admin\setting\AdminSettingController;
use App\controller\admin\setting\AdminSettingGeneralController;
use App\controller\BlogController;
use App\controller\CarBrandController;
use App\controller\CarPageController;
use App\controller\HomePageController;
use App\controller\user\UserAuthController;
use App\controller\user\UserProfileController;
use App\core\Route;
use App\core\View;
use App\middleware\MiddlewareAdminLogin;
use Mailgun\Mailgun;

//index page
Route::get('/', [HomePageController::class, 'indexPage']);

//about us
Route::get('/about_us', function () {
    return View::Create('about_us');
});

//contact us
Route::get('/contact_us', function () {
    return View::Create('contact_us');
});
//auth user
Route::get('/register/user', [UserAuthController::class, 'show_register']);
Route::post('/register/user', [UserAuthController::class, 'register_user']);
//phone
Route::get('/user/validate/phone', [UserAuthController::class, 'validate_phone_show']);
Route::post('/user/validate/phone/number', [UserAuthController::class, 'check_validate_phone']);
//email
Route::get('/user/validate/email', [UserAuthController::class, 'validate_email_show']);
Route::get('/user/validate/email/{token}', [UserAuthController::class, 'validate_email']);
//end auth user
//forget password
Route::get('/forget/password/user', [UserAuthController::class, 'forget_password_show']);
Route::post('/forget/password/user', [UserAuthController::class, 'send_forget_password']);
Route::get('/user/reset/password/{token}', [UserAuthController::class, 'reset_password_show']);
Route::post('/user/reset/password/{token}', [UserAuthController::class, 'reset_password']);
//end forget password
//profile
Route::get('/profile/user', [UserProfileController::class, 'index']);
Route::get('/profile/user/edit', [UserProfileController::class, 'edit']);
Route::post('/profile/user/edit', [UserProfileController::class, 'update']);
Route::get('/profile/user/edit/delete/profile', [UserProfileController::class, 'delete_profile']);
Route::get('/profile/user/change/password', [UserProfileController::class, 'change_password_show']);
Route::post('/profile/user/change/password', [UserProfileController::class, 'change_password']);
Route::get('/profile/user/request/status/{id_status}', [UserProfileController::class, 'request_status_show']);
Route::get('/profile/user/request/apply/car/{id_request}/show', [UserProfileController::class, 'apply_car_show']);
Route::get('/profile/user/level/3/apply/{id_request}', [UserProfileController::class, 'apply_car_level_3']);
Route::post('/profile/user/level/3/apply/{id_request}', [UserProfileController::class, 'apply_car_level_3_store']);
//car page
Route::get('/car', [CarPageController::class, 'index']);
Route::get('/car/show/{id}', [CarPageController::class, 'show']);
Route::post('/car/show/{car_id}/complete/request', [CarPageController::class, 'complete_request_show']);
Route::post('/car/show/{car_id}/complete/request/store', [CarPageController::class, 'complete_request']);
//brand
Route::get('/car/brand/{id}', [CarBrandController::class, 'index']);
//end car page

//blog
Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/show/{id}', [BlogController::class, 'show']);
//comment blog
Route::post('/blog/show/{post_id}/comment', [BlogController::class, 'store_comment']);
//category
Route::get('/blog/category/{id_category}', [BlogController::class, 'show_category_posts']);
//end category
//end blog

//auth user
//Route::get("user/validate/phone/{number}", function ($number) {
//    $userAdapter = new UserTableAdapter();
//    if (!$userAdapter->send_validation_sms($number)) {
//        return 'شماره مورد نظر شما پیدا نشد';
//    }
//    return View::Create('user.validate_phone', ['number' => $number]);
//});
//end auth user
//admin routes
Route::get('/admin', [AdminAuthController::class, 'loginPage']);
Route::post('/admin', [AdminAuthController::class, 'login']);
//Route::middleware(MiddlewareAdminLogin::class, function () {
$prefix = '/admin/dash';
Route::get("/admin/logout", [AdminAuthController::class, 'logout']);
Route::get("$prefix", [AdminDashController::class, 'dash']);
//user dash admin
Route::get("$prefix/users/show", [AdminDashController::class, 'showUsers']);
Route::get("$prefix/users/add", [AdminDashController::class, 'addUser']);
Route::post("$prefix/users/add", [AdminDashController::class, 'addUser_by_admin']);
Route::get("$prefix/user/show/{user_id}", [AdminDashController::class, 'showUser']);
Route::post("$prefix/users/update", [AdminDashController::class, 'updateUser_by_admin']);
Route::post("$prefix/users/rest_password_send", [AdminDashController::class, 'rest_password_send']);
//end users dash admin
//category posts blog
Route::get("$prefix/posts/categorys", [AdminCategoryPostsController::class, 'index']);
Route::post("$prefix/posts/categorys", [AdminCategoryPostsController::class, 'store']);
Route::get("$prefix/posts/categorys/{category_id}/destroy", [AdminCategoryPostsController::class, 'destroy']);
Route::get("$prefix/posts/categorys/{category_id}/edit", [AdminCategoryPostsController::class, 'edit']);
Route::post("$prefix/posts/categorys/{category_id}/update", [AdminCategoryPostsController::class, 'update']);
//end category posts blog
//blog posts
Route::get("$prefix/posts", [AdminBlogPostsController::class, 'index']);
Route::get("$prefix/posts/create", [AdminBlogPostsController::class, 'create']);
Route::post("$prefix/posts", [AdminBlogPostsController::class, 'store']);
Route::get("$prefix/posts/{id}/edit", [AdminBlogPostsController::class, 'edit']);
Route::post("$prefix/posts/{id}/update", [AdminBlogPostsController::class, 'update']);
Route::post("$prefix/posts/destroy", [AdminBlogPostsController::class, 'destroy']);
Route::get("$prefix/posts/comments/{post_id}", [AdminBlogPostsController::class, 'post_comments']);

//end blog posts
////blog posts comment
Route::get("$prefix/blog/comments", [AdminBlogCommentsController::class, 'all']);
Route::get("$prefix/blog/comment/status/{status_id}", [AdminBlogCommentsController::class, 'index']);
Route::get("$prefix/comment/{comment_id}/status/{status_id}", [AdminBlogCommentsController::class, 'status_changer']);
Route::get("$prefix/blog/comment/{comment_id}", [AdminBlogCommentsController::class, 'show']);
//Route::get("$prefix/posts/create", [AdminBlogPostsController::class, 'create']);
//Route::post("$prefix/posts", [AdminBlogPostsController::class, 'store']);
//Route::get("$prefix/posts/{id}/edit", [AdminBlogPostsController::class, 'edit']);
//Route::post("$prefix/posts/{id}/update", [AdminBlogPostsController::class, 'update']);
//Route::post("$prefix/posts/destroy", [AdminBlogPostsController::class, 'destroy']);
//end blog posts comment
//brand car
Route::get("$prefix/brand", [AdminBrandCarController::class, 'index']);
Route::get("$prefix/brand/create", [AdminBrandCarController::class, 'create']);
Route::post("$prefix/brand", [AdminBrandCarController::class, 'store']);
Route::get("$prefix/brand/{id}/edit", [AdminBrandCarController::class, 'edit']);
Route::post("$prefix/brand/{id}/update", [AdminBrandCarController::class, 'update']);
Route::post("$prefix/brand/destroy", [AdminBrandCarController::class, 'destroy']);
//end brand car

//    conditions sell car
Route::get("$prefix/conditions", [AdminConditionCarSellController::class, 'index']);
Route::get("$prefix/conditions/create", [AdminConditionCarSellController::class, 'create']);
Route::post("$prefix/conditions", [AdminConditionCarSellController::class, 'store']);
Route::get("$prefix/conditions/{id}/edit", [AdminConditionCarSellController::class, 'edit']);
Route::post("$prefix/conditions/{id}/update", [AdminConditionCarSellController::class, 'update']);
Route::post("$prefix/conditions/destroy", [AdminConditionCarSellController::class, 'destroy']);
//    end conditions sell car

//car admin
Route::get("$prefix/cars", [AdminCarController::class, 'index']);
Route::get("$prefix/cars/create", [AdminCarController::class, 'create']);
Route::post("$prefix/cars", [AdminCarController::class, 'store']);
Route::get("$prefix/cars/{id}/edit", [AdminCarController::class, 'edit']);
Route::post("$prefix/cars/{id}/update", [AdminCarController::class, 'update']);
Route::post("$prefix/cars/destroy", [AdminCarController::class, 'destroy']);
//end car admin

//apply car admin
Route::get("$prefix/apply/car", [AdminApplyCarController::class, 'index']);
Route::get("$prefix/apply/car/status/show/{status_id}", [AdminApplyCarController::class, 'show_status']);
Route::get("$prefix/set/status/{status_id}/request/{request_id}", [AdminApplyCarController::class, 'set_status']);
Route::get("$prefix/apply/car/{request_id}/show", [AdminApplyCarController::class, 'show']);

Route::get("$prefix/level/3/confirm/{apply_id}", [AdminApplyCarController::class, 'show_level3']);
//end apply car admin
//gest
Route::get("$prefix/gests/add/{apply_id}/apply_id", [AdminGestController::class, 'add_apply']);
Route::get("$prefix/gests", [AdminGestController::class, 'index']);
//end gest
//view admin
Route::get("$prefix/view/status", [AdminDashController::class, 'show_view']);
//end view

//setting
Route::get("$prefix/setting", [AdminSettingController::class, 'index']);
//setting general
Route::get("$prefix/setting/general", [AdminSettingGeneralController::class, 'index']);
Route::post("$prefix/setting/general/update", [AdminSettingGeneralController::class, 'update']);
//setting about us
Route::get("$prefix/setting/about_us", [AdminAboutUsSetting::class, 'index']);
Route::post("$prefix/setting/about_us", [AdminAboutUsSetting::class, 'update']);
//end about us
////setting contact us
Route::get("$prefix/setting/contact_us", [AdminContactUsSetting::class, 'index']);
Route::post("$prefix/setting/contact_us", [AdminContactUsSetting::class, 'update']);
//end contact us
//setting edit admin
Route::get("$prefix/setting/edit/admin", [AdminEditSettingController::class, 'edit']);
Route::post("$prefix/setting/edit/admin", [AdminEditSettingController::class, 'update']);
//end setting edit admin
//});

//end admin routes