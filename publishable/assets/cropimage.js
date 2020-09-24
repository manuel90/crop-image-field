window.addEventListener('DOMContentLoaded',function(){
    (function($) {

        var ajaxUplodaImage = function(input, data, finishedUpload) {

            var formData = new FormData();
            if(formData instanceof FormData) {

                var fi = typeof(input) == 'string' ? document.getElementById(input) : input;

                formData.append('ajax', 'yes');
                formData.append('image', fi.files[0]);

                if( data.pFolder ) {
                    formData.append('public_path', data.pFolder);
                }

                $.ajax({
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: data.ajaxUrl,
                    type: 'post',
                    dataType: 'json',
                    data: formData
                }).done(finishedUpload).fail(function(error){
                    console.error(error);
                });
            } else {
                alert('Your browser not support this feature, please contact you webmaster.');
            }
        };

        var onCropImage = function(e) {
            e.preventDefault();

            var _this = $(e.currentTarget);

            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var infoImage = _this.data('infoimage');

            var croppedData = {
                x: _this.data('x'),
                y: _this.data('y'),
                height: _this.data('height'),
                width: _this.data('width'),
                originImageName: infoImage.name,
                upload_path: infoImage.path,
                createMode: 'true',
                _token: csrf_token,
            };

            var $container = _this.parent().parent();
            var $wrapCrop = $container.find('.formfield-crop-container').first();

            var cropUrl = _this.data('cropurl');

            $.post(cropUrl, croppedData, function(cropResult){

                if( cropResult.success ){
                    toastr.success(cropResult.message);

                    $wrapCrop.addClass('nocropping');

                    $wrapCrop.html("");
                    var $image = null;

                    if( cropResult.newImage && typeof(cropResult.newImage.url) == "string" ) {
                        $image =  $('<img>').attr('src',cropResult.newImage.url);
                        $container.find('.el-input-store').first().val( infoImage.path+'/'+cropResult.newImage.name );
                    } else {
                        $image =  $('<img>').attr('src',infoImage.full);
                        $container.find('.el-input-store').first().val( infoImage.path+'/'+infoImage.name );
                    }

                    $image.appendTo( $wrapCrop );

                    _this.hide();
                } else {
                    toastr.error(cropResult.error, "Whoops!");
                }
            });

        };

        var iniCropImage = function(dataImage,height,width,$container) {

            var $wrapCrop = $container.find('.formfield-crop-container').first();
            $wrapCrop.show();
            $wrapCrop.removeClass('nocropping');
            $wrapCrop.html("");

            var $image = $('<img>').attr('src',dataImage.full);

            $image.appendTo( $wrapCrop );

            width = parseInt( width );
            height = parseInt( height );

            var $cropBtn = $container.find('.btn-run-crop').first();

            new Cropper($image.get(0), {
                minCropBoxWidth: width,
                minCropBoxHeight: height,
                minContainerWidth: width,
                minContainerHeight: height,
                aspectRatio: width / height,
                crop(event) {

                   $cropBtn.data('x', Math.floor( event.detail.x ));
                   $cropBtn.data('y', Math.floor( event.detail.y ));
                   $cropBtn.data('height', Math.floor( event.detail.height ));
                   $cropBtn.data('width', Math.floor( event.detail.width ));
                },
            });

            $cropBtn.data('infoimage',dataImage);
            $cropBtn.show();

        };

        var loadImageCrop = function(e) {
            e.preventDefault();
            var input = e.currentTarget;

            if (input.files && input.files[0]) {

                ajaxUplodaImage( input, e.data,  function(result){
                    iniCropImage(
                        result.data,
                        e.data.imageHeight,
                        e.data.imageWidth,
                        e.data.container
                    );
                });


            }
        };

        $('.input-file-crop-image').on('click',function(e){
            e.preventDefault();
            var _this = $(e.currentTarget);

            var $input = $( _this.attr('href') );
            var $previewName = $( _this.data('preview') );

            var $preview = _this.parent().find('img').length > 0 ? _this.parent().find('img').first() : null;

            $input.off('change',loadImageCrop).on('change',{
                previewName: $previewName,
                preview: $preview,
                ajaxUrl: _this.data('ajaxurl'),
                imageHeight: _this.data('imageheight'),
                imageWidth: _this.data('imagewidth'),
                pFolder: _this.data('pfolder'),
                container: _this.parent().parent(),
            },loadImageCrop);

            $input.trigger('click');
        });

        $('.btn-run-crop').on('click',onCropImage);

    })(jQuery);
}, false);
