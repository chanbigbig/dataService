<?php

namespace App\Admin\Controllers;

use App\Models\HomeBespockContent;
use App\Http\Controllers\Controller;
use App\Models\Navigation;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class HomeBespockController extends Controller
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
            ->header('模块标题文案')
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
        $grid = new Grid(new HomeBespockContent);

        $grid->id('Id');
        $grid->title('标题');

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
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(HomeBespockContent::findOrFail($id));

        $show->id('Id');
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
        $form = new Form(new HomeBespockContent);

        $typeList = Navigation::query()->pluck('title', 'id');
        $form->select('navigation_id', '导航条名称')->options($typeList);

        $form->text('title', '标题');
        $form->ueditor('content', '内容')
            ->help('编辑后提示"本地保存成功",方可点击提交表单。');
        $form->tools(function (Form\Tools $tools)
        {
            $tools->disableView();
        });
        return $form;
    }
}
