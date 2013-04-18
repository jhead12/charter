function RoundOff(val){
	if(val.toString().indexOf(".")!=-1){
		var arr=val.toString().split(".");
		if(arr[1].length>2){
			return arr[0] + "." + arr[1].substr(0,2);
		}else{
			return arr[0] + "." +arr[1];
		}
	}else{
		return val+".00";
	}
}
function ltrim(str) { 
	for(var k = 0; k < str.length && isWhitespace(str.charAt(k)); k++);
	return str.substring(k, str.length);
}
function rtrim(str) {
	for(var j=str.length-1; j>=0 && isWhitespace(str.charAt(j)) ; j--) ;
	return str.substring(0,j+1);
}

function isWhitespace(charToCheck) {
	var whitespaceChars = " \t\n\r\f";
	return (whitespaceChars.indexOf(charToCheck) != -1);
}

function trim_string(str) {
	return ltrim(rtrim(str));
}

function validate(frm){
    var test,val,nm,p,title;
    var errors=false;
    for(var i=0; i<frm.length;i++){
        test =  frm[i].className;
		title =  frm[i].title;
        val = trim_string(frm[i].value);
		nm = frm[i].id;
		if(test.indexOf('R')!=-1){
			if(frm[i].type=='checkbox'){
				if(frm[i].checked!=true){errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');}
			}else if (val!= "" && val!=title) {
                $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');
                if (test.indexOf('isEmail') != -1) {
                    if (Is_Email(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
                } else if (test.indexOf('isNo') != -1) {
                    if (isNaN(val)) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
				} else if (test.indexOf('isDoc') != -1) {
                    if (Is_Doc(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
				} else if (test.indexOf('isImg') != -1) {
                    if (Is_Img(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
                } else if (test.indexOf('isDate') != -1) {
                    if (Is_Date(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
                }else if (test.indexOf('isTime') != -1) {
                    if (Is_Time(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
                }else if (test.indexOf('isMD') != -1) {
                    if (Is_MonthDay(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
                }else if (test.indexOf('isURL') != -1) {
                    if (isValidURL(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
                }
            }else if (test.charAt(0) == 'R') { 
                errors = true;
				$('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); 
            }
        }else if(test.indexOf('isEmail')!=-1){
            if (val!= "") {
                if (Is_Email(val)==false) { errors = true;$('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
            }else{
                $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');
            }
        }else if(test.indexOf('isNo')!=-1){
            if (val!= "") {
                if (isNaN(val)) { errors = true;$('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
            }else{
                $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');
            }
        }else if (test.indexOf('isDate') != -1) {
            if (val!= "") {
                if (Is_Date(val)==false) { errors = true;$('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
            }else{
                $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');
            }
		}else if (test.indexOf('isDoc') != -1) {
			if (val!= "") {
				if (Is_Doc(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
			}else{
				$('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');
			}
		}else if (test.indexOf('isImg') != -1) {if (val!= "") {if (Is_Img(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); } }else{ $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');}
		}else if (test.indexOf('isVideo') != -1) {if (val!= "") {if (Is_Video(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); } }else{ $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');}
		}else if (test.indexOf('isAudio') != -1) {if (val!= "") {if (Is_Audio(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); } }else{ $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');}
        }else if (test.indexOf('isTime') != -1) {
            if (val!= "") {
                if (Is_Time(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
            }else{
                $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');
            }
        }else if (test.indexOf('isMD') != -1) {
            if (val!= "") {
                if (Is_MonthDay(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
            }else{
                $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');
            }
        }else if (test.indexOf('isURL') != -1) {
			if(val!= "") {
                if (isValidURL(val)==false) { errors = true; $('#err_'+nm).addClass('error'); $('#'+nm).addClass('error'); } else { $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error'); }
            }else{
                $('#err_'+nm).removeClass('error');$('#'+nm).removeClass('error');
            }
        }
		if (errors) { $('#'+nm).focus(); ShowError('Enter a valid ' + title); return false;}
    } if (errors) {  ShowError('Please Fill required fields or correct data.'); return false;}
    else {  $('#error-data').fadeOut(0); return true; }
}
function ShowError(er){
	 $('#error-data').html(er);
	$('#error-data').fadeIn(1000); setTimeout("$('#error-data').fadeOut(100);",10000);
}
function Is_Email(email){
    var reg1 = /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/; 
    var reg2 = /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/;
    if (!(!reg1.test(email) && reg2.test(email))) return false;
    else return true;
}
function Is_Date(dt){
    var tdate = new Date();
    splitDate = dt.split("/");
    refDate = new Date(splitDate[1]+ "/" + splitDate[0]+"/"+splitDate[2]);
    if (splitDate[1] < 1 || splitDate[1] > 12 || refDate.getDate() != splitDate[0] || splitDate[2].length != 4)
    {
        return false;
    }else{
        if(splitDate[2]<(tdate.getFullYear() -100) || splitDate[2]>(tdate.getFullYear() +100)){
            return false;
        }else{
            return true;
        }
    }
}
function Is_MonthDay(dt){
    splitDate = dt.split("/");
    if (splitDate[1] < 1 || splitDate[1] > 12 || splitDate[0] < 1 || splitDate[0] > 31)
    {
        return false;
    }else{
        return true;
    }
}
function numbersonly(obj,e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if(unicode==46){
        if (obj.value.toString().indexOf(".",0)>0){return false}
    }else if (unicode==9){
    }else if (unicode!=8){
        if (unicode<48||unicode>57) {return false;}
    }
}
function entersearch(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if(unicode==13){
        search();
    }
}

function Is_Time(timeStr) {
    var timePat = /^(\d{1,2}):(\d{2})?(\s?(AM|am|PM|pm))?$/;
    var matchArray = timeStr.match(timePat);
    if (matchArray == null) {
        return false;
    }
    hour = matchArray[1];
    minute = matchArray[2];
    ampm = matchArray[3];

    if (hour < 0  || hour > 23) {
        return false;
    }
    if (minute<0 || minute > 59) {
        return false;
    }
    return true;
}


function showOfDiv(div) {
    if(!div) {return;}
    div = typeof div === "string" ? document.getElementById(div) : div;
    var elms = div.getElementsByTagName("*");
    for(var i = 0, maxI = elms.length; i < maxI; ++i) {
        if(elms[i].type=="text" || elms[i].type=="select-one"){
            elms[i].focus();
            break;
        }
    }
}
function Is_Doc(val){
	if(val.indexOf(".")>0){
		var arr=val.split(".");
		var fnd = arr.length-1;
		var ext = arr[fnd].toLowerCase();
		if(ext=="doc" || ext=="docx" || ext=="pdf" || ext=="txt" || ext=="xls" || ext=="xlsx" || ext=="ppt" || ext=="pptx" || ext=="jpg" || ext=="jpeg" || ext=="png" || ext=="gif" || ext=="bmp"){
			return true;
		}
	}
	return false;
}
function Is_Img(val){
	if(val.indexOf(".")>0){
		var arr=val.split(".");
		var fnd = arr.length-1;
		var ext = arr[fnd].toLowerCase();
		if(ext=="jpg" || ext=="jpeg" || ext=="png" || ext=="gif"){
			return true;
		}
	}
	return false;
}
function Is_Video(val){
	if(val.indexOf(".")>0){
		var arr=val.split(".");
		var fnd = arr.length-1;
		var ext = arr[fnd].toLowerCase();
		if(ext=="mov" || ext=="mp4" || ext=="flv" || ext=="3gp" || ext=="avi" || ext=="mpg" || ext=="mpeg" || ext=="wmv"  || ext=="wma" || ext=="wav"){
			return true;
		}
	}
	return false;
}
function Is_Audio(val){
	if(val.indexOf(".")>0){
		var arr=val.split(".");
		var fnd = arr.length-1;
		var ext = arr[fnd].toLowerCase();
		if(ext=="m4p" || ext=="mp3" || ext=="ogg" || ext=="wav" || ext=="mid" || ext=="wma"){
			return true;
		}
	}
	return false;
}

function replacehash(val){
    var str = val.toString().replace(/&/g,"!11!");
	str = str.toString().replace(/\+/g,"!22!");
    return str;
}
function GetString(obj){
   	var str = "";
   	for(var i=0;i<obj.elements.length;i++){
    	str += obj.elements[i].name + "=" + obj.elements[i].value +"&";
   	}
	str = str.toString().substr(0,str.length-1);
   	return str;
}
function tabs(cur,tot){
	for(var i=1;i<=tot;i++){
    	if(i==cur){
			$('#tab'+i).addClass('selected');
		}else{
			$('#tab'+i).removeClass('selected');
		}
   	}
}
function isValidURL(url){
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }

}