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
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'storetask.store_id', title: '商户id'},
                        {field: 'task_id', title: __('Task_id')},
                        {field: 'storetask.title', title: '任务名'},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'video_desc', title: __('Video_desc'), operate: 'LIKE',formatter: function(value,row,index){
                            return "<a target='_blank' href='https://www.douyin.com/video/"+row.aweme_id+"' >"+value+"</a>";
                        },width:200},
                        {field: 'script_count', title: __('Script_count')},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'status', title: '任务状态',formatter: function(value,row,index){
                            if(row.status==1){
                                return "<span style='color:green;    font-weight: bold;    font-size: 16px;'>运行中</span>";
                            }else if(row.status==2){
                                return "<span style='color:#ccc'>已完成</span>";
                            }else if(row.status==0){
                                return "<span style='color:red'>已暂停</span>";
                            }
                        }},
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