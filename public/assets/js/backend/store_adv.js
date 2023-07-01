define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'store_adv/index' + location.search,
                    add_url: 'store_adv/add',
                    edit_url: 'store_adv/edit',    
                    del_url: 'store_adv/del',
                    multi_url: 'store_adv/multi',
                    import_url: 'store_adv/import',
                    table: 'store_adv',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        // {checkbox: true},
                        {field: 'store_id', title: '商户id'},
                        {field: 'store.store_name', title: '商户名'},
                        {field: 'title', title: '计划名称'},
                        {field: 'mode', title: "模式", operate: 'LIKE'},
                        {field: 'start_time', title: '开始时间'},
                        {field: 'end_time', title: '结束时间'},
                        {field: 'max_price', title: '最高单价'},
                        {field: 'day_limit', title: '每日限额'},
                        {field: 'adv_status', title: '任务状态',formatter: function(value,row,index){
                            if(row.adv_status==1){
                                return "<span style='color:green;    font-weight: bold;    font-size: 16px;'>启用</span>";
                            }else if(row.adv_status==2){
                                return "<span style='color:red'>已暂停</span>";
                            }
                        }},
                        {field: 'status', title: '审核状态',formatter: function(value,row,index){
                            if(row.status==1){
                                return "<span style='color:#888'>审核中</span>";
                            }else if(row.status==2){
                                return "<span style='color:green;    font-weight: bold;  '>审核通过</span>";
                            }else if(row.status==3){
                                return "<span style='color:red'>审核失败</span>";
                            }

                        }},
                        {field: 'addtime', title: '提交时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false},
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
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;

    

});

function delCheck(id)
{
    var flag = window.confirm("确认是否删除投放计划？");
    if(flag == true){
        $.ajax({
            type:"POST",
            dataType:"json",
            url:'/store.php/store_adv/del?ids='+id,
            success:function(data){
                window.location.reload();//自动刷新
            },
            error:function(){
                alert("删除失败！");
            }
        });
    }else{ 
        return false;
    }
}