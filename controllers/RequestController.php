<?php

include_once ROOT . '/models/RequestModel.php';
include_once ROOT . '/components/View.php';
include_once ROOT . '/services/PictureService.php';
include_once ROOT . '/services/ValidationService.php';
include_once ROOT . '/models/RequestModel.php';

class RequestController
{
    public function actionIndex($name = null, $order = null)
    {
        var_dump(RequestModel::getXML($name, $order));

        // echo View::render('layout/layout_request');
    }

    public function actionDelete($id)
    {
        RequestModel::deleteXML($id);
        return true;
    }

    public function actionCreate()
    {
        $post = $_POST;
        if ($_FILES['picture']) {
            $check = PictureService::canUpload($_FILES['picture']);
            if ($check === true) {
                $picture = PictureService::makeUpload($_FILES['picture']);
                $post += ['picture' => $picture];
            } else {
                echo $check;
                return true;
            }
        }

        $check = ValidationService::validationRequire($_POST['fname']);
        if ($check !== true) {
            echo $check;
            return true;
        }

        $check = ValidationService:: validationEmail($_POST['email']);
        if ($check !== true) {
            echo $check;
            return true;
        }

        $check = ValidationService:: validationPhone($_POST['tel']);
        if ($check !== true) {
            echo $check;
            return true;
        }

        RequestModel::insertXML($post);
        return true;
    }
}
