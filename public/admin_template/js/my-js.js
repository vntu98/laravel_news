$(document).ready(function() {
    let $btnSearch        = $("button#btn-search");
	let $btnClearSearch	  = $("button#btn-clear");
	let $inputSearchField = $("input[name  = search_field]");
    let $inputSearchValue = $("input[name  = search_value]");
    let $selectChangeAttr = $('select[name = select_change_attr]');
    $("a.select-field").click(function(e) {
		e.preventDefault();
		let field 		= $(this).data('field');
		let fieldName 	= $(this).html();
		$("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
    	$inputSearchField.val(field);
    });
    $btnSearch.click(function() {
        var pathname	= window.location.pathname;
        let params = ['filter_status'];
        let searchParams = new URLSearchParams(window.location.search);
        let link = "";
        $.each(params, function(key, param){
            if(searchParams.has(param)){
                link += param + "=" + searchParams.get(param) + "&";
            }
        })
		let search_field = $inputSearchField.val();
        let search_value = $inputSearchValue.val();
        if(search_value.replace(/\s/g, "") !== "")
		window.location.href = pathname + "?" + link + "search_field=" + search_field + '&search_value=' + search_value;
    });
    $btnClearSearch.click(function(){
        var pathname	= window.location.pathname;
        let params = ['filter_status'];
        let searchParams = new URLSearchParams(window.location.search);
        let link = "";
        $.each(params, function(key, param){
            if(searchParams.has(param)){
                link += "?" + param + "=" + searchParams.get(param) + "&";
            }
        })
        window.location.href = pathname + link.slice(0, -1);
    })
    setTimeout(() => {
        $('div#alert').fadeOut('slow');
    }, 1000);
    $(document).on('click', '.btn-delete', function(){
		let link = $(this).data('link');
        swal({
			title: "Bạn có muốn xóa không?",
			text: "Nếu xóa, bạn sẽ không thể khôi phục lại!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
			  	swal("Xóa thành công!", {
					icon: "success",
				}).then((willDelete) => {
                    window.location.href = link;
                });
			} else {
			  	swal("Xóa không thành công!");
			}
		});
    })
    $selectChangeAttr.on('change', function(){
        let selectValue = $(this).val();
        let url = $(this).data('url');
        window.location.href = url.replace('value_new', selectValue);
    })
})
