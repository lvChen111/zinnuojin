define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'user/verify/index',
                    edit_url: 'user/verify/detail',
                    table: 'index',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'a.id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), sortable: true},
                        {field: 'nickname', title: __('Nickname'), operate: 'LIKE'},
                        {field: 'realname', title: __('RealName'), operate: 'LIKE'},
                        {field: 'id_card', title: __('IdCard'), operate: 'LIKE'},
                        {field: 'create_time', title: __('Createtime'),  formatter: Table.api.formatter.datetime,operate: 'LIKE'},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status,searchList: {0: __('Wait'), 1: __('PassOn'),2:__('PassNo')}},
                        /*{field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,buttons: [{
                                name: 'detail',
                                text: __('Detail'),
                                icon: 'fa fa-list',
                                classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                url: 'user/verify/detail'
                            }], formatter: Table.api.formatter.operate}*/
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
                var real_id=$('#real_id').val();
                layer.confirm('确定通过该用户实名审核？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.post('user/verify/passOn',{real_id:real_id}, function (res) {
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
                var real_id=$('#real_id').val();
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
                        $.post('user/verify/passNo',{real_id:real_id,remark:remark}, function (res) {
                            if(res.code==1){
                                layer.msg(res.msg,{icon:1,time:1500,shade: 0.1,end:function () {
                                        window.location.reload()
                                        // window.location.reload()//userInfo();
                                      /*  window.parent.location.reload();
                                        var mylay = parent.layer.getFrameIndex(window.name);
                                        parent.layer.close(mylay);*/
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