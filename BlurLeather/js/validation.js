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
function validate(frm){
    var test,val,nm,p,title;
    var vld=false;
    for(var i=0; i<frm.length;i++){
        test =  frm[i].className;
		title =  frm[i].title;
		nm =  frm[i].id;
        val = $.trim(frm[i].value);
		$('#err_'+nm).removeClass('red');
		$('#'+nm).css('color','#000');
		if(title==val){frm[i].value='';}
		if(test.indexOf('R')!=-1){
			if (val!= "" && val!=title) {
				vld = Valid(test,val);
            }else if (test.charAt(0) == 'R') { 
                vld = false;
            }
        }else{ 
			if(val!='')
				vld = Valid(test,val);
		}
		if(vld){if(!conf(test,val)){ $('#err_'+nm).addClass('red'); $('#'+nm).css('color','red').focus(); ShowError(title + ' not matched!'); return false;}}
		if (!vld) { $('#err_'+nm).addClass('red'); $('#'+nm).css('color','red').focus(); ShowError('Enter a valid ' + title); return false;}
    } 
	$('#error-data').fadeOut(0); return true;
}
function ShowError(er){
	$('#error-data').html(er).fadeIn(1000); setTimeout("$('#error-data').fadeOut(100);",10000);
}

function Valid(test,val){
	if (test.indexOf('isEmail') != -1) {
		if (Is_Email(val)==false) return false;
	} else if (test.indexOf('isNo') != -1) {
		if (isNaN(val)) return false;
	} else if (test.indexOf('isDoc') != -1) {
		if (Is_Doc(val)==false) return false;
	} else if (test.indexOf('isImg') != -1) {
		if (Is_Img(val)==false) return false;
	} else if (test.indexOf('isDate') != -1) {
		if (Is_Date(val)==false) return false;
	}else if (test.indexOf('isTime') != -1) {
		if (Is_Time(val)==false) return false;
	}else if (test.indexOf('isMD') != -1) {
		if (Is_MonthDay(val)==false) return false;
	} return true;
}
function conf(test,val){
	if (test.indexOf('CM-') != -1) {
		var st = test.substring(test.indexOf("CM-")+3,test.indexOf("-CM"));
		return ($('#'+st).val()==val);
	} return true;
}
function Is_Email(email) {
    var reg1 = /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/; 
    var reg2 = /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,4})(\]?)$/;
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
		if(ext=="mov" || ext=="mp4" || ext=="flv" || ext=="3gp" || ext=="avi" || ext=="mpg" || ext=="mpeg" || ext=="wmv"){
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
	str = str.toString().replace(/\#/g,"!33!");
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
function popitup(url) {
	newwindow=window.open(url,'name','height=400,width=600');
	if (window.focus) {newwindow.focus()}
	return false;
}