<?php

require_once 'includes/Database.php';
require_once 'includes/Request.php';
require_once 'includes/Validator.php';
require_once 'includes/helpers.php';

$requestModel = new Request();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    redirect('index.php');
}

$request = $requestModel->getById($id);

if (!$request) {
    redirect('index.php?error=not_found');
}

$allStatuses = ['new', 'in_progress', 'closed'];

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_status' && isset($_POST['status'])) {
        $status = $_POST['status'];
        if (in_array($status, $allStatuses)) {
            $requestModel->updateStatus($id, $status);
            redirect('view.php?id=' . $id . '&updated=1');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Request #<?= $request['id'] ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Request Details</h1>
            <div>
                <a href="index.php" class="btn btn-secondary">← Back to List</a>
                <a href="edit.php?id=<?= $request['id'] ?>" class="btn btn-secondary">Edit</a>
            </div>
        </header>

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success">Status updated successfully!</div>
        <?php endif; ?>

        <div class="request-details">
            <div class="detail-row">
                <div class="detail-label">Request #</div>
                <div class="detail-value"><?= $request['id'] ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Client Name</div>
                <div class="detail-value"><?= escape($request['fullname']) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Email Address</div>
                <div class="detail-value"><?= escape($request['email']) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Subject</div>
                <div class="detail-value"><?= escape($request['subject']) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Description</div>
                <div class="detail-value description-text"><?= nl2br(escape($request['description'])) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Priority</div>
                <div class="detail-value">
                    <span class="badge <?= getPriorityBadgeClass($request['priority']) ?>">
                        <?= escape(getPriorityLabel($request['priority'])) ?>
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="badge <?= getStatusBadgeClass($request['status']) ?>">
                        <?= escape(getStatusLabel($request['status'])) ?>
                    </span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Created</div>
                <div class="detail-value"><?= formatDate($request['created_at']) ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Last Updated</div>
                <div class="detail-value"><?= formatDate($request['updated_at']) ?></div>
            </div>
            
            <div class="detail-row status-update">
                <div class="detail-label">Update Status</div>
                <div class="detail-value">
                    <form method="POST" class="inline-form">
                        <input type="hidden" name="action" value="update_status">
                        <select name="status">
                            <?php foreach ($allStatuses as $status): ?>
                                <option value="<?= escape($status) ?>" <?= $request['status'] === $status ? 'selected' : '' ?>>
                                    <?= escape(getStatusLabel($status)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>