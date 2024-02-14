<?php

// check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get the question and the answer from the request
    $question = $_POST['question'];

    // get answers from the request
    $answers = [
        $_FILES['answer_1'],
        $_FILES['answer_2'],
        $_FILES['answer_3'],
        $_FILES['answer_4']
    ];

    // save files in the uploads folder
    foreach ($answers as $key => $answer) {
        $fileName = $answer['name'];
        $fileTmpName = $answer['tmp_name'];
        $fileSize = $answer['size'];
        $fileError = $answer['error'];
        $fileType = $answer['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = dirname(__DIR__) . '/public/uploads/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    print_r("File uploaded successfully");
                } else {
                    echo "Your file is too big!";
                }
            } else {
                echo "There was an error uploading your file!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    }

    // save the question and the answers to the database
    require_once dirname(__DIR__) . '/utils/db.php';

    // create a new question
    // $sql = "INSERT INTO media_answers (question, answer_1, answer_2, answer_3, answer_4) VALUES (?)";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute([$question]);

    // get the id of the question
    // $questionId = $conn->lastInsertId();

    // // save the answers
    // foreach ($answers as $key => $answer) {
    //     $fileName = $answer['name'];
    //     $fileTmpName = $answer['tmp_name'];
    //     $fileSize = $answer['size'];
    //     $fileError = $answer['error'];
    //     $fileType = $answer['type'];

    //     $fileExt = explode('.', $fileName);
    //     $fileActualExt = strtolower(end($fileExt));

    //     $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    //     if (in_array($fileActualExt, $allowed)) {
    //         if ($fileError === 0) {
    //             if ($fileSize < 1000000) {
    //                 $fileNameNew = uniqid('', true) . "." . $fileActualExt;
    //                 $fileDestination = dirname(__DIR__) . '/uploads/' . $fileNameNew;
    //                 move_uploaded_file($fileTmpName, $fileDestination);

    //                 $sql = "INSERT INTO media_answers_links (question_id, answer, link) VALUES (?, ?, ?)";
    //                 $stmt = $conn->prepare($sql);
    //                 $stmt->execute([$questionId, $key + 1, $fileNameNew]);
    //             } else {
    //                 echo "Your file is too big!";
    //             }
    //         } else {
    //             echo "There was an error uploading your file!";
    //         }
    //     } else {
    //         echo "You cannot upload files of this type!";
    //     }
    // }
}
