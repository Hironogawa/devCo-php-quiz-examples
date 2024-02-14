<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once dirname(__DIR__) . '/Component/Page/Head.php'; ?>
    <title>Home</title>
    <style>
        .bullet-list {
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
            padding-left: 1rem;
        }

        .bullet-list li {
            margin-bottom: 0.25rem;
        }
    </style>
</head>
<header>
    <?php include_once dirname(__DIR__) . '/Component/Page/MainNav.php'; ?>
</header>
<main>
    <h1>PHP Quiz Question Types</h1>
    <p>Some Quiz question types that can be used in a PHP application.
    <ul class="bullet-list">
        <li>Fill in the Blank</li>
        <li>Question with image selection</li>
    </ul>
    </p>
</main>

</html>