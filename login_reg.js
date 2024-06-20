var modal = document.getElementById("myModal");
var closeButton = document.getElementsByClassName("close")[0];
var loginButton = document.getElementById("loginButton");
var registerButton = document.getElementById("registerButton");
var loginForm = document.getElementById("loginForm");
var registerForm = document.getElementById("registerForm");

loginButton.addEventListener("click", function() {
  modal.style.display = "block";
  loginForm.style.display = "block";
  registerForm.style.display = "none";
});

registerButton.addEventListener("click", function() {
  modal.style.display = "block";
  loginForm.style.display = "none";
  registerForm.style.display = "block";
});

closeButton.addEventListener("click", function() {
  modal.style.display = "none";
});

window.addEventListener("click", function(event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});

loginForm.addEventListener("submit", function(event) {
    event.preventDefault();
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var xhr = new XMLHttpRequest();
    var url = "login.php";
    var params = "username=" + username + "&password=" + password;
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                console.log("Авторизация успешна!");
                location.reload();
            } else {
                alert("Неверный логин или пароль!");
            }
        }
    };
    xhr.send(params);
});

registerForm.addEventListener("submit", function(event) {
  event.preventDefault();

  var username = document.getElementById("regUsername").value;
  var password = document.getElementById("regPassword").value;
  var firstName = document.getElementById("firstName").value;
  var lastName = document.getElementById("lastName").value;
  var middleName = document.getElementById("middleName").value;
  var phone = document.getElementById("phone").value;
  var passportSeries = document.getElementById("passportSeries").value;
  var passportNumber = document.getElementById("passportNumber").value;

  var params = "username=" + encodeURIComponent(username) +
               "&password=" + encodeURIComponent(password) +
               "&firstName=" + encodeURIComponent(firstName) +
               "&lastName=" + encodeURIComponent(lastName) +
               "&middleName=" + encodeURIComponent(middleName) +
               "&phone=" + encodeURIComponent(phone) +
               "&passportSeries=" + encodeURIComponent(passportSeries) +
               "&passportNumber=" + encodeURIComponent(passportNumber);

  var xhr = new XMLHttpRequest();
  var url = "register.php";
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
      if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.success) {
              alert("Регистрация успешная");
              showLoggedInUser(username, "#");
          } else {
              alert("Регистрация не успешная");
          }
      }
  };
  xhr.send(params);
});



