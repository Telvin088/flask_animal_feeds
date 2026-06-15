<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato&display=swap');
        @import url("https://fonts.googleapis.com/css2?family=Oswald&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap");
        @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap');

        body {
            height: 100vh;
            width: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: "Oswald", sans-serif;
        }

        form {
            height: 400px;
            width: 500px;
            background-color: #1f2f3e;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        form input {
            height: 30px;
            width: 250px;
            background-color: inherit;
            border: none;
            border-bottom: 1px solid #ddd;
            color: #ddd;
        }

        form input::placeholder {
            color: #ddd;
        }

        form a {
            margin-top: 10px;
            color: #22b2b2;
        }

        button {
            width: 100px;
            height: 30px;
            border-radius: 5px;
            border: none;
            background-color: #e3e4e5;
        }
    </style>
</head>

<body>
    <h1>User Login</h1>
    <div class="signup-page">
        <form action="login_process.php" method="POST">
            <input type="text" id="username" name="username" placeholder="UserName" required>
            <br>

            <input type="password" id="password" name="password" placeholder="Password" required>
            <br>

            <button type="submit">Login</button>
            <a href="index.html">Do not have an account? Signup..</a>
        </form>
    </div>
</body>

</html>