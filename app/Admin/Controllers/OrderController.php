<?php

namespace App\Admin\Controllers;

use App\Facades\OrderRepo;
use App\Http\Controllers\Controller;
use Cake\Chronos\Date;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Models\Order;
use Encore\Admin\Facades\Admin;

class OrderController extends Controller
{
    use HasResourceActions;

    private $state = [
        '0' => '已下单',
        '1' => '恢复中',
        '2' => '已完成',
    ];

    /**
     * Index interface.
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('订单')
            ->description('列表')
            ->body($this->grid());
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

        return Admin::grid(Order::class, function (Grid $grid)
        {
            $grid->id('序号')->sortable();
            $grid->order_id('订单编号');
            $grid->order_date('订单日期');
            $grid->customer_name('客户昵称');

            $grid->status('状态')->select($this->state);
            $grid->remark('备注')->limit('10');
            $grid->created_at('创建时间');

            $grid->model()->orderBy('id', 'desc');
            $grid->disableExport();
            $grid->disableRowSelector();
            $grid->actions(function (Grid\Displayers\Actions $actions)
            {
                $actions->disableView();
            });
                $grid->filter(function (\Encore\Admin\Grid\Filter $filter)
            {
                $filter->equal('status', '状态')->select($this->state);
            });
        });

    }


    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Order::class, function (Form $form)
        {
            $form->hidden('order_id', '订单编号')
                ->default(OrderRepo::getOrderId())
                ->setWidth(3, 2);

            $form->date('order_date', '下单日期')->default(new Date());

            $form->date('finish_time', '预计完成日期')
                ->default(date('Y-m-d H:i:s', strtotime('+1 day')));

            $form->text('customer_name', '客户昵称')->setWidth(3, 2);

            $form->select('status', '状态')
                ->options($this->state)
                ->setWidth(2, 2);

            $form->text('contact_handset', '联系手机')->setWidth(3, 2)
                ->rules('nullable|regex:/^((86)[\+-]?)?^1\d{10}$/i|min:11|max:11', [
                    'regex' => '请校验手机号码',
                    'min' => '请输入11位手机号码',
                    'max' => '请输入11位手机号码',
                ]);

            $form->text('contact_fixline', '联系固话')->setWidth(3, 2)
                ->rules('nullable|regex:/^\d+$/', [
                    'regex' => '固话必须全部为数字',
                    'min' => '固话不能少于7个数字',
                ]);

            $form->textarea('remark', '备注');
            $form->hidden('user_id', '用户ID')->default(Admin::user()->id);

            $form->disableReset();
            $form->tools(function (Form\Tools $tools)
            {
                $tools->disableView();
                $tools->disableDelete();
            });
        });
    }
}
