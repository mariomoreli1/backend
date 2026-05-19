<?php
function getViewer($pdo, $sort, $page) {
    $perPage = 10;
    $offset = ($page - 1) * $perPage;

    switch ($sort) {
        case 'surname':
            $order = 'surname ASC, name ASC';
            break;
        case 'birthdate':
            $order = 'date ASC';
            break;
        default:
            $order = 'created_at ASC';
            break;
    }

    $stmt = $pdo->query("SELECT COUNT(*) FROM contacts");
    $total = $stmt->fetchColumn();
    $totalPages = ceil($total / $perPage);

    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY $order LIMIT $perPage OFFSET $offset");
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '<table><tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th><th>Дата рождения</th><th>Телефон</th><th>Адрес</th><th>Email</th><th>Комментарий</th></tr>';

    foreach ($contacts as $c) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($c['surname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($c['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($c['lastname'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($c['gender'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($c['date'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($c['phone'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($c['location'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($c['email'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($c['comment'] ?? '') . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    if ($totalPages > 1) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                $html .= '<strong>' . $i . '</strong>';
            } else {
                $html .= '<a href="index.php?action=view&sort=' . $sort . '&page=' . $i . '">' . $i . '</a>';
            }
        }
        $html .= '</div>';
    }

    return $html;
}