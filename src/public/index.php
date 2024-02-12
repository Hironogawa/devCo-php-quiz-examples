<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        async function getData() {
            event.preventDefault();

            const response = await fetch('http://localhost:8000/login.php', {
                method: 'POST',
                headers: {
                    "Accept": "application/json",
                    "Content-ype": "application / json"
                },
                body: JSON.stringify({
                    username: document.myform.username.value,
                    password: document.myform.password.value
                })
            });
            const data = await response.json();
            updateUI(data);
        }

        function updateUI(data) {
            const username = document.querySelector('#username');
            const password = document.querySelector('#password');

            username.innerHTML = data.username;
            password.innerHTML = data.password;
        }
    </script>
</head>

<body>
    <?php


    //phpinfo(); 

    // echo get_include_path(); 
    // include dirname(__DIR__) . '/utils/db.php';


    // echo "<p>Hello, we are starting to work with Databases and PHP PDO!</p>";

    ?>
    <form name="myform" method="post" onsubmit="getData()">
        <input type="text" name="username" placeholder="username">
        <input type="password" name="password" placeholder="password">
        <input type="submit" name="submit" value="submit">
    </form>

    <div id="username"></div>
    <div id="password"></div>
</body>

</html>