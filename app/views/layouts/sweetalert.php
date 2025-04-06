<?php 

  if (!empty($_SESSION['alert'])):
  $status = $_SESSION['alert']['status'];
  $message = $_SESSION['alert']['message'];
  unset($_SESSION['alert']); // 只顯示一次
  
  ?>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css">
  <script src="/assets/js/handler.js"></script>
 
  <script>
    const message = "<?= $message ?>";

    switch ("<?= $status ?>") {
      case "enter_error":
        showError(message);
        break;
		
      case "confirm_error":
        showError(message);
        break;
		
      case "username_info":
        showInfo(message);
        break;
		
	  case "register_success":
        showSuccess(message);
        break;
		
	  case "register_error":
        showError(message);
        break;
		
	  case "login_info":
        showInfo(message);
        break;
		
	  case "login_error":
        showError(message);
        break;
		
	  case "login_success":
        showSuccess(message);
        break;
		
	  case "logout_success":
        showSuccess(message);
        break;
		
		
      default:
        showError("發生未知錯誤");
    }
  </script>
<?php endif; ?>
