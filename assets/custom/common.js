var base_url = $("#base_url").val();

jQuery(document).ready(function($) {
	//Set maxlength of all the textarea (call plugin)
	$().maxlength();
});

(function($) {
	$.fn.maxlength = function() {
		$("textarea[maxlength], input[maxlength]").keypress(function(event) {
			var key = event.which;

			//all keys including return.
			if (key >= 33 || key == 13 || key == 32) {
				var maxLength = $(this).attr("maxlength");
				var length = this.value.length;
				if (length >= maxLength) {
					event.preventDefault();
				}
			}
		});
	};
})(jQuery);

// function isNotSpecialChar(str) {
//     return !/[\w\s\,\_!@#$%^&*()+.=-]/gi.test(str);
// }

function isNotSpecialChar(str) {
	//return !/[^\w\s\_]/gi.test(str);
	//return !/[\w\s\,\_!@#$%^&*()+.=-]/gi.test(str);
	return /^[^*|\":<>[\]{}`\\()';@&$!#%^~,.?+=\/_-]+$/gi.test(str);
}

function isNotNum(str) {
	return !/^[0-9-+()]*$/.test(str);
}

function isNotChar(str) {
	return /[^\sa-zA-Z]/gi.test(str);
}

function isPercent(str) {
	return /(^100([.]0{1,2})?)$|(^\d{1,2}([.]\d{1,2})?)$/.test(str);
}

$(".company").keypress(function(event) {
	var character = String.fromCharCode(event.keyCode);
	let Sp_Char = isNotSpecialChar(character);

	if (
		event.keyCode == 64 ||
		event.keyCode == 46 ||
		event.keyCode == 38 ||
		event.keyCode == 45 ||
		event.keyCode == 95 ||
		event.keyCode == 35
	) {
		return true;
	} else if (Sp_Char == true) {
		return true;
	} else {
		return false;
	}
});

$(".company").bind("paste", function() {
	var self = this;
	setTimeout(function() {
		if (/[a-zA-Z0-9.@&-]*$/.test($(self).val())) $(self).val("");
	}, 0);
});

$(".onlyChar").keypress(function(event) {
	var character = String.fromCharCode(event.keyCode);
	let Char = isNotSpecialChar(character);
	let Num = isNotNum(character);
	if (Char == true && Num == true) {
		return true;
	} else {
		return false;
	}
});

$(".onlyemail").keyup(function(event) {
	var email = this.value;//document.getElementById("txtEmail").value;
	var textid = $(this).attr("id");
	console.log(textid);
        var lblError = document.getElementById(textid+"Error");
        lblError.innerHTML = "";
        $("#"+textid).off('blur');
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!expr.test(email)) {
        	if(this.value != ""){
	        	$("#"+textid).blur(function(){
	        		document.getElementById(textid).focus();
	        	});
	        	lblError.innerHTML = "Invalid email address.";
	        }
        }
});

$(".onlyChar").bind("paste", function() {
	var self = this;
	setTimeout(function() {
		if (!/^[a-zA-Z]+$/.test($(self).val())) $(self).val("");
	}, 0);
});

$(".onlynum").keypress(function(event) {
	var character = String.fromCharCode(event.keyCode);
	let Sp_Char = isNotSpecialChar(character);
	let Char = isNotChar(character);

	if (Char == true && Sp_Char == true) {
		return true;
	} else {
		return false;
	}
});

$(".onlynum").bind("paste", function() {
	var self = this;
	setTimeout(function() {
		if (!/^[0-9-+()]+$/.test($(self).val())) $(self).val("");
	}, 0);
});

$(".onlynumchar").keypress(function(event) {
	var character = String.fromCharCode(event.keyCode);
	let Sp_Char = isNotSpecialChar(character);
	if (event.keyCode == 32) {
		return false;
	} else if (Sp_Char == true) {
		return true;
	} else {
		return false;
	}
});

$(".onlynumchar").bind("paste", function() {
	var self = this;
	setTimeout(function() {
		if (!/^[a-zA-Z0-9]*$/.test($(self).val())) $(self).val("");
	}, 0);
});

var validNumber = new RegExp(/^\d*\.?\d*$/);
var lastValid = $(".noNegetive").value;
/*function validateDecimalNumber(elem) {
  if (validNumber.test(elem.value)) {
      
    lastValid = elem.value;
  } else {
    elem.value = lastValid;
  }
}*/

$(".twoDecimalNumber").keypress(function(event) {
	var $this = $(this);
	if (
		(event.which != 46 || $this.val().indexOf(".") != -1) &&
		(event.which < 48 || event.which > 57) &&
		event.which != 0 &&
		event.which != 8
	) {
		event.preventDefault();
	}

	var text = $(this).val();
	if (event.which == 46 && text.indexOf(".") == -1) {
		setTimeout(function() {
			if ($this.val().substring($this.val().indexOf(".")).length > 3) {
				$this.val($this.val().substring(0, $this.val().indexOf(".") + 3));
			}
		}, 1);
	}

	if (
		text.indexOf(".") != -1 &&
		text.substring(text.indexOf(".")).length > 2 &&
		event.which != 0 &&
		event.which != 8 &&
		$(this)[0].selectionStart >= text.length - 2
	) {
		event.preventDefault();
	}
});

$(".twoDecimalNumber").bind("paste", function(e) {
	var text = e.originalEvent.clipboardData.getData("Text");
	if ($.isNumeric(text)) {
		if (
			text.substring(text.indexOf(".")).length > 3 &&
			text.indexOf(".") > -1
		) {
			e.preventDefault();
			$(this).val(text.substring(0, text.indexOf(".") + 3));
		}
	} else {
		e.preventDefault();
	}
});

$(".numberHundrade").keyup(function() {
	if ($(this).val() > 100) {
		$(this).val("100");
	}
});

/*$('.phone_number').keyup(function(){
  if(($(this).val() > 10) || ($(this).val() < 10)){
    $(this).val('');
  }
});
*/

function commonfunction(){
	$(".onlyemail").keyup(function(event) {
		var email = this.value;//document.getElementById("txtEmail").value;
		var textid = $(this).attr("id");
		console.log(textid);
	        var lblError = document.getElementById(textid+"Error");
	        lblError.innerHTML = "";
	        $("#"+textid).off('blur');
	        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	        if (!expr.test(email)) {
	        	if(this.value != ""){
		        	$("#"+textid).blur(function(){
		        		document.getElementById(textid).focus();
		        	});
		        	lblError.innerHTML = "Invalid email address.";
		        }
	        }
	});
	$(".onlynum").keypress(function(event) {
		var character = String.fromCharCode(event.keyCode);
		let Sp_Char = isNotSpecialChar(character);
		let Char = isNotChar(character);

		if (Char == true && Sp_Char == true) {
			return true;
		} else {
			return false;
		}
	});
}

function GetSingleData(id, encodedTableAttribute, stat) {
	var tableAttribute = atob(encodedTableAttribute);
	var data = {};
	data[tableAttribute] = {};
	data[tableAttribute][tableAttribute + "_id"] = id;
	var img = "";

	//console.log(JSON.stringify(data));return;

	$.ajax({
		type: "POST",
		url: base_url + "General/GetSingleData",
		data: data,
		success: function(response) {
			console.log(response);
			var res = JSON.parse(response);
			var key_arr = Object.keys(res.all_list[0]);
			var value_arr = Object.values(res.all_list[0]);

			for (var i = 0; i < key_arr.length; i++) {
				if (stat == "view") {
					if(key_arr[i] == 'product_image'){
						$("#product_image_div").html("<label>Product Image</label><br><img src='"+base_url+"assets/vlshop_file/"+value_arr[i]+"' height='200' width='200'>");
					}if(key_arr[i] == 'category_image'){
						$("#category_image_div").html("<label>Category Image</label><br><img src='"+base_url+"assets/vlshop_file/"+value_arr[i]+"' height='200' width='200'>");
					}
					if(key_arr[i] == 'other_images'){
						var otherImgArr = value_arr[i].split(",");
						var otherImgcontent = "";
						for(x=0;x<otherImgArr.length; x++){
							otherImgcontent += "<img src='"+base_url+"assets/vlshop_file/"+otherImgArr[x]+"' height='200' width='200' style='margin-right: 10px;'>";
						}
						$("#other_image_div").html("<label>Other Images</label><br>"+otherImgcontent);
					}
					if(key_arr[i] == 'product_tags'){
						var values=value_arr[i].split(",");
						$("#" + key_arr[i] + "").val(values).trigger('change').select2();
						$("#" + key_arr[i] + "").prop("disabled", true);
					}else if(key_arr[i] == 'description'){
						CKEDITOR.instances['description'].setData(value_arr[i]);
					}else{
						$("#" + key_arr[i] + "").val(value_arr[i]);
						$("#" + key_arr[i] + "").prop("disabled", true);
					}
				} else if (stat == "edit") {
					if(key_arr[i] == 'product_image'){
						$("#product_image_div").html('<label for="message-text" class="col-form-label">Product Image:</label><input type="file" maxlength="10" class="noNegetive twoDecimalNumber form-control"name="product_image">');
					}
					if(key_arr[i] == 'category_image'){
						$("#category_image_div").html('<label for="message-text" class="col-form-label">Category Image:</label><input type="file" maxlength="10" class="noNegetive twoDecimalNumber form-control"name="category_image">');
					}
					if(key_arr[i] == 'other_images'){
						$("#other_image_div").html('<label for="message-text" class="col-form-label">Other Images:</label><input type="file" maxlength="10" class="noNegetive twoDecimalNumber form-control"name="other_images[]" multiple>');
					}
					if(key_arr[i] == 'product_tags'){
						var values=value_arr[i].split(",");
						$("#" + key_arr[i] + "").select2('val', values).trigger('change');
						$("#" + key_arr[i] + "").prop("disabled", false);
					}else if(key_arr[i] == 'description'){
						CKEDITOR.instances['description'].setData(value_arr[i]);
					}else{
						$("#" + key_arr[i] + "").val(value_arr[i]);
						$("#" + key_arr[i] + "").prop("disabled", false);
					}
					
				}
			}

			if (stat == "view") {
				$("#edit_button").hide();
				$(".view_name").html("View");
			} else if (stat == "edit") {
				$(".view_name").html("Edit");
				$("#edit_button").show();
			}
			$("#edit_modal").modal("show");
		},
		error: function(response) {
			sweet_toaster("error", "Something went wrong. Reload & try again.");
		}
	});
}

(function($) {
	errorSwal = function(type, msg) {
		"use strict";

		if (type === "error") {
			swal({
				title: "Error!",
				text: msg,
				icon: "error",
				button: {
					text: "OK",
					value: true,
					visible: true,
					className: "btn btn-outline-success"
				}
			});
		}
	};
})(jQuery);

(function($) {
	errorSwal = function(type, msg) {
		"use strict";

		if (type === "error") {
			swal({
				title: "Error!",
				text: msg,
				icon: "error",
				button: {
					text: "OK",
					value: true,
					visible: true,
					className: "btn btn-outline-success"
				}
			});
		}
	};
})(jQuery);

(function($) {
	errorcsvSwal = function(type, msg1, msg2) {
		"use strict";

		var m1 = "";
		var m2 = "";
		if (msg1) {
			m1 = "<b> Updated List : </b>" + msg1 + "<br>";
		}
		if (msg2) {
			m2 = "<b> Error List : </b>" + msg2;
		}

		const el = document.createElement("div");
		el.innerHTML = m1 + m2;
		if (type === "csv_error") {
			swal({
				title: "Error!",
				text: "Customer Not Added",
				content: el,
				icon: "error",
				button: {
					text: "OK",
					value: true,
					visible: true,
					className: "btn btn-outline-success"
				}
			});
		}
	};
})(jQuery);

(function($) {
	successcsvSwal = function(type, msg1, msg2) {
		"use strict";

		var m1 = "";
		var m2 = "";
		if (msg1) {
			m1 = "<b> Updated List : </b>" + msg1 + "<br>";
		}
		if (msg2) {
			m2 = "<b> Error List : </b>" + msg2;
		}

		const el = document.createElement("div");
		el.innerHTML = m1 + m2;
		if (type === "csv_success") {
			swal({
				title: "Success!",
				text: "Customer Data Added Successfully",
				content: el,
				icon: "success",
				button: {
					text: "Close",
					value: true,
					visible: true,
					className: "btn btn-outline-dark"
				}
			});
		}
	};
})(jQuery);

(function($) {
	successSwal = function(type, msg) {
		"use strict";
		if (type === "new_msg") {
			swal({
				title: "Success!",
				text: msg,
				icon: "success",
				button: {
					text: "Close",
					value: true,
					visible: true,
					className: "btn btn-outline-dark"
				}
			});
		}
	};
})(jQuery);

(function($) {
	autoSwal = function(type, msg) {
		"use strict";
		if (type === "auto_msg") {
			swal({
				title: "Success!",
				text: msg,
				icon: "success",
				timer: 2000,
				button: false
			}).then(
				function() {},
				// handling the promise rejection
				function(dismiss) {
					if (dismiss === "timer") {
						console.log("I was closed by the timer");
					}
				}
			);
		}
	};
})(jQuery);

function DeleteData(id, encodedTableAttribute) {
	var tableAttribute = atob(encodedTableAttribute);
	var data = {};
	data[tableAttribute] = {};
	data[tableAttribute][tableAttribute + "_id"] = id;

	swal({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3f51b5",
		cancelButtonColor: "#ff4081",
		confirmButtonText: "Great ",
		buttons: {
			cancel: {
				text: "Cancel",
				value: null,
				visible: true,
				className: "btn btn-outline-dark",
				closeModal: true
			},
			confirm: {
				text: "OK",
				value: true,
				visible: true,
				className: "btn btn-outline-success ",
				closeModal: true
			}
		}
	}).then(willDelete => {
		if (willDelete) {
			$.ajax({
				type: "POST",
				url: base_url + "General/DeleteData",
				data: data,
				success: function(response) {
					var res = JSON.parse(response);
					if (res.stat == 200) {
						showSwal("auto_msg", res.msg);
						location.reload();
					} else if (res.stat == 400) {
						errorSwal("error", res.msg);
					} else {
						errorSwal("error", "Cannot delete this data");
					}
				},
				error: function(response) {
					//sweet_toaster("error","Something went wrong. Reload & try again.");
				}
			});
		} else {
			swal("Your Data is not deleted!");
		}
	});
}

// jQuery(document).ready(function($) {
//   // $('.datepicker').datepicker({
//   //     format: 'dd-mm-yyyy',
//   //     minDate: 0

//   // });

//   $(".to_date").datepicker({
//       format: 'dd-mm-yyyy',
//       showOn: "both",
//       minDate:$(".datepicker").datepicker("getDate")
//   });

// });

$(function() {
	$("#from_date")
		.datepicker({
			format: "dd-mm-yyyy",
			autoclose: true
		})
		.on("changeDate", function(e) {
			var selectedDate = e.date;
			var msecsInADay = 86400000;
			var endDate = new Date(selectedDate.getTime() + msecsInADay);
			var new_options = {
				format: "dd-mm-yyyy",
				autoclose: true,
				startDate: endDate
			};
			$("#to_date").datepicker("destroy");
			$("#to_date").datepicker(new_options);
		});
	$("#to_date").datepicker({ format: "dd-mm-yyyy", autoclose: true });
});
$(function() {
	$("#from")
		.datepicker({
			format: "dd-mm-yyyy",
			autoclose: true
		})
		.on("changeDate", function(e) {
			var selectedDate = e.date;
			var msecsInADay = 86400000;
			var endDate = new Date(selectedDate.getTime() + msecsInADay);
			var new_options = {
				format: "dd-mm-yyyy",
				autoclose: true,
				startDate: endDate
			};
			$("#to").datepicker("destroy");
			$("#to").datepicker(new_options);
            $("#to").val('');
		});
//	   $("#to").datepicker({ format: "dd-mm-yyyy", autoclose: true });
});

function fromWiseTo(){
    var from = $("#from").val();
    if(from == ''){
        errorSwal('error','Please choose from date first');
        return;
    } else{
	   $("#to").datepicker({ format: "dd-mm-yyyy", autoclose: true });
    }
}

function YMD(date) {
	var d = new Date(
		date
			.split("-")
			.reverse()
			.join("-")
	);

	var dd = d.getDate();
	var mm = d.getMonth() + 1;
	var yy = d.getFullYear();

	return yy + "-" + mm + "-" + dd;
}

function DMY(date) {
	dArr = date.split("-"); // ex input "2010-01-18"
	return dArr[2] + "-" + dArr[1] + "-" + dArr[0].substring(2);
}

function fnExcelReport() {
	var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
	var textRange;
	var j = 0;
	var sa = "";
	var tableName = $("#tableName").val();
	var tab = document.getElementById("sortable-table-1"); // id of table

	for (j = 0; j < tab.rows.length; j++) {
		tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
		//tab_text=tab_text+"</tr>";
	}

	tab_text = tab_text + "</table>";
	tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
	tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
	tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

	var ua = window.navigator.userAgent;
	var msie = ua.indexOf("MSIE ");

	if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
		// If Internet Explorer
		txtArea1.document.open("txt/html", "replace");
		txtArea1.document.write(tab_text);
		txtArea1.document.close();
		txtArea1.focus();
		sa = txtArea1.document.execCommand("SaveAs", true, "Inventory.xls");
	} else {
		//other browser not tested on IE 11
		// sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
		// sa.document.title = "your new title";

		let a = $("<a />", {
			href: "data:application/vnd.ms-excel," + encodeURIComponent(tab_text),
			download: tableName + ".xls"
		})
			.appendTo("body")
			.get(0)
			.click();
		//         e.preventDefault();
	}

	return sa;
}
