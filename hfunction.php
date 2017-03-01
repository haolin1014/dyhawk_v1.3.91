<?php

function  str_len($str1,$str2)
{  //将货号短语结合成字符串作为输入，最后输出短信的条数
  //utf-8编码
  //本函数适应于utf-8编码
  //货号的前后两个括号<取货号：>6个，+【递易智能】 6个  共12个字符。 所以短信货号+短语 <=58
  $str=$str1.$str2;
  $all_len=mb_strlen($str,"UTF-8");
  $end_len=$all_len+12+70-1;  //包含70
  $num=floor($end_len/70);
  return  $num;
}

// 验证子账户，如果存在传回总账户号
function checkChildUsername($child_username,$pwd,$db){
	$res = mysql_query("SELECT parent_username,name,password from deeyee.user_child where child_username='$child_username' and status=0 limit 1",$db);
	if(mysql_num_rows($res)>0){
		$data['parent_username'] = mysql_result($res,0, 'parent_username');
		$data['name'] = mysql_result($res,0, 'name');
		$data['password'] = mysql_result($res,0, 'password');
		if($pwd==$data['password']){
			$data['status']=1;
		}else{
			$data['status']=0;//密码不正确
		}
		return $data;
	}
	return false;
}

// whl查询子账户是否存在，如果存在传回总账户号
function searchChildUsername($child_username,$db){
	$res = mysql_query("SELECT parent_username,name from deeyee.user_child where child_username='$child_username' and status=0 limit 1",$db);
	if(mysql_num_rows($res)>0){
		$data['parent_username'] = mysql_result($res,0, 'parent_username');
		$data['name'] = mysql_result($res,0, 'name');
		return $data;
	}
	return false;
}

// whl查询总账户的所有子账户，用逗号拼接成字符串返回。
function getAllChildUsername($username,$db){
	$res = mysql_query("SELECT child_username from deeyee.user_child where parent_username='$username' and status=0",$db);
	$num = mysql_num_rows($res);
	$child_usernames = '';
	if($num>0){
		for($i=0;$i<$num;$i++){
			$child_username = mysql_result($res,$i, 'child_username');
			$child_usernames.=$child_username.',';
		}
		$child_usernames = trim($child_usernames,',');
		return $child_usernames;
	}else{
		return false;
	}
}
?>