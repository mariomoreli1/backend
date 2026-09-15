<?php
function deleteContact($pdo) {
    $message = '';
    $deleteId = $_GET['del_id'] ?? null;

    if ($deleteId) {
        $stmt = $pdo->prepare("SELECT surname FROM contacts WHERE id = ?");
        $stmt->execute([$deleteId]);
        $surname = $stmt->fetchColumn();

        if ($surname) {
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
            $stmt->execute([$deleteId]);
            $message = '<p class="success">Запись с фамилией ' . htmlspecialchars($surname) . ' удалена</p>';
        }
    }

    $stmt = $pdo->query("SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = $message . '<div class="delete-list">';
    foreach ($contacts as $c) {
        $initials = $c['surname'];
        if ($c['name']) $initials .= ' ' . mb_substr($c['name'], 0, 1) . '.';
        if ($c['lastname']) $initials .= mb_substr($c['lastname'], 0, 1) . '.';
        $html .= '<a href="index.php?action=delete&del_id=' . $c['id'] . '">' . htmlspecialchars($initials) . '</a>';
    }
    $html .= '</div>';

    return $html;
}