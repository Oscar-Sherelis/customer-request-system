<?php

require_once 'includes/Database.php';
require_once 'includes/Request.php';
require_once 'includes/Validator.php';
require_once 'includes/helpers.php';

$validator = new Validator();
$requestModel = new Request();
$errors = [];
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'fullname' => trim($_POST['fullname'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'subject' => trim($_POST['subject'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'priority' => $_POST['priority'] ?? 'normal'
    ];
    
    if ($validator->validateRequest($formData)) {
        $id = $requestModel->create($formData);
        redirect('index.php?created=1');
    } else {
        $errors = $validator->getErrors();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Request</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Create New Request</h1>
            <a href="index.php" class="btn btn-secondary">← Back to List</a>
        </header>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $field => $error): ?>
                        <li><?= escape($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" class="request-form">
            <div class="form-group">
                <label for="fullname">Client Name *</label>
                <input type="text" id="fullname" name="fullname" 
                       value="<?= escape($formData['fullname'] ?? '') ?>" 
                       class="<?= isset($errors['fullname']) ? 'error' : '' ?>">
                <?php if (isset($errors['fullname'])): ?>
                    <span class="error-message"><?= escape($errors['fullname']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" 
                       value="<?= escape($formData['email'] ?? '') ?>" 
                       class="<?= isset($errors['email']) ? 'error' : '' ?>">
                <?php if (isset($errors['email'])): ?>
                    <span class="error-message"><?= escape($errors['email']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" 
                       value="<?= escape($formData['subject'] ?? '') ?>" 
                       class="<?= isset($errors['subject']) ? 'error' : '' ?>">
                <?php if (isset($errors['subject'])): ?>
                    <span class="error-message"><?= escape($errors['subject']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="6" 
                          class="<?= isset($errors['description']) ? 'error' : '' ?>"><?= escape($formData['description'] ?? '') ?></textarea>
                <?php if (isset($errors['description'])): ?>
                    <span class="error-message"><?= escape($errors['description']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="priority">Priority *</label>
                <select id="priority" name="priority" class="<?= isset($errors['priority']) ? 'error' : '' ?>">
                    <option value="low" <?= isset($formData['priority']) && $formData['priority'] === 'low' ? 'selected' : '' ?>>Low</option>
                    <option value="normal" <?= !isset($formData['priority']) || $formData['priority'] === 'normal' ? 'selected' : '' ?>>Normal</option>
                    <option value="high" <?= isset($formData['priority']) && $formData['priority'] === 'high' ? 'selected' : '' ?>>High</option>
                </select>
                <?php if (isset($errors['priority'])): ?>
                    <span class="error-message"><?= escape($errors['priority']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Create Request</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>