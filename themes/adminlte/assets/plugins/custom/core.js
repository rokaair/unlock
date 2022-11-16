 $(document).ready(function() {

    $('body').on('click', '#delete', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form').submit();
    });
   
    $('body').on('click', '#excel', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
    $('body').on('click', '#pdf', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
    $('body').on('click', '#labelProducts', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
});
function getSlug(title, type) {
    var slug_url = base_url+'panel/settings/slug';
    $.get(slug_url, {title: title, type: type}, function (slug) {
        $('#slug').val(slug).change();
    });
}
function img_hl(x) {
    var image_link = (x == null || x == '') ? 'no_image.png' : x;
    return '<div class="text-center"><a href="'+base_url+'assets/uploads/' + image_link + '" data-toggle="lightbox"><img src="'+base_url+'assets/uploads/thumbs/' + image_link + '" alt="" style="width:30px; height:30px;" /></a></div>';
}
function check_add_item_val() {
    $('#add_item').bind('keypress', function (e) {
        if (e.keyCode == 13 || e.keyCode == 9) {
            e.preventDefault();
            $(this).autocomplete("search");
        }
    });
}
function formatDecimal(x, d) {
    // if (!d) { d = 2; }
    // return parseFloat(accounting.formatNumber(x, d, ',', '.'));
    return parseFloat(Math.round(x));

}
function formatMoney(x, symbol) {
    if (!symbol) { symbol = ''; }
    return symbol + accounting.formatNumber(x, 0, '');
}
function formatNumber(x, d) {
    if(!d && d != 0) { d = 2; }
    return accounting.formatNumber(x, d, '');
}

$(document).on('click', '*[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

function row_status(x) {
    if(x == null) {
        return '';
    } else if(x == 'pending') {
        return '<div class="text-center"><span class="label label-warning">'+[x]+'</span></div>';
    } else if(x == 'completed' || x == 'paid' || x == 'sent' || x == 'received') {
        return '<div class="text-center"><span class="label label-success">'+[x]+'</span></div>';
    } else if(x == 'partial' || x == 'transferring' || x == 'ordered') {
        return '<div class="text-center"><span class="label label-info">'+[x]+'</span></div>';
    } else if(x == 'due' || x == 'returned') {
        return '<div class="text-center"><span class="label label-danger">'+[x]+'</span></div>';
    } else {
        return '<div class="text-center"><span class="label label-default">'+[x]+'</span></div>';
    }
}


function attachment(x) {
    if (x != null) {
        return '<a href="' + site.base_url + 'files/' + x + '" target="_blank"><i class="fa fa-chain"></i></a>';
    }
    return x;
}
function fld(oObj) {
    if (oObj != null) {
        var aDate = oObj.split('-');
        var bDate = aDate[2].split(' ');
        year = aDate[0], month = aDate[1], day = bDate[0], time = bDate[1];
        return day + "." + month + "." + year + " " + time;
    } else {
        return '';
    }
}
function checkbox(x) {
    
    return '<div class="text-center" style="text-align: center;"><input class="checkbox multi-select" type="checkbox" name="val[]" value="' + x + '" /></div>';
}
function currencyFormat(x) {
    if (x != null) {
        return '<div class="text-center">'+formatMoney(x)+'</div>';
    } else {
        return '<div class="text-center">0</div>';
    }
}

$('body').on('click', '#delete', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form').submit();
    });
$('body').on('click', '#excel', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
    $('body').on('click', '#pdf', function(e) {
        e.preventDefault();
        $('#form_action').val($(this).attr('data-action'));
        $('#action-form-submit').trigger('click');
    });
$(document).on('click', '.po', function(e) {
        e.preventDefault();
        $('.po').popover({html: true, placement: 'left', trigger: 'manual'}).popover('show').not(this).popover('hide');
        return false;
    });
    $(document).on('click', '.po-close', function() {
        $('.po').popover('hide');
        return false;
    });
    $(document).on('click', '.po-delete', function(e) {
        var row = $(this).closest('tr');
        e.preventDefault();
        $('.po').popover('hide');
        var link = $(this).attr('href');
        var return_id = $(this).attr('data-return-id');
        $.ajax({type: "get", url: link,
            success: function(data) { $('#'+return_id).remove(); row.remove(); if (data) { addAlert(data, 'success'); } },
            error: function(data) { addAlert('Failed', 'danger'); }
        });
        return false;
    });
    function addAlert(message, type) {
        $('.alerts-con').empty().append(
            '<div class="alert alert-' + type + '">' +
            '<button type="button" class="close" data-dismiss="alert">' +
            '&times;</button>' + message + '</div>');
    }
    $(document).on('click', '.po-delete1', function(e) {
        e.preventDefault();
        $('.po').popover('hide');
        var link = $(this).attr('href');
        var s = $(this).attr('id'); var sp = s.split('__')
        $.ajax({type: "get", url: link,
            success: function(data) { if (data) { addAlert(data, 'success'); } $('#'+sp[1]).remove(); },
            error: function(data) { addAlert('Failed', 'danger'); }
        });
        return false;
    });
   
function set_page_focus() {
    if (site.settings.set_focus == 1) {
        $('#add_item').attr('tabindex', an);
        $('[tabindex='+(an-1)+']').focus().select();
    } else {
        $('#add_item').attr('tabindex', 1);
        $('#add_item').focus();
    }
    $('.rquantity').bind('keypress', function (e) {
        if (e.keyCode == 13) {
            $('#add_item').focus();
        }
    });
}
function is_numeric(mixed_var) {
    var whitespace =
    " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
        1)) && mixed_var !== '' && !isNaN(mixed_var);
}
function is_valid_discount(mixed_var) {
    return (is_numeric(mixed_var) || (/([0-9]%)/i.test(mixed_var))) ? true : false;
}
$('body').on('hidden.bs.modal', '.modal', function () {
    $(this).removeData('bs.modal');
});

$('#myModal').on('hidden.bs.modal', function() {
        $(this).find('.modal-dialog').empty();
        //$(this).find('#myModalLabel').empty().html('&nbsp;');
        //$(this).find('.modal-body').empty().text('Loading...');
        //$(this).find('.modal-footer').empty().html('&nbsp;');
        $(this).removeData('bs.modal');
    });
function fixAddItemnTotals() {
    var ai = $("#sticker");
    var aiTop = (ai.position().top)+250;
    var bt = $("#bottom-total");
    $(window).scroll(function() {
        var windowpos = $(window).scrollTop();
        if (windowpos >= aiTop) {
            ai.addClass("stick").css('width', ai.parent('form').width()).css('zIndex', 2);
            ai.css('top', '40px');
            $('#add_item').removeClass('input-lg');
            $('.addIcon').removeClass('fa-2x');
        } else {
            ai.removeClass("stick").css('width', bt.parent('form').width()).css('zIndex', 2);
            ai.css('top', 0);
            $('#add_item').addClass('input-lg');
            $('.addIcon').addClass('fa-2x');
        }
        if (windowpos <= ($(document).height() - $(window).height() - 120)) {
            bt.css('position', 'fixed').css('bottom', 0).css('width', bt.parent('form').width()).css('zIndex', 2);
        } else {
            bt.css('position', 'static').css('width', ai.parent('form').width()).css('zIndex', 2);
        }
    });
}
function ItemnTotals() {
    fixAddItemnTotals();
    $(window).bind("resize", fixAddItemnTotals);
}
$('input[type="checkbox"],[type="radio"]').not('.skip').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $(document).on('ifChecked', '.checkth, .checkft', function(event) {
    $('.checkth, .checkft').iCheck('check');
    $('.multi-select').each(function() {
        $(this).iCheck('check');
    });

});
$(document).on('ifUnchecked', '.checkth, .checkft', function(event) {
    $('.checkth, .checkft').iCheck('uncheck');
    $('.multi-select').each(function() {
        $(this).iCheck('uncheck');
    });
});
$(document).on('ifUnchecked', '.multi-select', function(event) {
    $('.checkth, .checkft').attr('checked', false);
    $('.checkth, .checkft').iCheck('update');
});
$.extend(true,$.fn.dataTable.defaults,{sDom:"<'row'<'col-md-6 text-left'l><'col-md-6 text-right'f>r>t<'row'<'col-md-6 text-left'i><'col-md-6 text-right'p>>",sPaginationType:"bootstrap","fnDrawCallback":function(){$(".tip").tooltip({html: true});$(".popnote").popover();$('.checkbox').iCheck({checkboxClass:'icheckbox_square-blue',radioClass:'iradio_square-blue',increaseArea:'20%'});$("input").addClass('input-xs');$("select").addClass('select input-xs');}});

$.extend($.fn.dataTableExt.oStdClasses,{sWrapper:"dataTables_wrapper form-inline"});$.fn.dataTableExt.oApi.fnPagingInfo=function(a){return{iStart:a._iDisplayStart,iEnd:a.fnDisplayEnd(),iLength:a._iDisplayLength,iTotal:a.fnRecordsTotal(),iFilteredTotal:a.fnRecordsDisplay(),iPage:a._iDisplayLength===-1?0:Math.ceil(a._iDisplayStart/a._iDisplayLength),iTotalPages:a._iDisplayLength===-1?0:Math.ceil(a.fnRecordsDisplay()/a._iDisplayLength)}};$.extend($.fn.dataTableExt.oPagination,{bootstrap:{fnInit:function(e,b,d){var a=e.oLanguage.oPaginate;var f=function(g){g.preventDefault();if(e.oApi._fnPageChange(e,g.data.action)){d(e)}};$(b).append('<ul class="pagination pagination-sm"><li class="prev disabled"><a href="#"> '+a.sPrevious+'</a></li><li class="next disabled"><a href="#">'+a.sNext+" </a></li></ul>");var c=$("a",b);$(c[0]).bind("click.DT",{action:"previous"},f);$(c[1]).bind("click.DT",{action:"next"},f)},fnUpdate:function(c,k){var l=5;var e=c.oInstance.fnPagingInfo();var h=c.aanFeatures.p;var g,m,f,d,a,n,b=Math.floor(l/2);if(e.iTotalPages<l){a=1;n=e.iTotalPages}else{if(e.iPage<=b){a=1;n=l}else{if(e.iPage>=(e.iTotalPages-b)){a=e.iTotalPages-l+1;n=e.iTotalPages}else{a=e.iPage-b+1;n=a+l-1}}}for(g=0,m=h.length;g<m;g++){$("li:gt(0)",h[g]).filter(":not(:last)").remove();for(f=a;f<=n;f++){d=(f==e.iPage+1)?'class="active"':"";$("<li "+d+'><a href="#">'+f+"</a></li>").insertBefore($("li:last",h[g])[0]).bind("click",function(i){i.preventDefault();c._iDisplayStart=(parseInt($("a",this).text(),10)-1)*e.iLength;k(c)})}if(e.iPage===0){$("li:first",h[g]).addClass("disabled")}else{$("li:first",h[g]).removeClass("disabled")}if(e.iPage===e.iTotalPages-1||e.iTotalPages===0){$("li:last",h[g]).addClass("disabled")}else{$("li:last",h[g]).removeClass("disabled")}}}}});if($.fn.DataTable.TableTools){$.extend(true,$.fn.DataTable.TableTools.classes,{container:"btn-group",buttons:{normal:"btn btn-sm btn-primary",disabled:"disabled"},collection:{container:"DTTT_dropdown dropdown-menu",buttons:{normal:"",disabled:"disabled"}},print:{info:"DTTT_print_info modal"},select:{row:"active"}});$.extend(true,$.fn.DataTable.TableTools.DEFAULTS.oTags,{collection:{container:"ul",button:"li",liner:"a"}})};