var hc = {};

hc.init = function() {
	$('#inputbox').html('<span id="carrot">></span><input id="input" type="text">');
	hc.input = $('#input');
	hc.output = $('#outputbox');
	hc.commands_history = new Array();
	hc.timers = new Array();
	hc.history_pointer = 0;
	hc.input.focus();
	hc.exec('login');

	$(document).on('keydown',function() {
		hc.input.focus();
	});

	$(document).on('keyup',function(event) {
		switch(event.keyCode){
			case 13:
				hc.command = hc.input.val();
				if (hc.command) {
					if (!hc.running) {
						hc.commands_history[hc.commands_history.length] = hc.command;
						hc.history_pointer = hc.commands_history.length;
					}
					hc.run(hc.command,hc.running);
				}
			break;
			case 38: // this is the arrow up
				if (hc.history_pointer > 0) {
					hc.history_pointer--;
					hc.input.val(hc.commands_history[hc.history_pointer]);
				}
			break;
			case 40: // this is the arrow down
				if (hc.history_pointer < hc.commands_history.length - 1 ) {
					hc.history_pointer++;
					hc.input.val(hc.commands_history[hc.history_pointer]);
				}
			break;
		}
	});

} 

hc.run = function(command) {
	hc.exec(command,true);
}

hc.exec = function(command,showlast) {
	$.postJSON('exec.php',{command: command, session: 'abc123'}, function(data, textStatus, jqXHR){
		hc.data = data;
		hc.textStatus = textStatus;
		hc.jqXHR = jqXHR;
		if (!data.carrot) $('#carrot').addClass('hide');
		else $('#carrot').removeClass('hide');
		if (data.command && showlast) hc.output.append(data.command + chr(10));
		hc.output.append(data.output);
		hc.input.val('').focus();
		$(window).scrollTop($(document).height());
		if (data.local)
			hc.timers[data.timername] = setInterval(new Function(data.code),data.timer);
	});
}

hc.clearTimer = function(name) {
	clearTimeout(hc.timers[name]);
}

hc.print = function(output) {
	hc.output.append(output);
	hc.input.val('').focus();
	$(window).scrollTop($(document).height());
}

hc.printl = function(output) {
	hc.output.append(output);
	hc.output.append(chr(10));
	hc.input.val('').focus();
	$(window).scrollTop($(document).height());
}

$(document).ready(function() {
	hc.init();
});

jQuery.extend({
  postJSON: function (url, data, callback) {
    return jQuery.post(url, data, callback, 'json');
  }
});

function chr(num) {
  return String.fromCharCode(num);
}
