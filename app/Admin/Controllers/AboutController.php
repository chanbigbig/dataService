<?php

namespace App\Admin\Controllers;

use App\Models\About;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class AboutController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('关于我们')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
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
     *
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
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('新建')
            ->description('')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new About);

        $grid->id('Id');
//        $states = [
//            'on' => ['value' => 1, 'text' => '显示', 'color' => 'primary'],
//            'off' => ['value' => 0, 'text' => '不显示', 'color' => 'default'],
//        ];
//        $grid->is_show_homepage('是否显示在导航')->switch($states);
        $grid->title('标题');
        $grid->img_url('图片')->image(['width' => 250, 'height' => 250]);
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

        $grid->disableExport();
        $grid->disableRowSelector();
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
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(About::findOrFail($id));

        $show->id('Id');
        $show->is_show_homepage('Is show homepage');
        $show->title('Title');
        $show->content('Content');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new About);

//        $states = [
//            'on' => ['value' => 1, 'text' => '显示', 'color' => 'primary'],
//            'off' => ['value' => 0, 'text' => '不显示', 'color' => 'default'],
//        ];
//        $form->switch('is_show_homepage', '是否显示在导航')
//            ->states($states)->default(0);

        $form->image('img_url', '图片')
            ->uniqueName()
            ->setQiniuDirectory('about')
            ->rules('image');

        $form->text('title', '标题');
        $form->ueditor('content', '内容')->help('编辑后提示"本地保存成功",方可点击提交表单。');

        $form->tools(function (Form\Tools $tools)
        {
            $tools->disableView();
        });
        return $form;
    }
}
