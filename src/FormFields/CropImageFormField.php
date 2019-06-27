<?php

namespace MdsDigital\CropImageField\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class CropImageFormField extends AbstractHandler
{
    protected $codename = 'crop_image';
    protected $name = 'Crop Image';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        $width = 0;
        $height = 0;

        if( empty($row->details) || empty($row->details->sizeImage) || empty($row->details->sizeImage->height) || empty($row->details->sizeImage->width) ) {
            return '<b>'.__('cropimage::dimensions_required').'</b>';
        }

        $width = \intval($row->details->sizeImage->width);
        $height = \intval($row->details->sizeImage->height);

        $public_path = '';

        if( !empty($row->details) && !empty($row->details->folderImages) ) {
            $public_path = $row->details->folderImages;
        }


        return view('cropimagecropimage::index', [
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
}
