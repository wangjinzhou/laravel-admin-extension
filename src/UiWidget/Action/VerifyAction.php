<?php
/**
 * 单个状态更新操作
 *  $grid->actions(function ($actions) {
        $actions->disableEdit();
        $is_read = $actions->row->is_read;
        if (!$is_read) {
            $actions->prepend(new RecruitVerifyAction($actions->getKey(), '/admin/contact/primary_id/is_verify', '标记为已读'));
        }
    });
 */
namespace Howous\UiWidget\Action;

use Encore\Admin\Admin;


class VerifyAction
{
    protected $row_id;
    protected $verify_url;
    protected $icon_title;

    public function __construct(int $id, $verify_url,$icon_title)
    {
        $this->row_id     = $id;
        $this->verify_url = $verify_url;
        $this->icon_title = $icon_title;
    }

    protected function script()
    {
        return <<<SCRIPT
    $('.recruit-check').on('click',function() {
        var id = $(this).data('id');
        $.ajax({
            method:'post',
            url:"{$this->verify_url}".replace('primary_id',id),
            data:{
                _method:'PATCH',
                _token:LA.token
            },
            success:function (data) {
                $.pjax.reload('#pjax-container');
                if (typeof data === 'object') {
                    if (data.status) {
                        swal(data.message, '', 'success');
                    } else {
                        swal(data.message, '', 'error');
                    }
                }
            }
        });
    });
SCRIPT;

    }

    public function render()
    {
        Admin::script($this->script());

        return '<a href="javascript:void(0);" class="fa fa-check-circle-o recruit-check" title="'.$this->icon_title.'" data-id="' . $this->row_id . '"></a>';
    }


    public function __toString()
    {
        return $this->render();
    }
}
