function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}
var height_topnav = 50;
var height_footer = 36;
function set_auto_height() {
	var height_window = window.innerHeight;
	document.getElementsByClassName('auto-height')[0].style.minHeight = (height_window - height_topnav - height_footer)+"px";
}
document.onreadystatechange = function(e) {
	if (document.readyState === 'interactive') {
		$sidenav = getCookie('sidenav');
		if ($sidenav == 'active' || $sidenav == '') {
			var element = document.getElementsByTagName("body")[0];
			element.classList.add("active-sidenav");
		}
		set_auto_height();
	}
};
$(document).on("click","body [data-toggle=collapse]",function() {
	if ($('body').hasClass('active-sidenav')) {
		$('body').removeClass('active-sidenav');
		document.cookie="sidenav=nonactive";
	}else{
		$('body').addClass('active-sidenav');
		document.cookie="sidenav=active";
	}
});
$(window).resize(function(){
	set_auto_height();
});

$(function() {
    var min = false;
    if ($(window).width() < 576) {
        if ($('body').hasClass('active-sidenav')) {
            $('body').removeClass('active-sidenav');
            min = true;
        }
    }
    $(window).resize(function(){
        if ($(window).width() < 576) {
            if ($('body').hasClass('active-sidenav')) {
        		$('body').removeClass('active-sidenav');
                min = true;
        	}
        }else if (min) {
            min = false;
            if (!$('body').hasClass('active-sidenav')){
                $('body').addClass('active-sidenav');
        	}
        }
    });
	// datatables
	if ($.fn.DataTable !== undefined) {
		$('.datatables').DataTable();
		$('.datatables-noorder-first-last').DataTable({
			columnDefs: [
			{ orderable: false, targets: [-1, 0] }
			],
		});
		$('.datatables-noorder-last').DataTable({
			columnDefs: [
			{ orderable: false, targets: -1 }
			]
		});
	}
	// bs-custom-file-input
	if (typeof bsCustomFileInput !== 'undefined') {
		bsCustomFileInput.init();
	}

	// bootstrap-select
	// $('.selectpicker').selectpicker();
	
	// tinymce
	var tinymce_option = {
		mini: {
			height: 100,
			menubar:false,
			toolbar1: 'undo redo | styleselect | bold underline italic | bullist numlist | outdent indent | table | link unlink | filemanager image | forecolor backcolor | code',
		}, 
		full: {
			height: 200,
			toolbar1: 'undo redo | styleselect | bold underline italic | bullist numlist | outdent indent | table | link unlink | filemanager image | forecolor backcolor | code',
			image_advtab: true,
		}
	};
	var base_url = $('base').attr('href');
	var tinymce_css = [base_url + "css/bootstrap.min.css"];
	// var tinymce_css = [base_url + "http://project/template/dashmaster/css/bootstrap.min.css"];
	$('[tinymce]').each(function() {
		var el = $(this);
		var options = {
			selector: '#' + el.attr('id'),
			convert_urls: false,
			elementpath: true,
			relative_urls: true,
			document_base_url : base_url,
			theme: 'modern',
			skin : 'kopiskin',
			plugins: [
				"autolink link image imagetools lists advlist charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons paste textcolor code"
			],
			content_style: "@import '" + tinymce_css.join("'; @import '") + "';  body{ margin: .5rem 1rem; }",
		};
		jQuery.extend(options, tinymce_option[el.attr('tinymce')]);
		if (el.attr('tinymce-height') != undefined) {
			options.height = el.attr('tinymce-height');
			console.log(el.attr('tinymce-height'));
		}
		tinymce.init(options);
	});
});

function auto_number(el) {
	var i = 1;
	el.each(function(e) {
		$(this).text((i) + '.');
		i++;
	});
}

$(document).on('click', '[confirm]', function(event) {
	var el = $(this);
	return confirm(el.attr('confirm'));
});

$(document).on('click', '[hide]', function(event) {
	var el = $(this);
	var target = $(el.attr('hide'));
	target.addClass('hide');
	return false;
});

$(document).on('click', '[show]', function(event) {
	var el = $(this);
	var target = $(el.attr('show'));
	target.removeClass('hide');
	return false;
});

$(document).on('change', '[show-change]', function(event) {
	var el = $(this);
	var target = $(el.attr('show-change'));

	if (target.hasClass('hide')) {
		target.removeClass('hide');
	}else{
		target.addClass('hide');
	}
});

$(document).on('change', '[show-on]', function(event) {
	var el = $(this);
	var target = $(el.attr('show-on'));

	if (el.val() === el.attr('show-on-value') && target.hasClass('hide')) {
		target.removeClass('hide');
	}else{
		target.addClass('hide');
	}
});

$(document).on('change', '[duplicate-value-to]', function(event) {
	var el = $(this);
	var target = $(el.attr('duplicate-value-to'));
	var value = el.val();
	target.val(value);
});

$(document).on('change', '[show-parent-on]', function(event) {
	var el = $(this);
	var target = $(el.attr('show-parent-on')).parent();

	if (el.val() === el.attr('show-on-value') && target.hasClass('hide')) {
		target.removeClass('hide');
	}else{
		target.addClass('hide');
	}
});

/*
select tab
 */
$(document).on('change', '[select-tab]', function(event) {
	var el = $(this);
	var target = $(el.attr('select-tab'));

	$(el.attr('select-tab') + ' [select-name]').each(function() {
		if (!$(this).hasClass('hide')) {
			$(this).addClass('hide');
		}		
	});
	$(el.attr('select-tab') + ' [select-name=' + el.val() + ']').removeClass('hide');
});
/*
multiple form 
 */
$(document).on('click', '[multiform-add]', function(event) {
	var el = $(this);
	var master = $('[multiform-master=' + el.attr('multiform-add') + ']');

	var string_item = master.html();
	var no = parseInt(el.attr('multiform-no'));
	var new_string_item = string_item.split('%no%').join(no);
	el.attr('multiform-no', (no + 1));

	$(new_string_item).appendTo('[multiform-list=' + el.attr('multiform-add') + ']');
	return false;
});

$(document).on('click', '[multiform-remove]', function(event) {
	var el = $(this);
	el.parents('[multiform-item]').remove();

	return false;
});