define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'map_task/index' + location.search,
                    add_url: 'map_task/add',
                    edit_url: 'map_task/edit',    
                    del_url: 'map_task/del',
                    multi_url: 'map_task/multi',
                    import_url: 'map_task/import',
                    table: 'map_task',
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
                        {field: 'id', title: '任务id'},
                        {field: 'city.city', title: '城市', operate: 'LIKE'},
                        {field: 'keyword', title: "关键词", operate: 'LIKE'},
                        
                        {field: 'price', title: '获客量', operate: false},
                        {field: 'xunpang_count', title: '过滤数', operate: false},
                        {field: 'status', title: '任务状态',formatter: function(value,row,index){
                            if(row.status==1){
                                return "<span style='color:green;    font-weight: bold;    font-size: 16px;'>运行中</span>";
                            }else if(row.status==2){
                                return "<span style='color:#ccc'>已完成</span>";
                            }else if(row.status==0){
                                return "<span style='color:red'>已暂停</span>";
                            }
                        }, operate: false},
                        {field: 'addtime', title: '添加时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'operate', title: '操作', width:300,table: table, formatter: function(value,row,index){
                            return '<a href="/store.php/index?jump_url=map_customer&menu_url=map_customer&map_task_id='+row.id+'" class="btn btn-success run_task" style="margin-left:5px;"  target="_blank">客户</a>\
                            <a  class="btn  btn-danger btn-delone" onclick="delCheck('+row.id+')" data-toggle="tooltip" title="" data-table-id="table" data-field-index="15" data-row-index="0" data-button-index="2" style="margin-left:5px;"  data-original-title="删除">删除</a>';
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

function delCheck(id)
{
    var flag = window.confirm("消耗金额不退回，确认是否删除任务？");
    if(flag == true){
        $.ajax({
            type:"POST",
            dataType:"json",
            url:'/store.php/map_task/del?ids='+id,
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