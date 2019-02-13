var base_url = "http://localhost:7777/sppkti/";
var comnt_id="0";
var qtime=0;
var answered = new Array();
var reviewed = new Array();

var Timer;
var TotalSeconds;
function CreateTimer(TimerID, Time) {
	Timer = document.getElementById(TimerID);
	TotalSeconds = Time;
	UpdateTimer()
	window.setTimeout("Tick()", 1000);
}
function Tick() {
	if (TotalSeconds <= 0) {
		alert("Time's up!")
		return;
	}
	TotalSeconds -= 1;
	UpdateTimer()
	window.setTimeout("Tick()", 1000);
}
function UpdateTimer() {
	var Seconds = TotalSeconds;
	var Days = Math.floor(Seconds / 86400);
	Seconds -= Days * 86400;
	var Hours = Math.floor(Seconds / 3600);
	Seconds -= Hours * (3600);
	var Minutes = Math.floor(Seconds / 60);
	Seconds -= Minutes * (60);
	var TimeStr = ((Days > 0) ? Days + " days " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds)
	Timer.innerHTML = TimeStr;
}
function LeadingZero(Time) {
	return (Time < 10) ? "0" + Time : + Time;
}
//var myCountdown1 = new Countdown({time:<?php echo $seconds;?>, rangeHi:"hour", rangeLo:"second"});

function questionselection(quid,qname,cid){
	document.getElementById('qbank').style.display="block";
	document.getElementById('qbank').style.visibility="visible";
	var vall="<center><img src='"+base_url+"assets/img/processing.gif'></center>";

	$("#qbank").html(vall);
	$.ajax({
		url: base_url + "simulasi/select_questions/"+quid+"/"+qname+"/"+cid,
		success: function(data){
			$("#qbank").html(data);
		},
		error: function(xhr,status,strErr){
			//alert(status);
		}
	});
}

function closeqselection(quid){
	document.getElementById('qbank').style.display="none";
	document.getElementById('qbank').style.visibility="hidden";
	window.location=base_url+"simulasi/ujian/edit/"+quid;
}

function addquestion(quid,qid){
	$.ajax({
		url: base_url + "simulasi/move/add/"+quid+"/"+qid,
		success: function(data){
		},
		error: function(xhr,status,strErr){
			//alert(status);
		}
	});
}

function qadded(id){
	document.getElementById(id).innerHTML="Added";
}

$(document).ready( function(){
	if(document.getElementById('noq')){
		var noq=document.getElementById('noq').value;
		for(x=0; x <= noq; x++){
			answered[x]=0;
			reviewed[x]=0;
		}
	}
});

function showquestion_afterquiz(id){
	var noq=document.getElementById('noq').value;

	for(var x=0; x<=noq; x++){
		var qid="ques"+x;
		document.getElementById(qid).style.display="none";
		document.getElementById(qid).style.visibility="hidden";
	}
	var qid="ques"+id;
	document.getElementById(qid).style.display="block";
	document.getElementById(qid).style.visibility="visible";
}

function update_answer(oid){
	var cq=document.getElementById('current_question').value;
	var aurl=base_url+"quiz/update_answer/"+cq+"/"+oid+"";
	$.ajax({
		url: aurl
	});
}

function answered_color(){
	var cq=document.getElementById('current_question').value;
	var nq="nq"+cq;
	document.getElementById(nq).style.background="#267B02";
	document.getElementById(nq).style.color="#ffffff";
	answered[cq]=1;
}

function reviewlater(q_type){
	var cq=document.getElementById('current_question').value;
	var nq="nq"+cq;
	if(reviewed[cq]=="0"){
		document.getElementById(nq).style.background="#FFD800";
		document.getElementById(nq).style.color="#ffffff";
		reviewed[cq]=1;
	}else{
		reviewed[cq]=0;
		showquestion(cq,q_type);
	}
}

var firstquestionofcategory=0;

function changecategory(id){
	document.getElementById('current_cate').value=id;
	//hideqnobycate();
}

function hideqnobycate(){
	var jsonvar=document.getElementById('json_category_range').value;
	var arrobj = $.parseJSON(jsonvar);
	var current_cate=document.getElementById('current_cate').value;
	var total_cate=document.getElementById('total_cate').value;

	for( var j=0; j <= total_cate; j++){
		var cateid="cate-"+j;

		if(j != current_cate){
			arrobj[j].forEach(hideqnobyarr);
			//document.getElementById(cateid).style.background="#d4e0ed";
			//document.getElementById(cateid).style.color="#000000";
		}else{
			arrobj[j].forEach(showqnobyarr);
			//document.getElementById(cateid).style.background="#2f72b7";
			//document.getElementById(cateid).style.color="#ffffff";
			showquestion(firstquestionofcategory);
		}
	}
	var categorydivid="cate-"+current_cate;
	var categorynametxt=document.getElementById(categorydivid).innerHTML;
	document.getElementById('category_name_view').innerHTML="You are viewing <b>"+categorynametxt+"</b> section";
}

function hideqnobyarr(element, index, array){
	var nq="nq"+element;
	document.getElementById(nq).style.display="none";
}

function showqnobyarr(element, index, array){
	if(index == 0){
		firstquestionofcategory=element;
	}
	var nq="nq"+element;
	document.getElementById(nq).style.display="block";
	document.getElementById(nq).innerHTML=(index+1);
}

function clearresponse(){
	var current_question=document.getElementById('current_question').value;

	for(var op=0; op <= 3; op++){
		var opn="op-"+current_question+"-"+op;
		document.getElementById(opn).checked = false;
	}
}

function submitform(){
	document.getElementById('testform').submit();
}

function postclass_content(id){
	var cont=document.getElementById('page').innerHTML;
	var formData = {content:cont};
	document.getElementById('page_res').innerHTML="Sending data...";

	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "liveclass/insert_content/"+id,
		success: function(data){
			var d = new Date();
			var dt=d.toString();
			var gt=dt.replace("GMT+0530 (India Standard Time)","");
			document.getElementById('page_res').innerHTML="Sent : "+gt;
		},
		error: function(xhr,status,strErr){
			document.getElementById('page_res').innerHTML="Sending failed!";
		}
	});
}


function get_liveclass_content(id){
	$.ajax({
		url: base_url + "liveclass/get_class_content/"+id,
		success: function(data){
			var d = new Date();
			var dt=d.toString();
			var gt=dt.replace("GMT+0530 (India Standard Time)","");
			document.getElementById('page').innerHTML=data;
			document.getElementById('page_res').innerHTML="Last updated on "+gt;
			setTimeout(function(){
				get_liveclass_content(id);
			},5000);
		},
		error: function(xhr,status,strErr){
			setTimeout(function(){
				get_liveclass_content(id);
			},5000);
		}
	});
	document.getElementById("page").scrollTop = document.getElementById("page").scrollHeight;
}

function get_liveclass_content_2(id){
	$.ajax({
		url: base_url + "liveclass/get_class_content/"+id,
		success: function(data){
			var d = new Date();
			var dt=d.toString();
			var gt=dt.replace("GMT+0530 (India Standard Time)","");
			document.getElementById('page').innerHTML=data;
			document.getElementById('page_res').innerHTML="Last updated on "+gt;
		},
		error: function(xhr,status,strErr){
			setTimeout(function(){
				get_liveclass_content(id);
			},5000);
		}
	});
	document.getElementById("page").scrollTop = document.getElementById("page").scrollHeight;
}

var class_id;

function get_ques_content(id){
	class_id=id;
	$.ajax({
		url: base_url + "liveclass/get_ques_content/"+id,
		success: function(data){
			//alert(data);
			document.getElementById('comment_box').innerHTML=data;
			setTimeout(function(){
				get_ques_content(id);
			},5000);
		},
		error: function(xhr,status,strErr){
			setTimeout(function(){
				get_ques_content(id);
			},5000);
		}
	});
	document.getElementById("comment_box").scrollTop = document.getElementById("comment_box").scrollHeight;
}

function get_ques_content_2(id){
	class_id=id;
	$.ajax({
		url: base_url + "liveclass/get_ques_content/"+id,
		success: function(data){
			//alert(data);
			document.getElementById('comment_box').innerHTML=data;
		},
		error: function(xhr,status,strErr){
			setTimeout(function(){
				get_ques_content(id);
			},5000);
		}
	});
	document.getElementById("comment_box").scrollTop = document.getElementById("comment_box").scrollHeight;
}


function comment(id){
	var comnt=document.getElementById('comment_send').value;
	var formData = {content:comnt};
	document.getElementById('comment_send').value="Sending data...";
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "liveclass/insert_comnt/"+id,
		success: function(data){
			document.getElementById('comment_send').value="";
		},
		error: function(xhr,status,strErr){
			document.getElementById('comment_send').innerHTML="Sending failed!";
		}
	});
}

var publish="0";

function show_options(id,p){
	comnt_id=id;
	publish=p;
	if(publish=="0"){
		document.getElementById('pub').innerHTML="Unpublish";
	}else{
		document.getElementById('pub').innerHTML="Publish";
	}
	$("#comnt_optn").fadeIn();
}

function hide_options(){
	$("#comnt_optn").fadeOut();
}

function publish_comment(){
	var formData = {id:comnt_id,pub:publish};
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "liveclass/publish_comnt/",
		success: function(data){
				$("#comnt_optn").fadeOut();
				 get_ques_content(class_id);
		},
	});
}

function delete_comment(){
	//alert(comnt_id);
	var formData = {id:comnt_id};
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "liveclass/del_comnt/",
		success: function(data){
				$("#comnt_optn").fadeOut();
				 get_ques_content(class_id);
		},
	});
}

function get_ques_type(val){
	//alert(base_url +'qbank/add_new');
	window.location =base_url +'/qbank/add_new/'+val;
}

function add_score(qid,rid,opn_id){
	var div_id='essay_score'+opn_id;
	var div_id2='scorebtn'+opn_id;
	//alert(div_id);
	var op_id=document.getElementById(div_id).value;
	//alert(op_id);
	var formData = {q_id:qid,r_id:rid,opn:op_id};
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "result/add_score/",
		success: function(data){
				if((data.trim())=="1"){
					alert("Score added");
					document.getElementById(div_id).style.display="none";
					document.getElementById(div_id2).style.display="none";
				}else{
					alert("Unable to add score please try again");
				}
		},
	});
}

function showquestion(id){
	//alert(id);
	var check_color_qus="0";
	var noq=document.getElementById('noq').value;
	var cq=document.getElementById('current_question').value;
	if(reviewed[cq]=="0"){
		var s="answers"+cq;
		var opt_checked = document.getElementsByName(s);
		for(var i = 0; i < opt_checked.length; i++){
			if(opt_checked[i].checked){
				var nq="nq"+cq;
				document.getElementById(nq).style.background="#267B02";
				document.getElementById(nq).style.color="#ffffff";
				break;
			}else{
				var nq="nq"+cq;
				document.getElementById(nq).style.background="#D0380E";
				document.getElementById(nq).style.color="#ffffff";
			}
		}
	}
	for(var x=0; x<=noq; x++){
		var qid="ques"+x;
		document.getElementById(qid).style.display="none";
		document.getElementById(qid).style.visibility="hidden";
	}
	var qid="ques"+id;
	document.getElementById(qid).style.display="block";
	document.getElementById(qid).style.visibility="visible";
	document.getElementById('current_question').value=id;
	var rurl=base_url+"simulasi/attempt_update/time/"+cq+"/"+qtime+"";
	$.ajax({
		url: rurl
	});
	qtime=0;
}

//update answer
function update_curr_ans(key,qid){
	if(typeof(qid)==='undefined') qid ="";
	var s="answers"+key;
	var opt_checked = document.getElementsByName(s);
	var oid;
	for(var i = 0; i < opt_checked.length; i++){
		if(opt_checked[i].checked){
			oid = opt_checked[i].value;
			var cq=document.getElementById('current_question').value;
			cq=cq-1;
			//alert(cq);
			var aurl=base_url+"simulasi/attempt_update/answer/"+cq+"/"+oid+"";
			$.ajax({
				url: aurl
			});
		}
	}
}

function check_question(key){
	var div_exp_id="div_exp_id"+key
	var div_exp_id_wrong="div_exp_id_wrong"+key
	var s="answers"+key;
	var rates = document.getElementsByName(s);
	var optn_value;
	for(var i = 0; i < rates.length; i++){
	    if(rates[i].checked){
	        optn_value = rates[i].value;
			var opt_check=optn_value.split("-");
			if(opt_check[1]>0){
				document.getElementById(div_exp_id_wrong).style.display="none";
				document.getElementById(div_exp_id).style.display="block";
			}else{
				document.getElementById(div_exp_id).style.display="none";
				document.getElementById(div_exp_id_wrong).style.display="block";
			}
    	}
	}
}

function check_question_fill(key,q){
	if(typeof(q)==='undefined') q = 1;
	//alert(q);
	var div_exp_id="div_exp_id"+key
	var div_exp_id_wrong="div_exp_id_wrong"+key
	var s="fill_blank"+key;
	var s2="answers"+key;
	var optn_value = document.getElementsByName(s)[0].value;
	var optn_value_user = document.getElementsByName(s2)[0].value;
	var match_check="0"
	var opt_check=optn_value.split("-");
	if(q=="3"){
		var opt_check=opt_check[1].split(",");
		//alert(opt_check[1]);
		for(var i = 0; i < opt_check.length; i++){
			if(opt_check[i]==optn_value_user){
				match_check="1";
			}
		}
		if(match_check=="1"){
			document.getElementById(div_exp_id_wrong).style.display="none";
			document.getElementById(div_exp_id).style.display="block";
		}else{
			document.getElementById(div_exp_id).style.display="none";
			document.getElementById(div_exp_id_wrong).style.display="block";
		}
	}else{
		if(opt_check[1]==optn_value_user){
			document.getElementById(div_exp_id_wrong).style.display="none";
			document.getElementById(div_exp_id).style.display="block";
		}else{
			document.getElementById(div_exp_id).style.display="none";
			document.getElementById(div_exp_id_wrong).style.display="block";
		}
	}
}

function check_question_chekbox(key){
	var div_exp_id="div_exp_id"+key
	var div_exp_id_wrong="div_exp_id_wrong"+key
	var s="answers"+key+"[]";
	var checkboxes = document.getElementsByName(s);
	var vals = "";
	for (var i=0, n=checkboxes.length;i<n;i++) {
		if (checkboxes[i].checked) {
			vals += checkboxes[i].value+",";
		}
	}
	var opt_check=vals.split(",");
	//alert(opt_check.length);
	for (var i=0, n=opt_check.length-1;i<n;i++) {
		var opt_check_score=opt_check[i].split("-");
		if(opt_check_score[1]=="0"){
			document.getElementById(div_exp_id).style.display="none";
			document.getElementById(div_exp_id_wrong).style.display="block";
			break;
		}else{
			document.getElementById(div_exp_id_wrong).style.display="none";
			document.getElementById(div_exp_id).style.display="block";
		}
	}

}

function check_question_match(key){
	var match_check="0";
	var div_exp_id="div_exp_id"+key
	var div_exp_id_wrong="div_exp_id_wrong"+key
	var user_options="answers"+key+"[]";
	var q_options="question_option_val"+key+"[]";
	var correct_ans="question_correct"+key+"[]";
	var user_options_v = document.getElementsByName(user_options);
	var q_options_v = document.getElementsByName(q_options);
	var correct_ans = document.getElementsByName(correct_ans);
	//var checkboxes = document.getElementsByName(s);
	for (var i=0, n=user_options_v.length;i<n;i++) {
		var user_ans=q_options_v[i].value+"="+user_options_v[i].value;
		//alert(user_ans+"--"+correct_ans[i].value);
		if(user_ans!=correct_ans[i].value){
			match_check="1";
			break;
		}
	}
	if(match_check=="0"){
		document.getElementById(div_exp_id_wrong).style.display="none";
		document.getElementById(div_exp_id).style.display="block";
	}else{
		document.getElementById(div_exp_id).style.display="none";
		document.getElementById(div_exp_id_wrong).style.display="block";
	}
}

function showhiddendiv(id){
	if(document.getElementById(id).style.display=="block"){
		document.getElementById(id).style.display="none";
	}else{
		document.getElementById(id).style.display="block";
	}
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}
