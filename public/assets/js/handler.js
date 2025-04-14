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
    timer: 3000
  });
}

function showSuccess(message) {
  const Toast = baseToastConfig('green');
  Toast.fire({
    title: `${message}`,
    icon: 'success'
  });
}

function showError(message) {
  const Toast = baseToastConfig('red');
  Toast.fire({
    title: `${message}`,
    icon: 'error'
  });
}

function showInfo(message) {
  const Toast = baseToastConfig('red');
  Toast.fire({
    title: `${message}`,
    icon: 'info'
  });
}
