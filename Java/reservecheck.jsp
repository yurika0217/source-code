<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ page import=" bean.ReserveBean"%>
<%@ page import=" bean.RoomBean" %>
<%@ page import=" bean.UserBean" %>
<%@ page import="classes.ReserveLogic"%>
<%@ page import="java.util.*"%>
<%
//セッションget
ReserveBean reserve =(ReserveBean)session.getAttribute("reserve");
List<RoomBean> room = (List<RoomBean>)session.getAttribute("room");
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>e-Room｜会議室予約確認ページ</title>
</head>
<body>
	<%@ include file="header.jsp"%>
	<form action = "ReservationServlet" method = "post">
	<h3><strong>

	<%=reserve.getUserid()  %>

	</strong> 様</h3>
	<hr>
	<h3>会議室名</h3>

	<%= room.get(0).getName() %>

	<h3>貸出日</h3>

	<%= reserve.getDate() %>

	<h3>貸出時間</h3>
 		開始時刻：${reserve.start}<br>

 		終了時刻：${reserve.end}<br>

 	<h3>お支払方法</h3>
 		現金のみ<br>

 	<h3>利用人数</h3>
 			${reserve.number}人 <br>
 	<h3>利用目的</h3>
 			${reserve.purpose}<br>
 	<h3>利用料金</h3>
 			<%=String.format("%,d",reserve.getCharge())%>円<br>
	<hr>
 	<input type = "submit" value = "送信">
 	</form>
	<form action = "reserve.jsp" method = "post">
 	<input type = "submit" value = "戻る">
 	</form>
</body>
</html>