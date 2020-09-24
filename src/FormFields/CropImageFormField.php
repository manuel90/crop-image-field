<?php

namespace Manuel90\CropImageField\FormFields;


use TCG\Voyager\FormFields\AbstractHandler;

class CropImageFormField extends AbstractHandler
{
    protected $codename = 'crop_image';
    protected $name = 'Crop Image';
    public static $addedScript = false;

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return self::editContent($row, $dataType, $dataTypeContent, $options);
    }

    public static function editContent($row, $dataType, $dataTypeContent, $options)
    {
        $width = 0;
        $height = 0;

        if( empty($row->details) || empty($row->details->sizeImage) || empty($row->details->sizeImage->height) || empty($row->details->sizeImage->width) ) {
            return '<b>'.__('cropimage::general.dimensions_required').'</b>';
        }

        $width = \intval($row->details->sizeImage->width);
        $height = \intval($row->details->sizeImage->height);

        $public_path = '';

        if( !empty($row->details) && !empty($row->details->folderImages) ) {
            $public_path = $row->details->folderImages;
        }


        return view('cropimage::index', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'item' => $dataTypeContent,
            'imageHeight' => $height,
            'imageWidth' => $width,
            'accept' => !empty($row->details) && isset($row->details->accept) && $row->details->accept != '' ? $row->details->accept : '',
            'public_path' => $public_path
        ]);
    }

    public static function myRender($row, $dataType, $dataTypeContent, $options, $view = null, $action = null, $data = null) {
        switch ($view) {
            case 'browse':
            case 'read':
                echo view('cropimage::browse', [
                    'row' => $row,
                    'options' => $options,
                    'dataType' => $dataType,
                    'dataTypeContent' => $dataTypeContent,
                ]);
                break;
            case 'edit':
            default:
                echo self::editContent($row, $dataType, $dataTypeContent, $options);
                break;
        }
    }
}
