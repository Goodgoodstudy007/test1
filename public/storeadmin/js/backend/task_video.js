define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'task_video/index' + location.search,
                    add_url: 'task_video/add',
                    edit_url: 'task_video/edit',
                    del_url: 'task_video/del',
                    multi_url: 'task_video/multi',
                    import_url: 'task_video/import',
                    table: 'task_video',
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
                        {field: 'task_id', title: __('Task_id')},
                        {field: 'storetask.title', title:'任务名', operate: 'LIKE'},
                        {field: 'status', title: '任务状态', searchList: {"1":'运行中',"2":'已完成',"0":'已暂停'},formatter: function(value,row,index){
                            if(row.status==1){
                                return "<span style='color:green;    font-weight: bold;    font-size: 16px;'>运行中</span>";
                            }else if(row.status==2){
                                return "<span style='color:#ccc'>已完成</span>";
                            }else if(row.status==0){
                                return "<span style='color:red'>已暂停</span>";
                            }
                        }},
                        
                        {field: 'video_desc', title: __('Video_desc'), operate: 'LIKE',formatter: function(value,row,index){
                            return "<a target='_blank' href='https://www.douyin.com/video/"+row.aweme_id+"' >"+value+"</a>";
                        }},
                        {field: 'man_count', title: '意向客户数',operate:false},
                        {field: 'script_count', title: '线索分析数',operate:false},
                        {field: 'addtime', title: '挖掘时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'operate', title: __('Operate'), table: table, formatter: function(value,row,index){
                            return '<a href="/store.php/index?jump_url=video_comment&menu_url=video_comment&video_id='+row.id+'" class="btn btn-success run_task" style="margin-left:20px;"  target="_blank">客户</a>';
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