
$(function(){

});

/* 微信提示 */
var btn=document.getElementById('btn');
var clipboard=new Clipboard(btn);
clipboard.on('success', function(e){
	$('#weixin').slideDown().delay(1500).slideUp(500);
	console.log(e);
});
clipboard.on('error', function(e){
	$('#weixin').slideDown().delay(1500).slideUp(500);
	console.log(e);
});

/* 微信弹窗 */
function dkcf()
{
	//alert(111)
	$('#wxnr').fadeIn("fast");
}

/* 微信弹窗 */
function gbcf()
{
	$('#wxnr').fadeOut("fast");
}

var clipboard_zx=new Clipboard('#btn_wx_zx');
clipboard_zx.on('success', function(e){
	$('#weixin_zx').slideDown().delay(1500).slideUp(500);
	console.log(e);
});
clipboard_zx.on('error', function(e){
	$('#weixin_zx').slideDown().delay(1500).slideUp(500);
	console.log(e);
});



function open_zx()
{//alert(111)
	$('#wxnr_zx').fadeIn("fast");
}

/* 微信弹窗 */
function close_zx()
{
	$('#wxnr_zx').fadeOut("fast");
}