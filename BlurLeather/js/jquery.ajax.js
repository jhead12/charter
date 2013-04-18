function senddata(page,str,recId){
	$('.prog').fadeIn(1000);
	//alert(page+"\n"+str+"\n"+recId);
	$.post("ajax/"+page+".php", str + '&rnd='+Math.random(),
	function(data){
		$('.prog').fadeOut(1000);
	//	alert(data);
		if(data!=''){
			if(recId!=''){
				if(data.indexOf("|g|")>0){
					var arr = data.split("|g|");
					if(arr[0]=='script'){
						$('#'+recId).html(arr[1]).fadeIn(1000);
						setTimeout(arr[2],1);
					}else{
						$('#'+recId).html(data).fadeIn(1000);
					}
				}else{
					$('#'+recId).html(data).fadeIn(1000);
				}
				$('body,html').animate({scrollTop:$('#'+recId).offset().top-84},1000);
			}else{
				if(data.indexOf("|g|")>0){
					var arr = data.split("|g|");
					if(arr[0]=='script'){
						if(arr[1]!='')
							$('#error-data').html(arr[1]).fadeIn(1000);
						setTimeout(arr[2],1);
					}else{
						$('#error-data').html(data).fadeIn(1000);
					}
				}else{
					$('#error-data').html(data).fadeIn(1000);
				}
				setTimeout("$('#error-data').fadeOut(1000);",10000);
			}
		}
	}, "");
}