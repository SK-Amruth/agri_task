const BASE_URL = window.location.origin;


document.getElementById('logoutBtn').addEventListener('click', function (e) {
    e.preventDefault()
    document.getElementById('logoutForm').submit();
});