<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CourseController extends Controller
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
            ->header('项目介绍')
            ->description('列表')
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
            ->description('')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Course);

        $grid->id('Id');
        $grid->title('标题');
        $grid->img_url('图片')->lightbox();
        $grid->summary('摘要')->limit(15);
        $states = [
            'on' => ['value' => 1, 'text' => '显示', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '不显示', 'color' => 'default'],
        ];
        $grid->is_show_homepage('是否显示在导航')->switch($states);
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
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Course::findOrFail($id));

        $show->id('Id');
        $show->img_url('Img url');
        $show->title('Title');
        $show->content('Content');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->is_show_homepage('Is show homepage');
        $show->summary('Summary');

        return $show;
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Course);
        $states = [
            'on' => ['value' => 1, 'text' => '显示', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '不显示', 'color' => 'default'],
        ];
        $form->switch('is_show_homepage', '是否显示在导航')
            ->states($states)->default(0);

        $form->text('title', '标题');

        $form->image('img_url', '图片');

        $form->textarea('summary', '摘要');


        $form->ueditor('content', '内容');

        $form->tools(function (Form\Tools $tools)
        {
            $tools->disableView();
        });
        return $form;
    }
}
