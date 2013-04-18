function createOverlay(id) {
	var overlay = new Element('div',{});
    overlay.setProperty('id', id + '-overlay');
    overlay.setHTML('<table width="100%" height="100%"><tr><td align="center" valign="middle"><img src="/img/loading.gif" alt="Loading" /></td></tr></table>');
    var zindex = 1;
    var coords = $(id).getCoordinates();
    zindex = 2;
    overlay.setStyles({
            'position': 'absolute',
            'background-color': '#CACACA',
            'top': coords.top+'px',
            'left': coords.left+'px',
            'width': coords.width+'px',
            'height': coords.height+'px',
            'z-index': zindex,
            'opacity':0.2
    });
    overlay.injectBefore($(id));
    /*var dropFx = overlay.effect('background-color', {wait: false});
    dropFx.start('CACACA');*/
    //new Fx.Style(id, 'opacity',{duration: 400, transition: Fx.Transitions.sineInOut}).start(1,0.2);
    new Fx.Style(id+'-overlay', 'opacity',{duration: 100, transition: Fx.Transitions.sineInOut}).start(1,0.6);
}

function removeOverlay(id) {
    if(document.getElementById(id + '-overlay'))
    	var dropFx = $(id+'-overlay').effect('background-color', {wait: false});
    	/*dropFx.start('FFFFFF');
    	$(id+'-overlay').remove();*/
        new Fx.Style(id + '-overlay', 'opacity',{duration: 700, transition: Fx.Transitions.sineInOut, onComplete:function(){$(id+'-overlay').remove();} }).start(0.6,0);
}

function strrpos( haystack, needle, offset){
    var i = haystack.lastIndexOf( needle, offset ); // returns -1
    return i >= 0 ? i : false;
}

function request(page, target, e) {
	if(document.getElementById(target)) createOverlay(target);
	if(e != null)
		new Event(e).stop();
	queryString = page.split('-');
	page = queryString[0];
	for(i = 1; i < queryString.length; i+=2) {
		page = page + '&' + queryString[i] + '=' + queryString[i+1];
	}
	if(page.substr(0, 4) == 'http')
		new Ajax(page + '&rnd=' + Math.random()*1000000, {
			method: 'get', 
			onComplete:function() {
				document.getElementById(target).innerHTML = this.response.text;
				removeOverlay(target);
			} 
		}).request();
	else
		new Ajax('/product.php?page=' + page + '&rnd=' + Math.random()*1000000, {
			method: 'get', 
			onComplete:function() {
				document.getElementById(target).innerHTML = this.response.text;
				removeOverlay(target);
			} 
		}).request();
}