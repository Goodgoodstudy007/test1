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
                        // {checkbox: true},
                        {field: 'task_id', title: __('Task_id')},
                        {field: 'storetask.title', title: '任务名'},
                        {field: 'taskvideo.video_desc', title: '视频',formatter: function(value,row,index){
                            return "<a  href='https://www.douyin.com/video/"+row.taskvideo.aweme_id+"' target='__blank'>"+row.taskvideo.video_desc+"</a>";
                        }},
                        {field: 'username', title: 'D音昵称', operate: 'LIKE'},
                        {field: 'userid', title: 'D音号', operate: 'LIKE'},
                        {field: 'comment', title: '线索内容', operate: 'LIKE'},
                        {field: 'phone', title: '手机号',searchList: {"":'无手机号码',"1":'有手机号码'}, operate: 'LIKE'},
                        // {field: 'digg_count', title: __('Digg_count')},
                        // {field: 'douyin_cid', title: __('Douyin_cid'), operate: 'LIKE'},
                        {field: 'keyword', title: __('Keyword'), operate: 'LIKE'},
                        // {field: 'aweme_count', title: __('Aweme_count')},
                        // {field: 'following_count', title: __('Following_count')},
                        // {field: 'follower_count', title: __('Follower_count')},
                        // {field: 'total_favorited', title: __('Total_favorited')},
                        {field: 'comment_time', title: '咨询时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false, sortable: true},
                        {field: 'addtime', title: '挖掘时间', operate:'RANGE', addclass:'datetimerange', autocomplete:false, sortable: true},
                        {field: 'status', title: '状态', searchList: {"1":'未联系',"2":'已联系'},formatter: function(value,row,index){
                            if(row.status==2){
                                return "<span style='color:green; '>已联系</span>";
                            }else if(row.status==1){        
                                return "<span style='color:#ccc'>未联系</span>";
                            }
                        }},
                        {field: 'operate', title: __('Operate'), table: table, formatter: function(value,row,index){
                            if(row.uid!="" && row.sec_uid!=''){
                                return '<a class="btn btn-success run_task" style="margin-left:20px;" onclick="get_qrcode('+row.id+')" >扫码私信</a>';
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
    $.post('/store.php/video_comment/get_qrcode',{id:id},function(data){
        if(data.code==1){
            $('#qrcode').qrcode(data.url);
            $('.qrcode-popul').show();
        }else{
            alert(data.msg);
        }
        
    },'json');
    
}
