define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'ks_comment/index' + location.search,
                    add_url: 'ks_comment/add',
                    edit_url: 'ks_comment/edit',
                    del_url: 'ks_comment/del',
                    multi_url: 'ks_comment/multi',
                    import_url: 'ks_comment/import',
                    table: 'ks_comment',
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
                        {field: 'kstask.title', title: '任务名'},
                        {field: 'video_id', title: '任务笔记id', sortable: true},
                        {field: 'nickname', title: '昵称', operate: 'LIKE'},
                        {field: 'userid', title: '快手标识', operate: 'LIKE'},
                        {field: 'content', title: '评论内容'},
                        {field: 'phone', title: '手机号'},
                        {field: 'keyword', title: '命中关键词', operate: 'LIKE'},
                        {field: 'comment_time', title: '咨询时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false, sortable: true},
                        {field: 'addtime', title: '采集时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false, sortable: true},
                        {field: 'status', title: '状态',formatter: function(value,row,index){
                            if(row.status==2){
                                return "<span style='color:green; '>已联系</span>";
                            }else if(row.status==1){
                                return "<span style='color:#ccc'>未联系</span>";
                            }
                        }},
                        {field: 'operate', title: __('Operate'), table: table, formatter: function(value,row,index){
                            if(row.uid!="" && row.sec_uid!=''){
                                return '<a class="btn btn-success run_task" style="margin-left:20px;background: #fe3666;" onclick="get_qrcode('+row.id+')" >去关注</a>';
                            }
                            
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

$(document.body).append('<script type="text/javascript" src="/storeadmin/js/jquery.qrcode.min.js"></script>');


function get_qrcode(id){
    // 生成二维码
    $('#qrcode').html('');
    $.post('/store.php/ks_comment/get_qrcode',{id:id},function(data){
        // if(data.code==1){
        //     $('#qrcode').qrcode(data.url);
        //     $('.qrcode-popul').show();
        // }else{
        //     alert(data.msg);
        // }
        window.open(data.url);
        
    },'json');
    
}
