// login-handler.js
function baseToastConfig(iconColor) {
  return Swal.mixin({
    toast: true,
    position: 'top',
    iconColor: iconColor,
    background: 'white',
    customClass: {
      popup: 'colored-toast'
    },
    showConfirmButton: false,
    timerProgressBar: true,
    timer: 2000
  });
}

function showSuccess(message,url) {
  const Toast = baseToastConfig('green');
  Toast.fire({
    title: `${message}`,
    icon: 'success'
  }).then(() => {
    window.location.href = '${url}';
  });
}

function showError(message,url) {
  const Toast = baseToastConfig('red');
  Toast.fire({
    title: '${message}',
    icon: 'error'
  }).then(() => {
    window.location.href = '${url}';
  });
}

function showNotFound(message,url) {
  const Toast = baseToastConfig('red');
  Toast.fire({
    title: '${message}',
    icon: 'info'
  }).then(() => {
    window.location.href = '${url}';
  });
}
