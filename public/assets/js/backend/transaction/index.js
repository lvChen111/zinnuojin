define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        recharge: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'transaction/index/recharge',
                    //edit_url: 'transaction/index/detail',
                    table: 'recharge',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'transaction.id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), sortable: true},
                        {field: 'nickname', title: __('Nickname'), operate: 'LIKE'},
                        {field: 'type', title: __('Type'), operate: false},
                        {field: 'amount', title: __('Amount'), operate: false},
                        {field: 'create_time', title: __('CreateTime'), formatter: Table.api.formatter.datetime, operate: false},
                        {field: 'update_time', title: __('UpdateTime'),  formatter: Table.api.formatter.datetime,operate: false},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status,searchList: {0: __('待支付'), 1: __('充值成功'),2:__('充值失败')}},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,buttons: [{
                                name: 'detail',
                                text: __('Detail'),
                                icon: 'fa fa-list',
                                classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                url: 'transaction/index/detail'
                            }], formatter: Table.api.formatter.operate},
                       /* {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}*/
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        withdrawal: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'transaction/index/withdrawal',
                    //edit_url: 'transaction/index/detail',
                    table: 'withdrawal',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'transaction.id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), sortable: true},
                        {field: 'nickname', title: __('Nickname'), operate: 'LIKE'},
                        {field: 'type', title: __('Type'), operate: false},
                        {field: 'amount', title: __('Amount'), operate: false},
                        {field: 'create_time', title: __('CreateTime'), formatter: Table.api.formatter.datetime,operate: false},
                        {field: 'update_time', title: __('UpdateTime'),  formatter: Table.api.formatter.datetime,operate: false},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status,searchList: {0: __('待审核'), 1: __('提现成功'),2:__('提现失败')}},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,buttons: [{
                                name: 'detail',
                                text: __('Detail'),
                                icon: 'fa fa-list',
                                classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                url: 'transaction/index/detail'
                            }], formatter: Table.api.formatter.operate}
                        /*{field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}*/
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        edit: function () {

            Controller.api.bindevent();
        },
        detail: function () {
            $(document).on('click','.passOn',function() {
                var id=$('#id').val();
                layer.confirm('确定通过该用户实名审核？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.post('transaction/index/passOn',{id:id}, function (res) {
                        if(res.code==1){
                            layer.msg(res.msg,{icon:1,time:1500,shade: 0.1,end:function () {
                                    window.location.reload()
                                    // window.location.reload()//userInfo();
                                    /* window.parent.location.reload();
                                     var mylay = parent.layer.getFrameIndex(window.name);
                                     parent.layer.close(mylay);*/
                                }});
                        }else{
                            layer.msg(res.msg,{icon:3,time:1500,shade: 0.1})
                        }
                    });
                }, function(){
                    Layer.close();
                });
            });
            $(document).on('click','.passNo',function() {
                var id=$('#id').val();
                layer.open({
                    type: 1,
                    title: '添加驳回原因',
                    skin: 'layui-layer-fast',
                    closeBtn: 1,
                    shadeClose: true,
                    shade: false,
                    area: ['500px', '380px'],
                    content: '      <div class="">\n' +
                        '                <label for="c-content" class=""></label>\n' +
                        '                <div class="" >\n' +
                        '                    <textarea id="c-content" style="border:0;border-radius:5px;background-color:rgba(241,241,241,.98);resize: none;width:80%; height:200px;margin-top:15px;margin-left: 40px;"  data-rule="required" name="row[content]" type="text" placeholder="驳回原因"></textarea>\n' +
                        '                </div>\n' +
                        '            </div>',
                    btn: ['确定','取消']
                    , yes: function (index, layero) {
                        var remark = $('#c-content').val();
                        $.post('transaction/index/passNo',{id:id,remark:remark}, function (res) {
                            if(res.code==1){
                                layer.msg(res.msg,{icon:1,time:1500,shade: 0.1,end:function () {
                                        window.location.reload()
                                        // window.location.reload()//userInfo();
                                          window.parent.location.reload();
                                          var mylay = parent.layer.getFrameIndex(window.name);
                                          parent.layer.close(mylay);
                                    }});
                            }else{
                                layer.msg(res.msg,{icon:3,time:1500,shade: 0.1})
                            }
                        });
                    },err: function () {
                        layer.close();
                    }
                });
            });
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