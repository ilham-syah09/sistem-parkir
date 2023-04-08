var success = $(".toastr-success").data("flashdata");
var error = $(".toastr-error").data("flashdata");

if (success) {
	toastr.success(success);
}

if (error) {
	toastr.error(error);
}
