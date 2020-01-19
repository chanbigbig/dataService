<?php

namespace App\Admin\Controllers;

use App\Models\Navigation;
use App\Models\NavigationChild;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class NavigationChildController extends Controller
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
            ->header('二级导航栏')
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
            ->header('二级导航栏')
            ->description('')
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
            ->header('编辑二级导航栏')
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
            ->header('新建二级导航栏')
            ->description('')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(NavigationChild::class, function (Grid $grid)
        {
            $grid->id('Id');

            $grid->title('标题');
            $grid->content('详情');
            $grid->navigation_id('一级导航名称')->display(function ($id)
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
        });

    }

    /**
     * Make a show builder.
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(NavigationChild::findOrFail($id));

        $show->id('Id');
        $show->title('标题');
        $show->content('内容');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        return Admin::form(NavigationChild::class, function (Form $form)
        {
            $typeList = Navigation::query()->pluck('title', 'id');
            $form->select('navigation_id', '上一级导航条名称')->options($typeList);
            $form->text('title', '标题')->default('');
            $form->textarea('content', '内容')->default('');
        });

    }
}
