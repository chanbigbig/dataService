<?php

namespace App\Admin\Controllers;

use App\Models\Navigation;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class NavigationController extends Controller
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
            ->header('导航栏')
            ->description('首级列表')
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
            ->header('导航栏')
            ->description('展示')
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
            ->header('导航栏')
            ->description('编辑')
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
            ->header('导航栏')
            ->description('新建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Navigation);

        $grid->id('Id');
        $grid->title('标题内容')->limit(10);
        $grid->des('描述');
        $grid->content('详情');
        $states = [
            'on' => ['value' => 1, 'text' => '发布', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '未发布', 'color' => 'default'],
        ];
        $grid->status('状态')->switch($states);
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
            $actions->disableDelete();
            $actions->disableView();
            $actions->append('<a href="' . action('\App\Admin\Controllers\NavigationChildController@index', ['navigation_id' => $actions->row->id]) . '"><i class="fa fa-list" title="详情"></i></a>');
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
        $show = new Show(Navigation::findOrFail($id));

        $show->id('Id');
        $show->title('标题内容');
        $show->content('详情');
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
        return Admin::form(Navigation::class, function (Form $form)
        {
            $form->text('title', '标题内容')->default('')->rules('required');
            $form->text('des', '描述')->value('null');
            $form->textarea('content', '详情')->value('null');

            $states = [
                'on' => ['value' => 1, 'text' => '发布', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '未发布', 'color' => 'default'],
            ];
            $form->switch('status', '发布状态')
                ->states($states)->default(0);

            $form->tools(function (Form\Tools $tools)
            {
                $tools->disableView();
            });
        });

    }
}
