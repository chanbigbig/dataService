<?php

namespace App\Admin\Controllers;

use App\Models\Tabbar;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class TabbarController extends Controller
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
            ->header('底部导航栏')
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
        $grid = new Grid(new Tabbar);

        $grid->id('Id');
        $grid->service_mobile('服务电话');
        $grid->service_time('服务时间');
        $grid->mobile1('联系方式一');
        $grid->mobile2('联系方式二');
        $grid->mobile3('联系方式三');
        $grid->email('Email');
        $grid->address('地址');
        $grid->mini_program_url('二维码')->image(['width' => 250, 'height' => 250]);
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
        $show = new Show(Tabbar::findOrFail($id));

        $show->id('Id');
        $show->service_mobile('Service mobile');
        $show->service_time('Service time');
        $show->usa_mobile('Usa mobile');
        $show->shanghai_mobile('Shanghai mobile');
        $show->guangzhou_mobile('Guangzhou mobile');
        $show->email('Email');
        $show->address('Address');
        $show->mini_program_url('Mini program url');
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
        $form = new Form(new Tabbar);

        $form->text('service_mobile', '服务电话');
        $form->text('service_time', '服务时间');
        $form->text('mobile1', '联系方式一');
        $form->text('mobile2', '联系方式二');
        $form->text('mobile3', '联系方式三');
        $form->email('email', '邮件');
        $form->textarea('address', '地址');
        $form->image('mini_program_url', '二维码')
            ->uniqueName()
            ->setQiniuDirectory('tabbar')
            ->rules('image');

        $form->text('mini_program_url_remark', '二维码备注');
        $form->textarea('remark', '底部导航栏备注');
        return $form;
    }
}
