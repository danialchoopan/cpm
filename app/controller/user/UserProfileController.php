<?php


namespace App\controller\user;


use App\core\File;
use App\core\View;
use App\database\adapter\ApplyCarAdapter;
use App\database\adapter\GestAdapter;
use App\database\adapter\Level3ApplyAdapter;
use App\database\adapter\PhotoAdapter;
use App\database\adapter\UserTableAdapter;

class UserProfileController
{

    public function index()
    {
        $gest_adapter = new GestAdapter();
        $apply_adapter = new ApplyCarAdapter();
        $apply_id = $apply_adapter->show_apply1_car_by_user_id(authUser()['id'])['id'];
        $gest = $gest_adapter->find_by_apply_id($apply_id);
        if ($gest && $apply_id) {
            $apply_model = $apply_adapter->find($apply_id);
            return View::Create('user.profile.index',
                [
                    'gest' => $gest,
                    'apply_model' => $apply_model
                ]);
        } else {
            return View::Create('user.profile.index');
        }
    }

    public function change_password_show()
    {
        return View::Create('user.profile.change_password');
    }

    public function delete_profile()
    {
        $adapter_photo = new PhotoAdapter();
        $user_adapter = new UserTableAdapter();
        //delete old img
        $photo_id = authUser()['photo_id'];
        $old_name = $adapter_photo->find($photo_id)['name'];
        $dir = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'user_img' . DIRECTORY_SEPARATOR . $old_name;
        unlink($dir);
        $adapter_photo->delete($photo_id);
        //end delete img

        //update img
        $user_adapter->update_profile_photo(0);
        //end update img

        set_massage('پروفایل شما حذف شد', 'success');
        redirect(route('profile/user'));
    }

    public function change_password()
    {
        $old_password = $_POST['old_password'];
        $password = $_POST['password'];
        $re_password = $_POST['re_password'];
        $user_adapter = new UserTableAdapter();
        if ($password == $re_password) {
            $result_change_password = $user_adapter->change_password_user($old_password, $password);
            set_massage($result_change_password['msg'], $result_change_password['status']);
            if ($result_change_password['status'] == 'success') {
                redirect(route('profile/user'));
            } else {
                redirect(route('profile/user/change/password'));
            }
        } else {
            set_massage('رمز عبور با تکرار آن برابر نیست !', 'warning');
            redirect(route('profile/user/change/password'));
        }
    }

    public function edit()
    {
        return View::Create('user.profile.edit');
    }

    public function update()
    {
        $user_adapter = new UserTableAdapter();
        $adapter_photo = new PhotoAdapter();
        $file_photo = new File('photo_file');
        if ($file_photo->check_file()) {
            if (authUser()['photo_id'] != 0) {
                //delete old img
                $photo_id = authUser()['photo_id'];
                $old_name = $adapter_photo->find($photo_id)['name'];
                $dir = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'user_img' . DIRECTORY_SEPARATOR . $old_name;
                unlink($dir);
                $adapter_photo->delete($photo_id);
                //end delete img

                //update img
                $file_name = $file_photo->get_file_name();
                $new_photo_id = $adapter_photo->insert($file_name)['id'];
                $file_photo->storeAssetsImg();
                $user_adapter->update_profile_photo($new_photo_id);
                //end update img
            } else {
                $file_name = $file_photo->get_file_name();
                $new_photo_id = $adapter_photo->insert($file_name)['id'];
                $file_photo->storeAssetsImg();
                $user_adapter->update_profile_photo($new_photo_id);
            }
            set_massage('پروفایل مورد نظر شما با موفیت آپلود شد', 'success');
            redirect(route('profile/user'));
        } else {
            set_massage('لطفا سایر و فرمت و نوع فایل را برسی کنید فایل مورد نظر باید عکس باشید و کمتر از 512KB', 'warning');
            redirect(route('profile/user/edit'));
        }
    }

    public function request_status_show($id_status)
    {
        $apply_car_adapter = new ApplyCarAdapter();
        return View::Create(
            'user.profile.request', [
            'apply_cars' => $apply_car_adapter->status($id_status),
            'id_status' => $id_status
        ]);
    }

    public function apply_car_show($id_request)
    {
        $apply_car_adapter = new ApplyCarAdapter();
        return View::Create(
            'user.profile.show_apply_car', [
            'apply_car' => $apply_car_adapter->find($id_request)
        ]);
    }

    public function apply_car_level_3($id_request)
    {
        return View::Create(
            'user.profile.level3', ['id_request' => $id_request]);
    }

    public function apply_car_level_3_store($id_request)
    {
        $user_id = authUser()['id'];
        $img_card_meli = new File('card_meli_photo');
        $img_shesname_photo = new File('shesname_photo');
        $img_check_photo = new File('check_photo');
        $id_card_meli_img = 0;
        $id_shesname_photo_img = 0;
        $id_check_photo_img = 0;
        $adapter_photo = new PhotoAdapter();
        if ($img_card_meli->check_file() &&
            $img_check_photo->check_file() &&
            $img_shesname_photo->check_file()) {

            $file_name_card_meli = $img_card_meli->get_file_name();
            $id_card_meli_img = $adapter_photo->insert($file_name_card_meli)['id'];
            $img_card_meli->storeAssetsImg();

            $file_name_check = $img_check_photo->get_file_name();
            $id_check_photo_img = $adapter_photo->insert($file_name_check)['id'];
            $img_check_photo->storeAssetsImg();

            $file_name_shenasname = $img_shesname_photo->get_file_name();
            $id_shesname_photo_img = $adapter_photo->insert($file_name_shenasname)['id'];
            $img_shesname_photo->storeAssetsImg();

            $level3_adapter = new Level3ApplyAdapter();
            $level3_adapter->insert($id_request, $id_card_meli_img, $id_shesname_photo_img, $id_check_photo_img);
            set_massage("تکمیل مدارک شما ارسال پس از تایید اقساط برای شما در قسمت پروفایل نمایش داده خواهد شد", "success", true, true);
            return redirect(route(""));
        } else {
            set_massage('لطفا سایر و فرمت و نوع فایل را برسی کنید فایل مورد نظر باید عکس باشید و کمتر از 2M', 'warning');
            return redirect(route("profile/user/level/3/apply/$id_request"));
        }
    }
}