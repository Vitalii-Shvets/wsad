<?php

include_once ROOT . '/models/RequestModel.php';
include_once ROOT . '/components/View.php';
include_once ROOT . '/services/PictureService.php';
include_once ROOT . '/services/ValidationService.php';
include_once ROOT . '/models/RequestModel.php';


class RequestController
{

    public function actionIndex()
    {
        $w =
           ['ww' => 'w213w']
        ;
        echo View::render('layout/layout_request', $w);
    }

    public function actionDelete($id)
    {
        RequestModel::deleteXML($id);
        return true;
    }

    public function actionCreate()
    {
        RequestModel::insertXML($_POST);
   /*     var_dump($_POST);
        if ($_FILES['picture']) {
            $check = PictureService::canUpload($_FILES['picture']);

            if ($check === true) {
                PictureService::makeUpload($_FILES['picture']);
            } else {
                $check;
            }
        }*/

        return true;
    }
}
