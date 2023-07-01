define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'store_task/index' + location.search,
                    add_url: 'store_task/add',
                    edit_url: 'store_task/edit',
                    del_url: 'store_task/del',
                    multi_url: 'store_task/multi',
                    import_url: 'store_task/import',
                    table: 'store_task',
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
                        {field: 'id', title: '任务id'},
                        {field: 'title', title: '任务名'},
                        {field: 'mode',title:'类型',formatter: function (value, row, index) {
                            if(value==1){
                                return '主页监控';
                            }else if(value==2){
                                return '单视频监控';
                            }else if(value==3){
                                return '关键词监控';
                            }
                        }},
                        {field: 'store.store_name', title: __('Store.store_name'), operate: 'LIKE'},
                        {field: 'url', title:'采集源', operate: 'LIKE'},
                        {field: 'dcount', title: __('Dcount')},
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
                        {field: 'price', title: __('Price')},
                        
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