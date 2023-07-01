define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'video_comment/index' + location.search,
                    add_url: 'video_comment/add',
                    edit_url: 'video_comment/edit',
                    del_url: 'video_comment/del',
                    multi_url: 'video_comment/multi',
                    import_url: 'video_comment/import',
                    table: 'video_comment',
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
                        {field: 'task_id', title: __('Task_id')},
                        {field: 'task_video_id', title: __('Task_video_id')},
                        {field: 'douyin_username', title: __('Douyin_username'), operate: 'LIKE'},
                        {field: 'douyin_userid', title: __('Douyin_userid'), operate: 'LIKE'},
                        {field: 'douyin_desc', title: __('Douyin_desc'), operate: 'LIKE'},
                        {field: 'douyin_head', title: __('Douyin_head'), operate: 'LIKE'},
                        {field: 'comment_time', title: __('Comment_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'status', title: __('Status')},
                        {field: 'reply_comment_total', title: __('Reply_comment_total')},
                        {field: 'digg_count', title: __('Digg_count')},
                        {field: 'douyin_cid', title: __('Douyin_cid'), operate: 'LIKE'},
                        {field: 'keyword', title: __('Keyword'), operate: 'LIKE'},
                        {field: 'aweme_count', title: __('Aweme_count')},
                        {field: 'following_count', title: __('Following_count')},
                        {field: 'follower_count', title: __('Follower_count')},
                        {field: 'total_favorited', title: __('Total_favorited')},
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