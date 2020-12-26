<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\imagine\Image;
use Imagine\Image\Box;

class UploadFile extends Component {

    public function uploadById($file, $id, $location) {
        $targetFolder = \yii::$app->basePath . '/../uploads/' . $location . '/' . $id . '/';
        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }
        if ($file->saveAs($targetFolder . $id . '.' . $file->extension)) {
            chmod($targetFolder . $id . '.' . $file->extension, 0777);
            return true;
        } else {
            return false;
        }
    }

    public function upload($file, $name, $type) {
        if (\yii::$app->basePath . '/../uploads') {
            chmod(\yii::$app->basePath . '/../uploads', 0777);
            if (!is_dir(\yii::$app->basePath . '/../uploads/' . $type . '/')) {
                mkdir(\yii::$app->basePath . '/../uploads/' . $type . '/');
                chmod(\yii::$app->basePath . '/../uploads/' . $type . '/', 0777);
            }
            if ($file->saveAs(\yii::$app->basePath . '/../uploads/' . $type . '/' . $name . '.' . $file->extension)) {
                chmod(\yii::$app->basePath . '/../uploads/' . $type . '/' . $name . '.' . $file->extension, 0777);
            }
            return true;
        }
    }

    public function getBannerPath($id, $extension, $folrder) {
        if ($id) {
            $path = dirname(yii\helpers\Url::base()) . '\uploads\\' . $folrder . '\\' . $id . '\\' . $id . '.' . $extension;
        } else {
            $path = dirname(yii\helpers\Url::base()) . '\uploads\no_image.jpg';
        }
        return $path;
    }

    public function getBannerPath1($name, $extension, $folder) {
        if ($name) {
            $path = dirname(yii\helpers\Url::base()) . '\uploads\\' . $folder . '\\' . $name . '.' . $extension;
        } else {
            $path = dirname(yii\helpers\Url::base()) . '\uploads\no_image.jpg';
        }
        return $path;
    }

    public function getBannerPath2($id, $name, $extension, $folder) {
        if ($id) {
            $path = dirname(yii\helpers\Url::base()) . '\uploads\\' . $folder . '\\' . $id . '\\' . $name . '.' . $extension;
        } else {
            $path = dirname(yii\helpers\Url::base()) . '\uploads\no_image.jpg';
        }
        return $path;
    }

    public function getBannerPath3($id, $extension, $folrder) {
        if ($id) {
            $path = dirname(yii\helpers\Url::base()) . '\uploads\\' . $folrder . '\\' . $id . '\\' . $id . '.' . $extension;
        } else {
            $path = dirname(yii\helpers\Url::base()) . '\uploads\no_image.jpg';
        }
        return $path;
    }

    public function getCurrencyPath($id, $extension, $type) {
        $path = dirname(yii\helpers\Url::base()) . "\uploads\currency\\" . $id . "." . $extension;
        return $path;
    }

    public function uploadMultipleImage($uploadfile, $id, $foldername = false, $dimensions = array()) {
        if ($foldername) {
            $folder = $this->folderName(0, 1000, $id) . '/';
        } else {
            $folder = "";
        }
        foreach ($uploadfile as $upload) {
            if (isset($upload)) {
                if (Yii::$app->basePath . '/../uploads/products') {
                    chmod(Yii::$app->basePath . '/../uploads/products', 0777);
                    if ($foldername) {
                        if (!is_dir(Yii::$app->basePath . '/../uploads/products/' . $folder))
                            mkdir(Yii::$app->basePath . '/../uploads/products/' . $folder);
                        chmod(Yii::$app->basePath . '/../uploads/products/' . $folder . '/', 0777);

                        if (!is_dir(Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id))
                            mkdir(Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id);
                        chmod(Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/', 0777);

                        if (!is_dir(Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/gallery/'))
                            mkdir(Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/gallery/');
                        chmod(Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/gallery/', 0777);
                    }
                    $path = Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/' . '/gallery/';
                    $picname = $this->fileExists($path, $upload->name, $upload, 1);
                    if ($upload->saveAs(Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/gallery/' . $picname)) {
                        chmod(Yii::$app->basePath . '/../uploads/products/' . $folder . $id . '/gallery/' . $picname, 0777);
                        // $this->WaterMark(Yii::$app->basePath . '/../uploads/products/' . $folder . $id . '/gallery/' . $picname, '/../images/watermark.png');
                        $file = Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/gallery/' . $picname;
                        if (!empty($dimensions)) {
                            foreach ($dimensions as $dimension) {
                                if (!is_dir(Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/' . '/gallery/' . $dimension['name']))
                                    mkdir(Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/' . '/gallery/' . $dimension['name']);
                                $path = Yii::$app->basePath . '/../uploads/products/' . $folder . '/' . $id . '/' . '/gallery/' . $dimension['name'];
                                $this->ResizeMultiple($file, $dimension['width'], $dimension['height'], $path, $picname);
                            }
                        }
                    }
                }
            }
        }
    }

    public function uploadByPdf($uploadfile, $id, $foldername = '', $dimension = array()) {
        if ($uploadfile != "") {

            $path = Yii::$app->basePath . '/../uploads/' . $foldername . '/' . $id . '/';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if ($uploadfile->saveAs($path . $uploadfile->name)) {
                $path1 = $path . $uploadfile->name;
                $this->ResizeMultiple($uploadfile, $dimension['width'], $dimension['height'], $path1);
            }
        }
    }

    public function ResizeMultiple($file, $width, $height, $path) {

        Image::getImagine()->open($path)
                ->thumbnail(new Box($width, $height))
                ->save($path);
    }

    public function folderName($min, $max, $id) {
        if ($id > $min && $id <= $max) {
            return $max;
        } else {
            $xy = $this->folderName($min + 1000, $max + 1000, $id);
            return $xy;
        }
    }

    public function fileExists($path, $name, $file, $sufix) {

        if (file_exists($path . $name)) {
            $name = basename($path . $file->name, '.' . $file->extensionName) . '_' . $sufix . '.' . $file->extensionName;
            return $this->fileExists($path, $name, $file, $sufix + 1);
        } else {
            return $name;
        }
    }

    public function getPackageImage($type, $model, $image) {
        $folder = $this->folderName(0, 1000, $model->id) . '/';
        if ($type == "gallery") {
            $path = ((yii\helpers\Url::base())) . '/../uploads/products/' . $folder . '/' . $model->id . '/gallery/' . $image;
        } else {
            $path = ((yii\helpers\Url::base())) . '/../uploads/no_image.jpg';
        }
        return $path;
    }

    public function getSliderImage($image_name, $model) {

        $path = dirname(yii\helpers\Url::base()) . '\uploads\\sliders\\' . $image_name;

        return $path;
    }

    public function uploadBlogImage($uploadfile, $id, $foldername = false, $dimensions = array()) {
        if ($uploadfile != "") {
            if (Yii::$app->basePath . '/../uploads/blog') {
                chmod(Yii::$app->basePath . '/../uploads/blog', 0777);

                if (!is_dir(Yii::$app->basePath . '/../uploads/blog/' . $id))
                    mkdir(Yii::$app->basePath . '/../uploads/blog/' . $id);
                chmod(Yii::$app->basePath . '/../uploads/blog/' . $id . '/', 0777);

                $file = Yii::$app->basePath . '/../uploads/blog/' . $uploadfile;
                $path = Yii::$app->basePath . '/../uploads/blog/' . $id . '/';
                $exp_value = explode('.', $uploadfile);
                $extension = $exp_value[1];
                $from = $file;
                $dest = $path . $id . '.' . $extension;
                if (file_exists($from)) {
                    copy($from, $dest);
                }
            }
        }
    }

    public function uploadMerchantgallery($uploadfile, $id, $foldername = false) {
        if ($foldername) {
            $folder = $this->folderName(0, 1000, $id) . '/';
        } else {
            $folder = "";
        }
        foreach ($uploadfile as $upload) {
            if (isset($upload)) {
                if (Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image') {
                    chmod(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image', 0777);
                    if ($foldername) {
                        if (!is_dir(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder))
                            mkdir(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder);
                        chmod(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/', 0777);

                        if (!is_dir(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/' . $id))
                            mkdir(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/' . $id);
                        chmod(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/' . $id . '/', 0777);

                        if (!is_dir(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/' . $id . '/gallery/'))
                            mkdir(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/' . $id . '/gallery/');
                        chmod(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/' . $id . '/gallery/', 0777);
                    }
                    $path = Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/' . $id . '/' . '/gallery/';

                    $picname = $this->fileExists($path, $upload->name, $upload, 1);

                    if ($upload->saveAs(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/' . $id . '/gallery/' . $picname)) {
                        chmod(Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . $id . '/gallery/' . $picname, 0777);
                        $file = Yii::$app->params['osoleDirPath'] . '/osole/uploads/seller_profile_image/' . $folder . '/' . $id . '/gallery/' . $picname;
                    }
                }
            }
        }
    }

    public function getMerchantGallery($type, $model, $image) {
        $folder = $this->folderName(0, 1000, $model->id) . '/';
        if ($type == "gallery") {
            $path = Yii::$app->params['osolePath'] . 'uploads/seller_profile_image/' . $folder . $model->id . '/gallery/' . $image;
        } else {
            $path = Yii::$app->params['osoleDirPath'] . '/osole/uploads/no_image.jpg';
        }
        return $path;
    }

}
