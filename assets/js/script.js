
const login = document.querySelector('.login');
const register = document.querySelector('.register');
const sendForm = document.querySelector('.send-form');
const cliccaQui = document.querySelector('.clicca-qui');
const backButton = document.querySelector('.torna-indietro');
const linkLog = document.getElementById("link_login");
const linkReg = document.getElementById("link_register");
const passwordReg = document.getElementById("password");
const passwordLog = document.getElementById("passwordLog");
const eyeReg = document.querySelector('.eye');
const eyeLog = document.querySelector('.eyeLog');
let passwordVisible = false;

register.classList = 'hide';

linkLog.addEventListener("click", function(){
  if(register.classList.contains('hide')){
    register.classList.remove('hide');
    login.className = 'hide';
  }
});

linkReg.addEventListener("click", function(){

  register.className = 'hide';

  if(login.classList.contains('hide')){
    login.classList.remove('hide');
  }
});

sendForm.classList = 'hide';

cliccaQui.addEventListener("click", function(){

  login.className = 'hide';

  if(sendForm.classList.contains('hide')){
    sendForm.classList.remove('hide');
  }
});

backButton.addEventListener("click", function(){

  sendForm.className = 'hide';

  if(login.classList.contains('hide')){
    login.classList.remove('hide');
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
