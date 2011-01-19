// JavaScript Document 中文
window.onresize = function() {
	$('.leftbar, .main, .main-frame').height($(window).height() - 33);
	$('.leftbar').height($(window).height() - 30);
}

$(function(){
	window.onresize();
	$('input[type=text]').eq(0).focus();
	
	// 点击删除餐厅名功能
//	$('.del-restaurant').click(function(){
//		$del = $(this);
//		$.get('/delr.php', {
//			restaurant: $del.attr('rid')
//		}, function(data){
//			alert('success');
//			window.location.reload();
//		}, 'json');
//	});
	
	// 点击餐厅名管理该餐厅的菜单种类
//	$('.rname').click(function() {
//		var rid = $(this).attr('rid')
//		$.get('/getcategory.php', {
//			rid: rid
//		}, function(data) {
//			// 获取成功，返回的代码嵌入页面中
//			$('#category').html(data);
//		});
//	});
});

/**
 * 左边栏的js处理
 */
 // 单击“我的账户”
$('#myAccount').click(function() {
	$(this).find('ul').stop(true, true);
	$(this).find('ul').slideToggle();
	return false;
});

$('#changePwd').click(function(event) {
	event.stopPropagation();
});

$('#myBalance').click(function(event) {
	event.stopPropagation();
});

$('#recharge').click(function(event) {
	event.stopPropagation();
});

$('#orderHistory').click(function(event) {
	event.stopPropagation();
});








