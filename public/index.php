<?php
declare(strict_types=1);

/**
 * ITCS333 A4 starter — contact form.
 * Requirements (see README rubric):
 * - GET: render the form
 * - POST: validate name (required, 2-60 chars), email (valid), message (required, 10-1000 chars)
 * - invalid POST: re-render with inline errors + repopulated fields (200)
 * - valid POST: redirect (302/303) to a success page (PRG)
 * - escape all output with htmlspecialchars
 */

require_once __DIR__ . '/../src/validate.php';

$errors = [];
$name = '';
$email = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!validate_required($name)) {
        $errors['name'] = 'Name is required.';
    } elseif (!validate_length($name, 2, 60)) {
        $errors['name'] = 'Name must be between 2 and 60 characters.';
    }

    if (!validate_required($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!validate_email($email)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (!validate_required($message)) {
        $errors['message'] = 'Message is required.';
    } elseif (!validate_length($message, 10, 1000)) {
        $errors['message'] = 'Message must be between 10 and 1000 characters.';
    }

    if (empty($errors)) {
        header('Location: success.php', true, 303);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Us</title>
</head>
<body>
    <h1>Contact Us</h1>

    <form method="post" action="index.php">
        <label>
            Name
            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
            >
        </label>
        <br>

        <?php if (isset($errors['name'])): ?>
            <p><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <label>
            Email
            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
            >
        </label>
        <br>

        <?php if (isset($errors['email'])): ?>
            <p><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <label>
            Message
            <textarea name="message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></textarea>
        </label>
        <br>

        <?php if (isset($errors['message'])): ?>
            <p><?= htmlspecialchars($errors['message'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <button type="submit">Send</button>
    </form>
</body>
</html>