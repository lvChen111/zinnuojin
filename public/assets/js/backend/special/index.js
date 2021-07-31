define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'special/index/index',
                    add_url: 'special/index/add',
                    edit_url: 'special/index/edit',
                    del_url: 'special/index/del',
                   // multi_url: 'category/multi',
                   // dragsort_url: '',
                    table: 'special',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                escape: false,
                pk: 'id',
                sortName: 'weight',
                pagination: true,
                commonSearch: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('ID')},
                        {field: 'title', title: __('Name'), align: 'left'},
                        {field: 'logo_img', title: __('Logo'), formatter: Controller.api.formatter.thumb},
                        {field: 'create_time', title: __('CreateTime'), formatter: Table.api.formatter.datetime,  operate: false},
                        {field: 'update_time', title: __('UpdateTime'), formatter: Table.api.formatter.datetime, operate: false},
                        {field: 'status', title: __('Status'), operate: false, formatter: Table.api.formatter.status},
                        {field: 'weight', title: __('Weight'), operate: false},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: function (value, row,index) {

                                return Table.api.formatter.operate.call(this, value, row, index);

                            }}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            },
            formatter: {
                thumb: function (value, row, index) {
                    return '<a href="' + row.logo_img + '" target="_blank"><img src="' + row.logo_img + '" alt="" style="max-height:90px;max-width:120px"></a>';
                },
            }
        }
    };
    return Controller;
});
