<?php

namespace Howous\UiWidget\Form\Field;

use Encore\Admin\Form\Field;

/**
 * Created by PhpStorm.
 * User: M
 * Date: 2018/1/31
 * Time: 下午12:02
 */
class TinyMCE extends Field
{
    public static $js = [
        '/vendor/howous-admin-extension/tinymce/tinymce.min.js',
    ];

    protected $view = 'admin_ext::form.field.tinymce';

    public function render()
    {
        $name = $this->getElementClass();
        if (is_array($name)) {
            $name = end($name);
        }

        $selector = "textarea.{$name}";

        $url = admin_url('/upload/uploadImg');

        $token = csrf_token();

        $app_url = config('APP_URL');

        $this->script = <<<SCRIPT
        tinymce.init({ selector:'{$selector}',
        menu:{},
        min_width:800,
        min_height:500,
        resize:false,
          toolbar: 'code | undo redo | cut copy paste | bold italic underline strikethrough | formatselect | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify alignnone | outdent indent blockquote | removeformat  subscript superscript |insert hr | image',
           plugins: 'image code',
           images_upload_url: '',
           images_upload_base_path:'',
            image_dimensions:false,
            
            images_upload_handler: function (blobInfo, success, failure) {
    var xhr, formData;

    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', '{$url}');
    
    xhr.onload = function() {
      var json;

      if (xhr.status !== 200) {
        failure('HTTP Error: ' + xhr.status);
        return;
      }

      json = JSON.parse(xhr.responseText);

      if (!json || typeof json.location !== 'string') {
        failure('Invalid JSON: ' + xhr.responseText);
        return;
      }
      
     success(json.location);
    };

    formData = new FormData();
    formData.append('_token','{$token}');
    formData.append('wang-editor-image-file', blobInfo.blob(), blobInfo.filename());

    xhr.send(formData);
  }
            
         });

SCRIPT;

        return parent::render();
    }
}

