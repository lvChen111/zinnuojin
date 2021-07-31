define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'article/order/index',
                    /*add_url: 'article/order/add',
                    edit_url: 'article/order/edit',
                    del_url: 'article/order/del',*/
                    detail_url: 'article/index/detail',
                    // multi_url: 'category/multi',
                    // dragsort_url: '',
                    table: 'order',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                escape: false,
                pk: 'id',
                sortName: 'a.id',
                pagination: true,
                commonSearch: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('ID')},
                        {field: 'order_no', title: __('订单编号'), align: 'center'},
                        {field: 'title', title: __('专栏标题'), align: 'center'},
                        {field: 'cover', title: __('专栏封面'), formatter: Controller.api.formatter.thumb, operate: false},
                        {field: 'nickname', title: __('用户'), align: 'center'},
                        {field: 'amount', title: __('支付金额'), align: 'center'},
                        {field: 'payType', title: __('支付方式'), align: 'center'},
                        {field: 'create_time', title: __('CreateTime'), formatter: Table.api.formatter.datetime, },
                        {field: 'update_time', title: __('UpdateTime'), formatter: Table.api.formatter.datetime,},
                        /*{field: 'weigh', title: __('Weigh')},*/
                        {field: 'status', title: __('Status'), operate: true, formatter: Table.api.formatter.status,searchList:{0: __('待支付'), 1: __('支付成功'),2:__('支付失败')}},
                        /*{field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,
                            buttons: [{
                                name: 'detail',
                                text: __('Detail'),
                                icon: 'fa fa-list',
                                classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                url: 'article/order/detail'
                            }],
                            //formatter: Table.api.formatter.operate
                            // console.log(row.pid);

                        }*/
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        detail: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
                var ue = UE.getEditor('c-content', {
                    initialFrameWidth: null, autoHeightEnabled: false,
                });
            }, formatter: {
                thumb: function (value, row, index) {
                    return '<a href="' + row.cover + '" target="_blank"><img src="' + row.cover + '" alt="" style="max-height:90px;max-width:120px"></a>';
                },
            }
        }
    };
    return Controller;
});
