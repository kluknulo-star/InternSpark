<?php

namespace app\Users\Services\users;
use app\Core\Helpers\UserHelper;
use app\Users\Models\UserModel;

class UsersEditService
{


    public function getUserFromId($id)
    {
        return UserHelper::findUserFromId($id);
    }
    public function getUserInSystem()
    {
        return UserHelper::findUser($_SESSION["uid"]);
    }

    public function editUser(int $id,string $nameFirst,string $email,int $roleId,string $password = "") : bool
    {
        return UserModel::updateUser($id, $nameFirst, $email, $roleId, $password);
    }

    public function checkImage($target_file, $imageFileType, $target_dir)
    {

        if (file_exists($target_file)) {
            $_SESSION["error"] = "file_exist";
            return false;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $_SESSION["error"] = "file_large";
            return false;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $_SESSION["error"] = "file_incorrect";
            return false;
        }


        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $_SESSION["success"] = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            $userInSystem = UserHelper::findUser($_SESSION["uid"]);
            if ($userInSystem->getAvatar()) {
                unlink($target_dir . $userInSystem->getAvatar());
            }
            return true;
        } else {
            $_SESSION["error"] = "Sorry, there was an error uploading your file.";
            return false;
        }

    }
}

