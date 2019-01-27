<?php
/**
 * Created by PhpStorm.
 * User: chanbigbig
 * Email: chanbigbig@163.com
 * Date: 2018/8/16
 * Time: 下午3:54
 */

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

/**
 * 百度编辑器
 * Class uEditor
 * @package App\Admin\Extensions\Form
 */
class uEditor extends Field
{
    // 定义视图
    protected $view = 'admin.uEditor';

    // css资源
    protected static $css = [];

    // js资源
    protected static $js = [
        '/laravel-u-editor/ueditor.config.js',
        '/laravel-u-editor/ueditor.all.js',
        '/laravel-u-editor/lang/zh-cn/zh-cn.js'
    ];

    public function render()
    {
        $this->script = <<<EOT
        //解决第二次进入加载不出来的问题
        UE.delEditor("ueditor");
        // 默认id是ueditor
        var ue = UE.getEditor('ueditor', {
            // 自定义工具栏
            toolbars: [
                [
                'bold', 'italic', 'underline','fontsize',
                'paragraph','rowspacingtop','rowspacingbottom',
                'strikethrough', 'blockquote', 'insertunorderedlist',
                'insertorderedlist', 'justifyleft', 'justifycenter', 
                'justifyright', 'link',
                'formatmatch',
                'removeformat', //清除格式 
                'time', //时间 
                'date', //日期
                'emotion', 
                'fontborder',
                'forecolor',
                'backcolor',
                'horizontal',
                'simpleupload',
                'insertimage',
                'insertvideo',
                'inserttable',
                'autotypeset',
                'charts',
                'fullscreen'
                ]
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode: true,
            wordCount: false,
            imagePopup: false,
            autotypeset: {indent: true, imageBlockLine: 'center'}
        }); 
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });

EOT;
        return parent::render();
    }
}