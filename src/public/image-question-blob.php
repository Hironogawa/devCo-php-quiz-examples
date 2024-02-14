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

        .answer-label [type='radio']:checked+.img-container {
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

        $sql = "SELECT * FROM questions_blob";
        $stmt = $dbConnection->query($sql);
        $questionRow = $stmt->fetch(PDO::FETCH_ASSOC);


        echo "<h1>" . $questionRow['question'] . "</h1>";
        echo "<div class='media-question-container'>";
        $i = 1;
        foreach ($questionRow as $key => $value) {
            if (str_contains($key, 'option_')) {

                echo "<label class='answer-label'>
                        <input type='radio' name='media-answer' value='$i' hidden>
                        <div class='img-container'>
                            <img src='data:image/jpeg;base64," . base64_encode($value) . "'>
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
            let answer = document.querySelector('input[name="media-answer"]:checked').value;
            if (answer == <?php echo $questionRow['correct_answer']; ?>) {
                alert('Correct');
            } else {
                alert('Wrong');
            }
        }
    </script>
</body>

</html>