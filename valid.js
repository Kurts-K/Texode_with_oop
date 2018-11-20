function init() {
	
function valid(form) {
			
	var name = form.name.value;
	var email = form.email.value;
	var textarea = form.textarea.value;
	var err_name_min = (name.length < 1) ? 'Заполните имя' : null;
	var err_name_max = (name.length > 50) ? 'Имя длиннее 50 символов' : null;
	var err_email = (email.length < 1) ? 'Заполните email' : null;
	var err_textarea_min = (textarea.length < 1) ? 'Заполните отзыв' : null;
	var err_textarea_max = (textarea.length > 200) ? 'Отзыв не более 200 символов' : null;
	
	var error_message = err_name_min || err_name_max || err_email || err_textarea_min || err_textarea_max;
	
	var error_message_p = document.getElementsByClassName('error_message_p')[0];
			
		if (error_message) {
			error_message_p.innerHTML = error_message;
			error_message_p.classList.add("visibility_visible");
			return false;
			} else {
			error_message_p.classList.remove("visibility_visible");
			return true;
			}
}
			
	var reg_form = document.getElementsByClassName('feedbackForm')[0];
	var submit_button = document.getElementsByClassName('submitButton')[0];
			
	submit_button.onclick = function() {
		if (valid(reg_form)) {
			return true;
		}
		return false;
		
	}
			
}
	window.onload = init;