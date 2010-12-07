// JavaScript Document 中文
window.onresize = function() {
	$('.leftbar, .main, .main-frame').height($(window).height() - 33);
	$('.leftbar').height($(window).height() - 30);
}

$(function(){
	window.onresize();
	$('input[type=text]').eq(0).focus();
});