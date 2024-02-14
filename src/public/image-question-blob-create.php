<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once dirname(__DIR__) . '/Component/Page/Head.php'; ?>
    <title>Blob Image</title>
</head>

<body>
    <header>
        <?php include_once dirname(__DIR__) . '/Component/Page/MainNav.php'; ?>
    </header>
    <main>
        <h1>Create new Image Questions</h1>
        <?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include_once dirname(__DIR__) . '/utils/db.php';

            // get the question and the answer from the request
            $question = $_POST['question'];

            // convert the file in to a base64 string/blob (binary large object)
            $option_1 = file_get_contents($_FILES['option_1']['tmp_name']);
            $option_2 = file_get_contents($_FILES['option_2']['tmp_name']);
            $option_3 = file_get_contents($_FILES['option_3']['tmp_name']);
            $option_4 = file_get_contents($_FILES['option_4']['tmp_name']);


            $correct_answer = $_POST['correct_answer'];
            try {
                // save files in the uploads folder
                $stmt = $dbConnection->prepare("INSERT INTO questions_blob (question, option_1, option_2, option_3, option_4, correct_answer) VALUES (?, ?, ?, ?, ?, ?)");

                // save the file in the database
                $stmt->execute([$question, $option_1, $option_2, $option_3, $option_4, $correct_answer]);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        ?>
        <form class="create-question-form" action="image-question-blob-create.php" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label for="question">Question</label>
                <input type="text" name="question" placeholder="Question" required>
            </div>
            <div class="input-group">
                <label for="option_1">Image Option 1</label>
                <input type="file" name="option_1" required>
            </div>
            <div class="input-group">
                <label for="option_2">Image Option 2</label>
                <input type="file" name="option_2" required>
            </div>
            <div class="input-group">
                <label for="option_3">Image Option 3</label>
                <input type="file" name="option_3" required>
            </div>
            <div class="input-group">
                <label for="option_4">Image Option 4</label>
                <input type="file" name="option_4" required>
            </div>
            <div class="input-group">
                <label for="question">Correct Answer</label>
                <input type="text" name="correct_answer" placeholder="Correct Answer" required>
            </div>
            <button type="submit" class="create-question-button">Submit</button>
        </form>
    </main>
</body>

</html>