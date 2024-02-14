<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once dirname(__DIR__) . '/Component/Page/Head.php'; ?>
    <title>Blob Image</title>
    <style>
        .media-question-container {
            width: 100%;
            display: flex;
            flex-direction: row;
            gap: 1rem;

            margin-bottom: 2rem;
        }

        .img-container {
            width: 7rem;
            height: 7rem;
            overflow: hidden;
            border-radius: 0.15rem;
            transition: border-radius 0.5s, border 0.25s ease-out;
        }

        .img-container:hover {
            border-radius: 50%;
        }

        .answer-label img {
            max-height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        .answer-label [type='checkbox']:checked+.img-container {
            border: 0.15rem solid red;
            box-sizing: border-box;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <header>
        <?php include_once dirname(__DIR__) . '/Component/Page/MainNav.php'; ?>
    </header>
    <main>
        <?php
        include_once dirname(__DIR__) . '/utils/db.php';

        try {
            $stmt = $dbConnection->prepare("SELECT * FROM questions_ref");
            $stmt->execute();
            $questionRow = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        echo "<h1>" . $questionRow['question'] . "</h1>";
        echo "<div class='media-question-container'>";

        // counter to define the option value
        $i = 1;
        foreach ($questionRow as $key => $value) {
            if (str_contains($key, 'option_')) {

                // We store only the image name in the database and we retrieve it from the uploads folder
                echo "<label class='answer-label'>
                        <input type='checkbox' name='media-answer' value='$i' hidden>
                        <div class='img-container'>
                            <img src='/uploads/" . $value . "' alt='option $i'>
                        </div>
                    </label>";
                $i++;
            }
        }
        echo "</div>";

        echo "<button class='question-button' onclick='checkAnswer()'>Check Answer</button>";

        ?>
    </main>
    <script>
        function checkAnswer() {
            let checkedInputFields = document.querySelectorAll('input[name="media-answer"]:checked')
            if (!checkedInputFields.length) {
                alert("Please select an answer");
                return;
            }

            let rightAnswerRaw = "<?php echo $questionRow['correct_answer']; ?>";

            // make sure to have a string
            let rightAnswer = rightAnswerRaw.toString();

            // remove any white space from the string
            rightAnswer = rightAnswer.replace(/ /g, '');

            // if the answer is a comma separated string split it into an array else create an array with a single element
            if (rightAnswer.includes(',')) {
                rightAnswer = rightAnswer.split(',');
            } else {
                rightAnswer = [rightAnswer];
            }

            let isCorrect = 0;
            checkedInputFields.forEach(answer => {
                // if the answer is in the right answer array increment the isCorrect counter else decrement it
                if (rightAnswer.includes(answer.value)) {
                    isCorrect++;
                } else {
                    isCorrect--;
                }
            });

            if (isCorrect === rightAnswer.length) {
                alert("Correct!");
            } else {
                alert("Incorrect!");
            }

        }
    </script>
</body>

</html>