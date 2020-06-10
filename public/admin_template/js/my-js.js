$(document).ready(function() {
    let $btnSearch        = $("button#btn-search");
	let $btnClearSearch	  = $("button#btn-clear");
	let $inputSearchField = $("input[name  = search_field]");
    let $inputSearchValue = $("input[name  = search_value]");
    $("a.select-field").click(function(e) {
		e.preventDefault();
		let field 		= $(this).data('field');
		let fieldName 	= $(this).html();
		$("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
    	$inputSearchField.val(field);
    });
    $btnSearch.click(function() {
        var pathname	= window.location.pathname;
        let params = ['filter_status', 'filter_isHome', 'filter_display'];
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
        let id = $(this).data('id');
        let link = $(this).data('link');
        let index = $(this).data('index');
        swal({
			title: "Bạn có muốn xóa không?",
			text: "Nếu xóa, bạn sẽ không thể khôi phục lại!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
                $.ajax({
                    type: 'get',
                    url: link,
                    data:{
        
                    },
                    success: function(response){
                        if(response.message !== undefined){
                            $('.index').each(function(){
                                if($(this).data('index') > index) {
                                    $(this).html($(this).data('index') - 1);
                                    $(this).data('index', $(this).data('index') - 1);
                                }
                            })
                            $('.index2').each(function(){
                                if($(this).data('index') > index) {
                                    $(this).data('index', $(this).data('index') - 1);
                                }
                            })
                            $('#div-' + id).remove();
                            swal("Xóa thành công!", {
                                	icon: "success",
                                });
                        }
                    }
                })
			} else {
			  	swal("Xóa không thành công!");
			}
		});
    })

    $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    $(document).on('click', '.status', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let controllerName = $(this).data('controller');
        $.ajax({
            type: 'get',
            url: controllerName + "/change-status/" + id,
            data:{

            },
            success: function(response){
                if(response.message !== undefined){
                    toastr.success(response.message);
                    $('#status-' + id).html(response.status.name);
                    $('#status-' + id).attr('class', 'btn btn-round status ' + response.status.class);
                }
            }
        })
    })

    $(document).on('change', 'select[name = select_change_attr]', function(e){
        e.preventDefault();
        let value = $(this).val();
        let id = $(this).data('id');
        let controllerName = $(this).data('controller');
        let fieldName = $(this).data('field');
        $.ajax({
            type: 'get',
            url: controllerName + "/change-" + fieldName + "-" + value + "/" + id,
            data:{

            },
            success: function(response){
                if(response.message !== undefined){
                    toastr.success(response.message);
                }
            }
        })
    })

    $(document).on('click', '.ishome', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let controllerName = $(this).data('controller');
        $.ajax({
            type: 'get',
            url: controllerName + "/change-is-home/" + id,
            data:{

            },
            success: function(response){
                if(response.message !== undefined){
                    toastr.success(response.message);
                    $('#ishome-' + id).html(response.ishome.name);
                    $('#ishome-' + id).attr('class', 'ishome btn btn-round ' + response.ishome.class);
                }
            }
        })
    })

})
