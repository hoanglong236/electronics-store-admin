const onSubmit = (e) => {
    e.preventDefault();

    const password = document.getElementById('password').value;
    const retypePassword = document.getElementById('retypePassword').value;

    if (password !== retypePassword) {
        alert('The retype password is incorrect');
        return;
    }

    document.getElementById('registerForm').submit();
}
