define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'xhs_note/index' + location.search,
                    add_url: 'xhs_note/add',
                    edit_url: 'xhs_note/edit',
                    del_url: 'xhs_note/del',
                    multi_url: 'xhs_note/multi',
                    import_url: 'xhs_note/import',
                    table: 'xhs_note',
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
                        {field: 'task_id', title: '任务id'},
                        {field: 'xhstask.title', title:'任务名', operate: 'LIKE'},
                        {field: 'status', title: '任务状态',formatter: function(value,row,index){
                            if(row.status==1){
                                return "<span style='color:green;    font-weight: bold;    font-size: 16px;'>运行中</span>";
                            }else if(row.status==2){
                                return "<span style='color:#ccc'>已完成</span>";
                            }else if(row.status==0){
                                return "<span style='color:red'>已暂停</span>";
                            }
                        }},
                        {field: 'create_time', title: '发布时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'addtime', title: '采集时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'title', title: '笔记标题', operate: 'LIKE',formatter: function(value,row,index){
                            return "<a target='_blank' href='https://www.xiaohongshu.com/discovery/item/"+row.notes_id+"' >"+value+"</a>";
                        }},
                        {field: 'man_count', title: '获客量'},
                        {field: 'script_count', title: '评论筛选数'},
                        {field: 'operate', title: __('Operate'), table: table, formatter: function(value,row,index){
                            return '<a href="/store.php/index?jump_url=xhs_comment&menu_url=xhs_comment&video_id='+row.id+'" class="btn btn-success run_task" style="margin-left:20px;"  target="_blank">客户</a>';
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