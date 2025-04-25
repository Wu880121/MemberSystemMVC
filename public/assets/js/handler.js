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

// ========== Dialog 彈出設定（非 Toast） ==========

// ✅ 成功 Dialog
function showDialogSuccess(message) {
  Swal.fire({
    toast: false,
    icon: 'success',
    title: '成功！',
    text: message,
    confirmButtonText: '了解'
  });
}
window.showDialogSuccess = showDialogSuccess;

// ✅ 錯誤 Dialog
function showDialogError(message) {
  console.log('✅ 執行 showDialogError', message);
  Swal.fire({
    toast: false,
    icon: 'error',
    title: '發生錯誤！',
    text: message,
    confirmButtonText: '關閉'
  });
}
window.showDialogError = showDialogError;

// ✅ 提示 Dialog
function showDialogInfo(message) {
  Swal.fire({
    toast: false,
    icon: 'info',
    title: '提示',
    text: message,
    confirmButtonText: '知道了'
  });
}
window.showDialogInfo = showDialogInfo;
