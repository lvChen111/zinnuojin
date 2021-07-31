define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'banner/index/index',
                    add_url: 'banner/index/add',
                    edit_url: 'banner/index/edit',
                    del_url: 'banner/index/del',
                   // multi_url: 'category/multi',
                   // dragsort_url: '',
                    table: 'sort',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                escape: false,
                pk: 'id',
                sortName: 'weigh',
                pagination: true,
                commonSearch: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('ID')},
                        {field: 'names', title: __('Name'), align: 'left'},
                        {field: 'create_time', title: __('Createtime'), formatter: Table.api.formatter.datetime, },
                        {field: 'update_time', title: __('Updatetime'), formatter: Table.api.formatter.datetime,},
                        {field: 'status', title: __('Status'), operate: false, formatter: Table.api.formatter.status},
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
            }
        }
    };
    return Controller;
});
