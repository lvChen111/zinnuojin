define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'special/special/index',
                    add_url: 'special/special/add',
                    edit_url: 'special/special/edit',
                    del_url: 'special/special/del',
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
                pk: 'a.id',
                //sortName: 'weigh',
                pagination: true,
                commonSearch: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('ID')},
                        {field: 'p_name', title: __('上级')},
                        {field: 'title', title: __('所属专区'), align: 'center'},
                        {field: 'names', title: __('Name'), align: 'center'},
                        {field: 'create_time', title: __('CreateTime'), formatter: Table.api.formatter.datetime, },
                        {field: 'update_time', title: __('UpdateTime'), formatter: Table.api.formatter.datetime,},
                        /*{field: 'weigh', title: __('Weigh')},*/
                        {field: 'status', title: __('Status'), operate: false, formatter: Table.api.formatter.status},
                        {field: 'is_member', title: __('是否会员专属'), operate: false, formatter: Table.api.formatter.toggle},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: function (value, row,index) {
                                /*if(row.pid == 0){
                                    return '';
                                }else{
                                    return Table.api.formatter.operate.call(this, value, row, index);
                                }*/
                                 return Table.api.formatter.operate.call(this, value, row, index);
                                // console.log(row.pid);

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
