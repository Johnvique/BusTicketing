String.prototype.trimLeft = function(charlist) {
  if (charlist === undefined)
	charlist = "\s";

  return this.replace(new RegExp("^[" + charlist + "]+"), "");
};

String.prototype.trimRight = function(charlist) {
  if (charlist === undefined)
	charlist = "\s";

  return this.replace(new RegExp("[" + charlist + "]+$"), "");
};

function valToArray(val) {
	if(val){
		if(Array.isArray(val)){
			return val;
		}
		else{
			return val.split(",");
		}
	}
	else{
		return [];
	}
};

function debounce(fn, delay) {
  var timer = null;
  return function () {
	var context = this, args = arguments;
	clearTimeout(timer);
	timer = setTimeout(function () {
	  fn.apply(context, args);
	}, delay);
  };
}

function extend(obj, src) {
	for (var key in src) {
		if (src.hasOwnProperty(key)) obj[key] = src[key];
	}
	return obj;
}

function setPathLink(path , queryObj){
	var url;
	if(queryObj){
		var str = [];
		for(var k in queryObj){
			var v = queryObj[k]
			if (queryObj.hasOwnProperty(k) && v !== '') {
				str.push(encodeURIComponent(k) + "=" + encodeURIComponent(v));
			} 
		}
		
		var qs = str.join("&");
		
		if(path.indexOf('?') > 0){
			url = path + '&' + qs;  
		}
		else{
			url = path + '?' + qs;  
		}
		
	}
	else{
		url = siteAddr + path;
	}
	
	return url;
}

function randomColor() {
	var letters = '0123456789ABCDEF';
	var color = '#';
	for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	}
	return color;
}

function hideFlashMsg(){
	var elem=$('#flashmsgholder');
	if(elem.length>0){
		var duration=elem.attr("data-show-duration");
		if(duration>0){
			window.setTimeout(function(){
				elem.fadeOut();
			},duration)
		}
	}
}

$(document).ready(function() {
	hideFlashMsg();
	
	var pageLoadinStyle = $('#page-loading-indicator').html();
	
	$('.has-tooltip').tooltip();
	
	$('.toggle-check-all').click(function(){
		var p = $(this).closest('table').find('.optioncheck');
		p.prop("checked",$(this).prop("checked"));
	});
	
	$('.optioncheck').click(function(){
		var sel_ids =$(this).closest('.page').find("input.optioncheck:checkbox:checked").map(function(){
		  return $(this).val();
		}).get();
		if(sel_ids.length>0){
			 $(this).closest('.page').find('.btn-delete-selected').removeClass('d-none');
		}
		else{
			$(this).closest('.page').find('.btn-delete-selected').addClass('d-none');
		}
	});
	
	$('.btn-delete-selected').click(function(){
		var recordDeleteMsg=$(this).data("prompt-msg");
		if(recordDeleteMsg==''){
			recordDeleteMsg="Are you sure you want to delete this record";
		}
		var sel_ids =$(this).closest('.page').find("input.optioncheck:checkbox:checked").map(function(){
		  return $(this).val();
		}).get();
		if(sel_ids.length>0){
			if(confirm(recordDeleteMsg)){
				var url = $(this).data('url');
				url = url.replace("{sel_ids}",sel_ids);
				window.location = url;
			}
		}
		else{
			alert('No Record Selected');
		}
	});
	
	$('.recordDeletePromptAction').click(function(e){
		var recordDeleteMsg=$(this).attr("data-prompt-msg");
		if(recordDeleteMsg==''){
			recordDeleteMsg="Are you sure you want to delete this record";
		}
		if(!confirm(recordDeleteMsg)){
			e.preventDefault();
		}
	});
	
	$('.removeEditUploadFile').click(function(e){
		if(confirm("Are Sure to Remove The File")){
			 // hidden input that contains all the file
			var holder = $(this).closest(".uploaded-file-holder");
			var inputid = $(this).attr("data-input");
			var inputControl = $(inputid);
			var filepath = $(this).attr('data-file');
			var filenum = $(this).attr('data-file-num');
			var srcTxt = inputControl.val();
			var arrSrc = srcTxt.split(",");
			arrSrc.forEach(function(src,index){
				if(src == filepath){
					arrSrc.splice(index,1);
				}
			});
			
			holder.find("#file-holder-"+filenum).remove();
			var ty = arrSrc.join(",");
			inputControl.val(ty);
		}
	});
	
	$('.open-page-modal').on('click',function(e){
        e.preventDefault();
		
		var dataURL = $(this).attr('href');
		var modal = $(this).next('.modal');
		
		modal.modal({show:true});
        modal.find('.modal-body').html(pageLoadinStyle).load(dataURL);
		
    });
	
	$('a.page-modal').on('click',function(e){
        e.preventDefault();
		
		var dataURL = $(this).attr('href');
		var modal = $('#main-page-modal');
		
		modal.modal({show:true});
        modal.find('.modal-body').html(pageLoadinStyle).load(dataURL);
		
    });

	$('.open-page-inline').on('click',function(e){
        e.preventDefault();
		var dataURL = $(this).attr('href');
		
		var page = $(this).parent('.inline-page').find('.page-content');
		var loaded = page.attr('loaded');
		
		if(!loaded){
			page.html(pageLoadinStyle).load(dataURL);
			page.attr('loaded',true)
		}
		page.toggleClass("d-none");
    });
	
	$('.export-btn').on('click',function(e){
		var html = $(this).closest('.page').find('.page-records').html();
		var title = $(this).closest('.page').find('.record-title').html();
		$('#exportformdata').val(html);
		$('#exportformtitle').val(title);
		$('#exportform').submit();
    });
	
	$('form.multi-form').on('submit',function(e){
		var isAllRowsValid = true;
		var form = $(this)[0];
		
		$(form).find('tr.input-row').each(function(e){
			var validateRow = false;
			
			$(this).find('td').each(function(e){
				var inp = $(this).find('input,select,textarea');
				
				if(inp.val() !=''){
					validateRow = true;
					return true;
				}
			});
			
			if(validateRow==true){
				$(this).find('input,select,textarea').each(function(e){
					var elem = $(this)[0];
					if(!elem.checkValidity()){
						isAllRowsValid = false;
						return true;
					}
				});
			}
			
		});
		
		if(isAllRowsValid==false){
			e.preventDefault();
			form.reportValidity();
			e.preventDefault();
		}
    });
	
	$('[data-load-target]').on('change',function(e){
		
		var val = $(this).val();
		var path = $(this).data('load-path');
		
		path = path + '/' + val;
		
		var targetName =  $(this).data('load-target');
		
		var selectElem ="[name='" +  targetName +  "']";
		
		
		$(selectElem).html('<option value="">Loading...</option>');
		var placeholder = $(selectElem).attr('placeholder') || 'Select a value...';
		
		$.ajax({
			type: 'GET',
			url: path,
			dataType: 'json',
			success: function (data){
				var options = '<option value="">' + placeholder +  '</option>';
				console.log(data);
				for (var i = 0; i < data.length; i++) {
					options += '<option value="' + data[i].value + '">' + data[i].label + '</option>';
				}
				$(selectElem).html(options);
			},
			error: function (data) {
				
			},
		});
		
    });
	
	
	
	
	
	
	$('.datepicker').flatpickr({
		altInput: true, 
		allowInput:true,
		onReady: function(dateObj, dateStr, instance) {
			var $cal = $(instance.calendarContainer);
			if ($cal.find('.flatpickr-clear').length < 1) {
				$cal.append('<button class="btn btn-light my-2 flatpickr-clear">Clear</button>');
				$cal.find('.flatpickr-clear').on('click', function() {
					instance.clear();
					instance.close();
				});
			}
		}
	});

	
});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


$(window).bind('load', function() {
	$('img').each(function() {
		if((typeof this.naturalWidth != "undefined" &&
			this.naturalWidth == 0 ) 
			|| this.readyState == 'uninitialized' ) {
			$(this).attr('src', './assets/images/no-image-available.png');
		}
	}); }
);






$(function(){
	$('.smartwizard').each(function(){
		var theme = $(this).data('theme') || "dots";

		$(this).smartWizard({
			selected: 0,  // Initial selected step, 0 = first step 
			keyNavigation:true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
			autoAdjustHeight:false, // Automatically adjust content height
			cycleSteps: false, // Allows to cycle the navigation of steps
			backButtonSupport: true, // Enable the back button support
			useURLhash: true, // Enable selection of the step based on url hash
			toolbarSettings: {
				toolbarPosition: 'bottom', // none, top, bottom, both
				toolbarButtonPosition: 'left', // left, right
				showNextButton: false, // show/hide a Next button
				showPreviousButton: false, // show/hide a Previous button
			}, 
			anchorSettings: {
				anchorClickable: true, // Enable/Disable anchor navigation
				enableAllAnchors: false, // Activates all anchors clickable all times
				markDoneStep: true, // add done css
				enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
			},            
			theme: theme, // dots,circles,arrows
			transitionEffect: 'fade', // Effect on navigation, none/slide/fade
			transitionSpeed: '400'
		});
		
	});
	
	$('.smartwizard form').submit(function(e){
		var currentForm = $(this)[0];
		
		if(currentForm.checkValidity()){
			e.preventDefault();
			
			var nextPage = $(this).closest('.formtab').data('next-page');
			var submitAction = $(this).closest('.formtab').data('submit-action');
			
			var method = $(this).attr('method');
			
			var url = $(this).attr('action');
			var formData = '';
			
			if(submitAction == 'SUBMIT-STEP-FORM'){
				formData = $(currentForm).serialize();
			}
			else if(submitAction == 'SUBMIT-ALL-FORMS'){
				
				$('.smartwizard form').each(function(e){
					formData = formData + '&' + $(this).serialize();
				});
				
				var allFormUrl = $(this).closest('.formtab').data('form-action');
				
				if(allFormUrl){
					url = allFormUrl
				}
				
			}
			
			if(formData){
				$.ajax({
					type: method,
					url: url,
					data: formData,
					success: function (data) {
						console.log('Submission was successful.');
						window.location.href = '#' + nextPage;
					},
					error: function (data) {
						console.log('An error occurred subiting the form');
					},
				});
			}
			else{
				window.location.href = '#' + nextPage;
			}
		}
	})
});








Dropzone.autoDiscover = false;
$(function(){
	$('.dropzone').each(function(){
		var uploadUrl = $(this).attr('path') || setPathLink('filehelper/uploadfile/');
		var multiple = $(this).data('multiple') || false;
		var limit = $(this).attr('maximum') || 1;
		var size = $(this).attr('filesize') || 10;
		var dropmsg = $(this).attr('dropmsg') || 'Drag and dDrop files here';
		var dragdrop = $(this).attr('dropmsg');
		var autoSubmit = $(this).attr('autosubmit') || true;
		var accept = $(this).attr('accept') || "";
		var extensions = $(this).attr('extensions') || "*";
		var filenameformat = $(this).attr('filenameformat') || "random";
		var returnfullpath = $(this).attr('returnfullpath') || true;
		var filenameprefix = $(this).attr('filenameprefix') || '';
		var dir = $(this).attr('dir') || 'uploads/files/';
		var btntext = $(this).attr('btntext') || 'Choose file';
		
		
		var input = $(this).attr('input');
		
		$('.dropzone').dropzone({ 
			url:uploadUrl ,
			maxFilesize:size,
			uploadMultiple:multiple,
			paramName:'file',
			maxFiles:limit,
			addRemoveLinks:true,
		
			params: {
				title : "{{" + filenameformat + "}}",
				returnfullpath:returnfullpath,
				filenameprefix:filenameprefix,
				extensions:extensions,
				maxSize:size,
				uploadDir:dir,
				limit:limit
			},
			init: function() {
				this.on('addedfile', function(file) {
					if (this.files.length > limit) {
					  this.removeFile(this.files[0]);
					}
				});

				this.on("success", function(file, responseText) {
					console.log("uploaded file",responseText);
					var files = $(input).val() + ',' + responseText;
					files = files.trim().trimLeft(',')
					$(input).val(files);
				});
				
				this.on("removedfile", function(file) {
					var filename = file.xhr.responseText;

					var files = $(input).val();
					var arrFiles = files.split(',');
					while (arrFiles.indexOf(filename) !== -1) {
						arrFiles.splice(arrFiles.indexOf(filename), 1);
					}
					
					$(input).val(arrFiles.toString());
				});
				
				this.on("complete", function (file) {
					//do something all files uploaded
				});
			},
			dictDefaultMessage:dropmsg,
			/* dictRemoveFile:'' */
		});
	});
});




$(function () { 
  $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
});

$(function() {
	$(".switch-checkbox").bootstrapSwitch();
});
(function(){
	var winHeight = $(window).height();
	var navTopHeight = $('#topbar').outerHeight();
	var sideHeight = winHeight-navTopHeight;
	document.body.style.paddingTop = navTopHeight + 'px';
	$('#sidebar').css('top',navTopHeight);
	$('#sidebar').css('min-height',sideHeight);
}
)();

