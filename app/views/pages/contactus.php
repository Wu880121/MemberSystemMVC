<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../public/assets/css/main.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.css' integrity='sha512-GmZYQ9SKTnOea030Tbiat0Y+jhnYLIpsGAe6QTnToi8hI2nNbVMETHeK4wm4MuYMQdrc38x+sX77+kVD01eNsQ==' crossorigin='anonymous'/>
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="heading">Contact Us</div>
        <form action="">
            <div class="flex-area">
            <div class="entryarea">
                <input type="text" name="name"  placeholder=" " required>
                <span class="labelline">Enter name</span>
                <i class="fa-regular fa-circle-user"></i>
            </div>
            
            <div class="entryarea">
                <input type="email" name="email" placeholder=" " style="color: #106ddfb7;" required>
                <span class="labelline">Enter email</span>
                <i class="fa-regular fa-envelope"></i>
            </div>
        </div>
            <div class="entryarea">
                <textarea name="message"  placeholder=" "required></textarea>
                <span class="labelline">Enter your message</span>
            </div>
            <input type="submit" name="submit" id="btn">
        </form>
    </div>

</body>

</html>