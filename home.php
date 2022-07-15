<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkShrtnr</title>
</head>

<body>
    <form action="/generate.php" method="POST" onkeydown="return event.key != 'Enter';">
        <input id="url" style="min-width:250px;" type="text" name="url" placeholder="Enter the link you'd like shortening..." required>
        <input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>">
        <button type="button" onclick="request(this)">submit</button>
    </form>
    <p id="result"></p>

    <script>
        async function request(e) {
            const resultText = document.getElementById('result');
            e.disabled = true;
            const form = e.closest('form');
            const formData = new FormData(form);

            const result = await fetch(form.action, {
                method: 'POST',
                body: formData
            })
            const data = await result;
            const body = await data.text();

            if (data.ok === true) {
                resultText.innerHTML = 'Success! Your short link is available here: <a target="_blank" rel="noopener" href="http://' + body + '">' + body + "</a>";
            } else {
                resultText.innerHTML = 'Sorry, something went wrong: ' + body;
            }

            e.disabled = false;
        }
    </script>
</body>

</html>