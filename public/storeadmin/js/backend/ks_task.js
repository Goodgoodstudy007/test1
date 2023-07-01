define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'ks_task/index' + location.search,
                    add_url: 'ks_task/add?mode='+$('#mode').val(),
                    edit_url: 'ks_task/edit',    
                    del_url: 'ks_task/del',
                    multi_url: 'ks_task/multi',
                    import_url: 'ks_task/import',
                    table: 'ks_task',
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
                        {field: 'title', title: '任务名'},
                        {field: 'url', title: "采集源", operate: 'LIKE'},
                        {field: 'status', title: '任务状态',formatter: function(value,row,index){
                            if(row.status==1){
                                return "<span style='color:green;    font-weight: bold;    font-size: 16px;'>运行中</span>";
                            }else if(row.status==2){
                                return "<span style='color:#ccc'>已完成</span>";
                            }else if(row.status==0){
                                return "<span style='color:red'>已暂停</span>";
                            }
                        },operate:false},
                        
                        {field: 'public_time', title: '时间筛选',formatter: function(value,row,index){
                            if(row.public_time==0){
                                return "<span >全部视频</span>";
                            }else if(row.public_time==15){
                                return "<span >15天内</span>";
                            }else if(row.public_time==30){
                                return "<span >一个月内</span>";
                            }else if(row.public_time==180){
                                return "<span >半年内</span>";
                            }else if(row.public_time==365){
                                return "<span >一年内</span>";
                            }
                        },operate:false},
                        {field: 'price', title: '获客量',operate:false},
                        // {field: 'head', title: __('Douyin_head'), operate: 'LIKE',formatter: function(value,row,index){
                        //             return '<img style="width: 50px;border-radius: 50%;" src="'+row.head+'" class="img-rounded" >';
                        //         }},
                        {field: 'video_count', title: '视频',operate:false},
                        {field: 'addtime', title: '添加时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'operate', title: __('Operate'), width:300,table: table, formatter: function(value,row,index){
                            return '<a href="/store.php/index?jump_url=ks_video&menu_url=ks_video&task_id='+row.id+'" class="btn btn-success run_task" style="margin-left:5px;"  target="_blank">视频</a>\
                            <a href="/store.php/index?jump_url=ks_comment&menu_url=ks_comment&task_id='+row.id+'" class="btn btn-success run_task" style="margin-left:5px;"  target="_blank">客户</a>\
                            <a href="/store.php/ks_task/edit/ids/'+row.id+'" class="btn btn-success btn-edit" style="margin-left:5px;" data-toggle="tooltip" title="" data-table-id="table" data-field-index="15" data-row-index="0" data-button-index="1" data-original-title="编辑">编辑</a>\                            <a  class="btn  btn-danger btn-delone" onclick="delCheck('+row.id+')" data-toggle="tooltip" title="" data-table-id="table" data-field-index="15" data-row-index="0" data-button-index="2" style="margin-left:5px;"  data-original-title="删除">删除</a>';
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
            url:'/store.php/ks_task/del?ids='+id,
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