define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'article/author/index',
                    add_url: 'article/author/add',
                    edit_url: 'article/author/edit',
                    del_url: 'article/author/del',
                    // multi_url: 'category/multi',
                    // dragsort_url: '',
                    table: 'author',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                escape: false,
                pk: 'id',
                sortName: 'id',
                pagination: true,
                commonSearch: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('ID')},
                        {field: 'nickname', title: __('笔名昵称'), align: 'center'},
                        {field: 'create_time', title: __('CreateTime'), formatter: Table.api.formatter.datetime, },
                        {field: 'update_time', title: __('UpdateTime'), formatter: Table.api.formatter.datetime,},
                        {field: 'status', title: __('Status'), operate: false, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,
                            formatter: Table.api.formatter.operate
                            // console.log(row.pid);

                        }
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
                var ue = UE.getEditor('c-content', {
                    initialFrameWidth: null, autoHeightEnabled: false,
                });
            }
        }
    };
    return Controller;
});
