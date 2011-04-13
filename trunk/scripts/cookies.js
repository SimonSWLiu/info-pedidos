// JavaScript Document
function setCookie(name, value, time, path) { // 四个参数：名称，值，保存时间（可选），路径（可选）
	var myDays = 365; // 此cookie将保存1年
	if (time != null) myDays = time;
	var exp = new Date();
	exp.setTime(exp.getTime() + myDays * 24 * 60 * 60 * 1000);
	var myPath = "";
	if (path != null) myPath = ";path=" + path;
	document.cookie = name + '=' + escape(value) + ';expires=' + exp.toGMTString() + myPath;
}

function getCookie(name) { // 取cookie
	var arr = document.cookie.match( new RegExp('(^|)' + name + '=([^;]*)(;|$)') );
	if (arr != null) return unescape(arr[2]);
	return null;
}

function delCookie(name) { // 删除cookie
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(name);
//	if (cval != null) document.cookie = name + '=' + cval + ';expires=' + exp.toGMTString();
	if (cval != null) document.cookie = name + '=' + cval + ';expires=0';
}