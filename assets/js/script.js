
const login = document.querySelector('.login');
const register = document.querySelector('.register');
const linkLog = document.getElementById("link_login");
const linkReg = document.getElementById("link_register");
const passwordReg = document.getElementById("password");
const passwordLog = document.getElementById("passwordLog");
const eyeReg = document.querySelector('.eye');
const eyeLog = document.querySelector('.eyeLog');
let passwordVisible = false;

login.classList = 'hide';

linkReg.addEventListener("click", function(){
  if(login.classList.contains('hide')){
    login.classList.remove('hide');
    register.className = 'hide';
  }
});

linkLog.addEventListener("click", function(){

  login.className = 'hide';

  if(register.classList.contains('hide')){
    register.classList.remove('hide');
  }
});

eyeLog.addEventListener("click", showPassword);
eyeReg.addEventListener("click", showPassword);

function showPassword(event) {
  passwordVisible = !passwordVisible;
  if (passwordVisible) {
    passwordReg.type = "text";
    passwordLog.type = "text";
  } else {
    passwordReg.type = "password";
    passwordLog.type = "password";
  }
}
