<?php

namespace Howous\UiWidget\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/30
 * Time: 17:12
 *
 * 批量操作 PATCH方法
 * new BatchVerifyAction('/admin/company-application/primary_id/is_verify')
 * primary_id 为主键id
 *
 */
class BatchVerifyAction extends BatchAction
{
    protected $verify_url;

    public function __construct($verify_url)
    {
        $this->verify_url = $verify_url;
    }

    public function script()
    {
        return <<<SCRIPT
      $('{$this->getElementClass()}').on('click',function(){
           var ids = selectedRows().join(','); 
           if(ids == ''){
                toastr.error('请选择数据！');
                return false;
           }
           $.ajax({
                method:'post',
                url:"{$this->verify_url}".replace('primary_id',ids),
                data:{
                    _method:'PATCH',
                     _token:LA.token
                },
                success:function(data) {
                    $.pjax.reload('#pjax-container');
                    toastr.success('操作成功');
                }
           });
      });
SCRIPT;

    }
}
