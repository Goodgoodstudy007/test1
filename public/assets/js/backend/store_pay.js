define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'store_pay/index' + location.search,
                    del_url: 'store_pay/del',
                    multi_url: 'store_pay/multi',
                    import_url: 'store_pay/import',
                    table: 'store_pay',
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
                        {field: 'store_id', title: __('Store_id')},
                        {field: 'agent_id', title: '手动充值代理id'},
                        {field: 'store.store_name', title: __('Store.store_name'), operate: 'LIKE'},
                        {field: 'price', title: '充值金额'},
                        {field: 'dianshu', title: '充值点数'},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'pay_id', title: __('Pay_id'), operate: 'LIKE'},
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