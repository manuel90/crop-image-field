<?php
if( $view == 'browse' ) {
    $dataTypeContent = $data;
}
\Manuel90\CropImageField\FormFields\CropImageFormField::myRender(
    $row, $dataType, $dataTypeContent, $options,
    $view, $action
); ?>
