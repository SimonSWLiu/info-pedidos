// JavaScript Document 中文
window.onresize = function() {
	$('.leftbar, .main, .main-frame').height($(window).height() - 33);
	$('.leftbar').height($(window).height() - 30);
}

$(function(){
	window.onresize();
	$('input[type=text]').eq(0).focus();
	
	// 点击删除餐厅名功能
	$('.del-restaurant').click(function(){
		$del = $(this);
		$.get('/delr.php', {
			restaurant: $del.attr('rid')
		}, function(data){
			alert('success');
			window.location.reload();
		}, 'json');
	});
});