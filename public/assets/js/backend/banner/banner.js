define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'banner/banner/index',
                    add_url: 'banner/banner/add',
                    edit_url: 'banner/banner/edit',
                    del_url: 'banner/banner/del',
                    // multi_url: 'category/multi',
                    // dragsort_url: '',
                    table: 'banner',
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
                        {field: 'id', title: 'ID'},
                        {field: 'title', title:'标题', align: 'left'},
                        {field: 'names', title:'广告位', align: 'left'},
                        {field: 'images', title: '预览图片', formatter: Controller.api.formatter.thumb, operate: false},
                        {field: 'link_url', title: '链接路径', formatter: Controller.api.formatter.url, operate: false},
                        {field: 'create_time', title: __('Createtime'), formatter: Table.api.formatter.datetime, },
                        {field: 'update_time', title: __('Updatetime'), formatter: Table.api.formatter.datetime,},
                        {field: 'status', title: __('Status'), operate: false, formatter: Table.api.formatter.status},
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
            },
                formatter: {
                    thumb: function (value, row, index) {
                            return '<a href="' + row.images + '" target="_blank"><img src="' + row.images + '" alt="" style="max-height:90px;max-width:120px"></a>';
                    },
                    url: function (value, row, index) {
                        return '<a href="' + row.link_url + '" target="_blank" class="label bg-green">' + value + '</a>';
                    },
                }

        }
    };
    return Controller;
});
