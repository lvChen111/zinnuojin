define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'member/goods/index',
                    add_url: 'member/goods/add',
                    edit_url: 'member/goods/edit',
                    del_url: 'member/goods/del',
                    table: 'member',
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
                        {field: 'title', title:__('Title'),formatter: function(value){return value.toString().substr(0, 20)}},
                        {field: 'describe', title:__('商品描述'),formatter: function(value){return value.toString().substr(0, 200)}},
                        {field: 'power', title:__('会员描述'),formatter: function(value){return value.toString().substr(0, 200)}},
                        {field: 'price', title:__('现价'),align: 'center'},
                        {field: 'original_price', title: __('原价'), align: 'center'},
                        {field: 'create_time', title: __('CreateTime'), formatter: Table.api.formatter.datetime, },
                        {field: 'update_time', title: __('UpdateTime'), formatter: Table.api.formatter.datetime,},
                        {field: 'status', title: __('Status'), operate: false, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
                Form.api.bindevent($("form[role=form]"), null, null, function () {
                    return true;
                });
                var ue = UE.getEditor('c-content', {
                    initialFrameWidth: null, autoHeightEnabled: false,
                });
               /* //全选和展开
                $(document).on("click", "#checkall", function () {
                    $("#treeview").jstree($(this).prop("checked") ? "check_all" : "uncheck_all");
                });
                $(document).on("click", "#expandall", function () {
                    $("#treeview").jstree($(this).prop("checked") ? "open_all" : "close_all");
                });*/

            },
            rendertree: function (content) {
                $("#treeview")
                    .on('redraw.jstree', function (e) {
                        $(".layer-footer").attr("domrefresh", Math.random());
                    })
                    .jstree({
                        "themes": {"stripes": true},
                        "checkbox": {
                            "keep_selected_style": false,
                        },
                        "types": {
                            "root": {
                                "icon": "fa fa-folder-open",
                            },
                            "menu": {
                                "icon": "fa fa-folder-open",
                            },
                            "file": {
                                "icon": "fa fa-file-o",
                            }
                        },
                        "plugins": ["checkbox", "types"],
                        "core": {
                            'check_callback': true,
                            "data": content
                        }
                    });
            }
        }
    };
    return Controller;
});
