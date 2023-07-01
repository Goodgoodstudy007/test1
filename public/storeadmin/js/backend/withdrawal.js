define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'withdrawal/index' + location.search,
                    edit_url: 'withdrawal/edit',
                    del_url: 'withdrawal/del',
                    multi_url: 'withdrawal/multi',
                    import_url: 'withdrawal/import',
                    table: 'withdrawal',
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
                        {field: 'agent_id', title: __('Agent_id')},
                        {field: 'agent.agent_name', title: '代理名'},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'uptime', title: __('Uptime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'status', title: __('Status')},
                        {field: 'reason', title: __('Reason'), operate: 'LIKE'},                    
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