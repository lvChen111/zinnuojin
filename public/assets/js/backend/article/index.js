define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'article/index/index',
                    add_url: 'article/index/add',
                    edit_url: 'article/index/edit',
                    del_url: 'article/index/del',
                   // detail_url: 'article/index/detail',
                    // multi_url: 'category/multi',
                    // dragsort_url: '',
                    table: 'index',
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
                        {field: 'art_title', title: __('文章标题'), align: 'center'},
                        {field: 'title', title: __('专栏标题'), align: 'center'},
                        {field: 'names', title: __('专栏分类'), align: 'center'},
                        {field: 'cover_img', title: __('文章封面'), formatter: Controller.api.formatter.thumb, operate: false},
                        {field: 'nickname', title: __('发布人'), align: 'center'},
                        {field: 'views', title: __('浏览人数'), align: 'center'},
                        {field: 'all_periods', title: __('专栏总期数'), align: 'center'},
                        {field: 'periods', title: __('专栏已发布期数'), align: 'center'},
                        {field: 'th_periods', title: __('专栏已发布期数'), align: 'center'},
                        {field: 'create_time', title: __('CreateTime'), formatter: Table.api.formatter.datetime, },
                        {field: 'update_time', title: __('UpdateTime'), formatter: Table.api.formatter.datetime,},
                        /*{field: 'weigh', title: __('Weigh')},*/
                        {field: 'status', title: __('Status'), operate: false, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,
                            /*buttons: [{
                                name: 'detail',
                                text: __('Detail'),
                                icon: 'fa fa-list',
                                classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                url: 'article/index/detail'
                            }],*/
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
        // detail: function () {
        //     Controller.api.bindevent();
        // },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
                var ue = UE.getEditor('c-content', {
                    initialFrameWidth: null, autoHeightEnabled: false,
                });
            }, formatter: {
                thumb: function (value, row, index) {
                    return '<a href="' + row.cover_img + '" target="_blank"><img src="' + row.cover_img + '" alt="" style="max-height:90px;max-width:120px"></a>';
                },
            }
        }
    };
    return Controller;
});
