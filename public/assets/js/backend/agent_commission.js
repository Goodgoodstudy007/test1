define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'agent_commission/index' + location.search,
                    del_url: 'agent_commission/del',
                    multi_url: 'agent_commission/multi',
                    import_url: 'agent_commission/import',
                    table: 'agent_commission',
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
                        {field: 'agent_id', title: '代理id'},
                        {field: 'agent.agent_name', title:'代理名'},
                        {field: 'store_pay_id', title: '充值记录id'},
                        {field: 'commission', title: __('Commission'), operate:'BETWEEN'},
                        {field: 'storepay.price', title: "充值金额"},
                        {field: 'rate', title: __('Rate')},
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