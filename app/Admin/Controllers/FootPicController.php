<?php

namespace App\Admin\Controllers;

use App\Models\FootPicture;
use App\Http\Controllers\Controller;
use App\Models\Navigation;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class FootPicController extends Controller
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
            ->header('底部图片')
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
            ->header('创建')
            ->description('')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FootPicture);

        $grid->id('Id');
        $grid->img_url('图片')->image(['width' => 250, 'height' => 250]);
        $grid->remark('图片备注');
        $grid->navigation_id('类型')->display(function ($id)
        {
            return Navigation::where('id', $id)->first()->title;
        })->badge('green');
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

        $grid->filter(function ($filter)
        {
            $filter->disableIdFilter();
            $filter->is('navigation_id', 1);

            $typeList = Navigation::query()->pluck('title', 'id');
            $filter->equal('navigation_id', '一级导航名称')->select($typeList);
        });
        return $grid;

        return $grid;
    }

    /**
     * Make a show builder.
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(FootPicture::findOrFail($id));

        $show->id('Id');
        $show->img_url('Img url');
        $show->remark('Remark');
        $show->navigation_id('Navigation id');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FootPicture);

        $typeList = Navigation::query()->pluck('title', 'id');
        $form->select('navigation_id', '导航条名称')->options($typeList);

        $form->image('img_url', '图片')
            ->uniqueName()
            ->setQiniuDirectory('foot_pic')
            ->rules('image');

        $form->textarea('remark', '图片备注')->default("")
            ->rules('nullable')
            ->help("若输入备注后会在图片上方显示文字。");

        $form->tools(function (Form\Tools $tools)
        {
            $tools->disableView();
        });
        return $form;
    }
}
