grecaptcha.ready(function() {
    grecaptcha.execute('6LcWAr8UAAAAAHNpBOF5wogtLValQXC-KyTUsQGJ', { action: 'ecommerce' }).then(function(token) {
        document.getElementById('g-recaptcha-response').value = token;
    });
});