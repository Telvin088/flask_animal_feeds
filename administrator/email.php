<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
</head>
<body>
    <h1>Send an Email</h1>
    <form action="send_email.php" method="post">
        <label for="to">To:</label>
        <input type="text" name="to" id="to" required><br>

        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" required><br>

        <label for="message">Message:</label><br>
        <textarea name="message" id="message" rows="5" required></textarea><br>

        <input type="submit" value="Send Email">
    </form>
</body>
</html>
