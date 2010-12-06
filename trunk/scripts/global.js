// JavaScript Document 中文
window.onresize = function() {
	$('.leftbar, .main').height($(window).height() - 30);
}

$(function(){
	$('.leftbar, .main').height($(window).height() - 30);
	$('input[type=text]').eq(0).focus();
});