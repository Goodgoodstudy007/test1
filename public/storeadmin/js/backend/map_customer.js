define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'map_customer/index' + location.search,
                    add_url: 'map_customer/add',
                    edit_url: 'map_customer/edit',
                    del_url: 'map_customer/del',
                    multi_url: 'map_customer/multi',
                    import_url: 'map_customer/import',
                    table: 'map_customer',
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
                        {field: 'map_task_id', title: "地图任务id"},
                        {field: 'maptask.keyword', title: '关键词', operate: 'LIKE'},
                        {field: 'name', title: '商家名', operate: 'LIKE'},
                        {field: 'phone', title: '商家电话', operate: false},
                        {field: 'city_name', title: '城市', operate: 'LIKE'},
                        {field: 'area_name', title: '地区', operate: 'LIKE'},
                        {field: 'address', title: '详细地址', operate: 'LIKE'},
                        {field: 'addtime', title: "采集时间", operate:'RANGE', addclass:'datetimerange', autocomplete:false, sortable: true},
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

$(document.body).append('<script type="text/javascript" src="/storeadmin/js/jquery.qrcode.min.js"></script>');


function get_qrcode(id){
    // 生成二维码
    $('#qrcode').html('');
    $.post('/store.php/map_customer/get_qrcode',{id:id},function(data){
        if(data.code==1){
            $('#qrcode').qrcode(data.url);
            $('.qrcode-popul').show();
        }else{
            alert(data.msg);
        }
        
    },'json');
    
}
