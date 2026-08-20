<?php

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/includes/Database.php';
require_once BASE_PATH . '/includes/Request.php';
require_once BASE_PATH . '/includes/Validator.php';
require_once BASE_PATH . '/includes/helpers.php';

$requestModel = new Request();

// Get filters from GET parameters
$filters = [];
if (!empty($_GET['status'])) {
    $filters['status'] = $_GET['status'];
}
if (!empty($_GET['priority'])) {
    $filters['priority'] = $_GET['priority'];
}
if (!empty($_GET['search'])) {
    $filters['search'] = trim($_GET['search']);
}

$requests = $requestModel->getAll($filters);

// Get unique statuses and priorities for filter dropdowns
$allStatuses = ['new', 'in_progress', 'closed'];
$allPriorities = ['low', 'normal', 'high'];

// Handle status update via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_status' && isset($_POST['id']) && isset($_POST['status'])) {
        $id = (int)$_POST['id'];
        $status = $_POST['status'];
        
        if (in_array($status, $allStatuses)) {
            $requestModel->updateStatus($id, $status);
            // Redirect to avoid form resubmission
            redirect('index.php?' . http_build_query($_GET));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Request System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Customer Request Management</h1>
            <a href="create.php" class="btn btn-primary">+ New Request</a>
        </header>

        <!-- Filters -->
        <div class="filters">
            <form method="GET" class="filter-form">
                <div class="filter-group">
                    <label>Status:</label>
                    <select name="status" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <?php foreach ($allStatuses as $status): ?>
                            <option value="<?= escape($status) ?>" <?= isset($_GET['status']) && $_GET['status'] === $status ? 'selected' : '' ?>>
                                <?= escape(getStatusLabel($status)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Priority:</label>
                    <select name="priority" onchange="this.form.submit()">
                        <option value="">All Priorities</option>
                        <?php foreach ($allPriorities as $priority): ?>
                            <option value="<?= escape($priority) ?>" <?= isset($_GET['priority']) && $_GET['priority'] === $priority ? 'selected' : '' ?>>
                                <?= escape(getPriorityLabel($priority)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group search-group">
                    <input type="text" name="search" placeholder="Search by name or email..." value="<?= isset($_GET['search']) ? escape($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-secondary">Search</button>
                    <?php if (!empty($_GET)): ?>
                        <a href="index.php" class="btn btn-secondary">Clear</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Request List -->
        <?php if (empty($requests)): ?>
            <div class="empty-state">
                <p>No requests found.</p>
            </div>
        <?php else: ?>
            <div class="request-list">
                <?php foreach ($requests as $request): ?>
                    <div class="request-card">
                        <div class="request-header">
                            <h3><a href="view.php?id=<?= $request['id'] ?>"><?= escape($request['subject']) ?></a></h3>
                            <div class="request-badges">
                                <span class="badge <?= getPriorityBadgeClass($request['priority']) ?>">
                                    <?= escape(getPriorityLabel($request['priority'])) ?>
                                </span>
                                <span class="badge <?= getStatusBadgeClass($request['status']) ?>">
                                    <?= escape(getStatusLabel($request['status'])) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="request-body">
                            <div class="request-meta">
                                <span><strong>Client:</strong> <?= escape($request['fullname']) ?></span>
                                <span><strong>Email:</strong> <?= escape($request['email']) ?></span>
                                <span><strong>Created:</strong> <?= formatDate($request['created_at']) ?></span>
                            </div>
                            <div class="request-actions">
                                <a href="edit.php?id=<?= $request['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="view.php?id=<?= $request['id'] ?>" class="btn btn-sm btn-secondary">View Details</a>
                                <form method="POST" class="status-update-form" style="display: inline;">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?= $request['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="status-select">
                                        <?php foreach ($allStatuses as $status): ?>
                                            <option value="<?= escape($status) ?>" <?= $request['status'] === $status ? 'selected' : '' ?>>
                                                <?= escape(getStatusLabel($status)) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>