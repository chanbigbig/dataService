<?php

namespace App\Admin\Controllers;

use App\Models\HomeShowMedia;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class HomeShowMediaController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('首页媒体视频')
            ->description('')
            ->body($this->grid());
    }

    /**
     * Show interface.
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑')
            ->description('')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('新建')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HomeShowMedia);

        $grid->id('Id');
        $grid->url('视频');
        $grid->img_url('视频封面')->image(['width' => 250, 'height' => 250]);
        $grid->problem('问题');
        $grid->show_media_url('媒体图片')->image();
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->tools(function (Grid\Tools $tools)
        {
            $tools->disableBatchActions();
        });

        $grid->actions(function (Grid\Displayers\Actions $actions)
        {
            $actions->disableView();
        });
        return $grid;
    }

    /**
     * Make a show builder.
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(HomeShowMedia::findOrFail($id));

        $show->id('Id');
        $show->url('Url');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->img_url('Img url');

        return $show;
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HomeShowMedia);
        $form->image('show_media_url', '媒体图片')
            ->uniqueName()
            ->setQiniuDirectory('home_media_image')
            ->rules('image');
        $form->textarea('problem');
        $form->url('url', '视频地址');
        $form->image('img_url', '视频封面')
            ->uniqueName()
            ->setQiniuDirectory('home_media_image')
            ->rules('image')
            ->help('如果手动设置就使用该图片，否则使用视频第一帧作为封面，');
        $form->tools(function (Form\Tools $tools)
        {
            $tools->disableView();
        });
        return $form;
    }
}
