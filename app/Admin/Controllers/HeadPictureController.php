<?php

namespace App\Admin\Controllers;

use App\Models\HeadPicture;
use App\Http\Controllers\Controller;
use App\Models\Navigation;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class HeadPictureController extends Controller
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
            ->header('顶部图片')
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
        $grid = new Grid(new HeadPicture);

        $grid->id('Id');
        $grid->img_url('图片')->lightbox();
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');
        $grid->navigation_id('类型')->display(function ($id)
        {
            return Navigation::where('id', $id)->first()->title;
        })->badge('green');
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
        $show = new Show(HeadPicture::findOrFail($id));

        $show->id('Id');
        $show->type('Type');
        $show->img_url('Img url');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->navigation_id('Navigation id');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HeadPicture);

        $form->image('img_url', '图片');
        $typeList = Navigation::query()->pluck('title', 'id');
        $form->select('navigation_id', '导航条名称')->options($typeList);

        return $form;
    }
}
