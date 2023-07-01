define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'agent/index' + location.search,
                    add_url: 'agent/add',
                    edit_url: 'agent/edit',
                    del_url: 'agent/del',
                    multi_url: 'agent/multi',
                    import_url: 'agent/import',
                    table: 'agent_name',
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
                        {field: 'agent_name', title: "代理名称"},
                        {field: 'agent_pid', title: '上级id'},
                        {field: 'ap.agent_name', title: "上级名称"},
                        {field: 'level', title: __('Level')},
                        {field: 'commission', title: '佣金余额'},
                        {field: 'dianshu', title: '剩余点数'},
                        {field: 'rate', title: '分红比例(%)'},
                        {field: 'store_count', title: __('Store_count')},
                        {field: 'agent_count', title: __('Agent_count')},
                        {field: 'username', title: __('Username'), operate: 'LIKE'},
                        {field: 'status', title: __('Status')},
                        {field: 'out_date', title: __('Out_date'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
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