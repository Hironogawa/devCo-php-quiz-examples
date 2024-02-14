<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once dirname(__DIR__) . '/Component/Page/Head.php'; ?>
    <title>Fill In The Blanks</title>
    <style>
        .fill-the-blank-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;

            margin-bottom: 2rem;
        }

        .fill-the-blank-question {
            font-size: 1.5rem;
        }

        #fill-the-blank-select {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <header>
        <?php include_once dirname(__DIR__) . '/Component/Page/MainNav.php'; ?>
    </header>

    <main>
        <h1>Fill in the Blanks</h1>
        <?php
        include_once dirname(__DIR__) . '/utils/db.php';

        // get the first question from the database
        $stmt = $dbConnection->query("SELECT * FROM questions_blanks");
        $questionRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $question = $questionRow['question'];
        $keyword = $questionRow['keyword'];

        // array_map is used to remove any whitespace from the word list, then explode is used to split the string into an array
        $wordList = array_map('trim', explode(',', $questionRow['word_list']));
        $rightAnswer = $questionRow['correct_answer'];


        // the first option is disabled and selected, so the user has to select a word from the list
        $dropdownOptions = "<option disabled selected value>...</option>";

        // for each word in the word list, create an option element
        foreach ($wordList as $word) {
            $dropdownOptions .= "<option value='$word'>$word</option>";
        }

        // replace the keyword with a select element
        $replacedQuestion = str_replace($keyword, "<select id='fill-the-blank-select' name='color'>$dropdownOptions</select>", $question);

        // display the question and the select element
        echo "<div class='fill-the-blank-container'>";
        echo "<div class='fill-the-blank-question'>$replacedQuestion</div>";
        echo "</div>";
        echo "<button class='question-button' onclick='checkAnswer()'>Check Answer</button>";

        ?>
    </main>
    <script>
        function checkAnswer() {
            const color = document.getElementById('fill-the-blank-select').value;
            const rightAnswer = "<?php echo $rightAnswer; ?>";
            if (color === rightAnswer) {
                alert('Correct!');
            } else {
                alert('Wrong!');
            }

        }
    </script>
</body>

</html>