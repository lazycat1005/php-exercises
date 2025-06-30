<?php
$metaKey = "temperature";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<body>
    <main id="ajaxVersion" class="container">
        <h1>溫度單位轉換</h1>

        <form>
            <fieldset id="temperatureConversion">
                <div class="celsius">
                    <label for="celsius">攝氏溫度 (°C):</label>
                    <input type="number" id="celsius" name="celsius" required>
                </div>

                <div class="fahrenheit">
                    <label for="fahrenheit">華氏溫度 (°F):</label>
                    <input type="number" id="fahrenheit" name="fahrenheit" required>
                </div>
            </fieldset>

            <div class="messageText">
                <p></p>
            </div>
        </form>

        <a class="fixedBtn" href="../../../index.php">Back</a>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"
        integrity="sha512-jGsMH83oKe9asCpkOVkBnUrDDTp8wl+adkB2D+//JtlxO4SrLoJdhbOysIFQJloQFD+C4Fl1rMsQZF76JjV0eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="./js/app.js"></script>
</body>

</html>