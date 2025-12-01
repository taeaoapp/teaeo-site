function validateEmail(email){
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
}

function validateForm() {
    var name = $('#name').val();
    var email = $('#email').val();
    var subject = $('#subject').val();
    var message = $('#message').val();
    var phone = $('#phone').val();
    if (!name && !email && !subject && !message && !phone){
        $('#contact_form_submit')
        .prepend("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+
		"<span>Please fill out all required fields.</span>"+
        "</div>")
        return false;
    }
    if (!validateEmail(email)) {
        $('#contact_form_submit')
        .prepend("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+
			"<span>Email is Not Valid! Please try again. </span>"+
			"</div>")
        return false;
    }
    return true    
}
const handleSubmit = event => {
    event.preventDefault();
    const contactForm = event.target;
    var formData = new FormData(contactForm);


    fetch("/", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams(formData).toString()
    })
    .then(() => {
        if (validateForm()) {
            $('#contact_form_submit').prepend("<div class='conTop_25 alert alert-success alert-dismissible fade show' role='alert'>"
            +"<span>Thank you for contacting us and will be in touch with you very soon.</span></div>");
            $('#name').val('');
            $('#email').val('');
            $('#message').val('');
            $('#surename').val('');
            $('#subject').val('');
            $('#phone').val('');
        }
    })
    .catch(error =>  {$('#contact_form_submit').prepend(
        "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+
        "<span>"+error+"</span>"+
        "</div>");
    })
    .finally(() =>{
        $('.alert-danger').fadeOut(3000);
    })

};

document.querySelector("form").addEventListener("submit", handleSubmit);