<?php

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function getStatusLabel($status) {
    $labels = [
        'new' => 'New',
        'in_progress' => 'In Progress',
        'closed' => 'Closed'
    ];
    return $labels[$status] ?? $status;
}

function getStatusBadgeClass($status) {
    $classes = [
        'new' => 'badge-new',
        'in_progress' => 'badge-in-progress',
        'closed' => 'badge-closed'
    ];
    return $classes[$status] ?? '';
}

function getPriorityLabel($priority) {
    $labels = [
        'low' => 'Low',
        'normal' => 'Normal',
        'high' => 'High'
    ];
    return $labels[$priority] ?? $priority;
}

function getPriorityBadgeClass($priority) {
    $classes = [
        'low' => 'badge-low',
        'normal' => 'badge-normal',
        'high' => 'badge-high'
    ];
    return $classes[$priority] ?? '';
}

function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function formatDate($date) {
    return date('M d, Y H:i', strtotime($date));
}