<?php
function editContact($pdo) {
    $message = '';
    $errors = [];
    $row = ['id' => '', 'surname' => '', 'name' => '', 'lastname' => '', 'gender' => 'мужской', 'date' => '', 'phone' => '', 'location' => '', 'email' => '', 'comment' => ''];
    $currentId = $_GET['id'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button']) && $_POST['button'] === 'Сохранить') {
        $row = [
            'id' => $_POST['id'] ?? null,
            'surname' => trim($_POST['surname'] ?? ''),
            'name' => trim($_POST['name'] ?? ''),
            'lastname' => trim($_POST['lastname'] ?? ''),
            'gender' => $_POST['gender'] ?? 'мужской',
            'date' => $_POST['date'] ?? '',
            'phone' => trim($_POST['phone'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'comment' => trim($_POST['comment'] ?? '')
        ];

        if (empty($row['surname'])) $errors['surname'] = 'Поле обязательно для заполнения';
        if (empty($row['name'])) $errors['name'] = 'Поле обязательно для заполнения';
        if (empty($row['phone'])) $errors['phone'] = 'Поле обязательно для заполнения';

        if (empty($errors) && $row['id']) {
            $stmt = $pdo->prepare("UPDATE contacts SET surname=?, name=?, lastname=?, gender=?, date=?, phone=?, location=?, email=?, comment=? WHERE id=?");
            $stmt->execute([$row['surname'], $row['name'], $row['lastname'], $row['gender'], $row['date'], $row['phone'], $row['location'], $row['email'], $row['comment'], $row['id']]);
            $message = '<p class="success">Запись обновлена</p>';
            $currentId = $row['id'];
        } elseif (!empty($errors)) {
            $message = '<p class="error">Ошибка: не все обязательные поля заполнены</p>';
        }
    }

    $stmt = $pdo->query("SELECT id, surname, name FROM contacts ORDER BY surname ASC, name ASC");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$currentId && count($contacts) > 0) {
        $currentId = $contacts[0]['id'];
    }

    if ($currentId && empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
        $stmt->execute([$currentId]);
        $loaded = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($loaded) $row = $loaded;
    }

    $button = 'Сохранить';

    $html = '<div class="div-edit">';
    foreach ($contacts as $c) {
        $class = ($c['id'] == $currentId) ? 'currentRow' : '';
        $html .= '<a href="index.php?action=edit&id=' . $c['id'] . '" class="' . $class . '">' . htmlspecialchars($c['surname'] . ' ' . $c['name']) . '</a>';
    }
    $html .= '</div>' . $message . '
    <form name="form_add" method="post">
        <input type="hidden" name="id" value="' . $currentId . '">
        <div class="column">
            <div class="add">
                <label class="required">Фамилия</label>
                <input type="text" name="surname" placeholder="Фамилия" value="' . htmlspecialchars($row['surname']) . '" class="' . (isset($errors['surname']) ? 'error-input' : '') . '">';
    if (isset($errors['surname'])) $html .= '<span class="field-error">' . $errors['surname'] . '</span>';
    $html .= '</div>
            <div class="add">
                <label class="required">Имя</label>
                <input type="text" name="name" placeholder="Имя" value="' . htmlspecialchars($row['name']) . '" class="' . (isset($errors['name']) ? 'error-input' : '') . '">';
    if (isset($errors['name'])) $html .= '<span class="field-error">' . $errors['name'] . '</span>';
    $html .= '</div>
            <div class="add">
                <label>Отчество</label>
                <input type="text" name="lastname" placeholder="Отчество" value="' . htmlspecialchars($row['lastname'] ?? '') . '">
            </div>
            <div class="add">
                <label>Пол</label>
                <select name="gender">
                    <option value="мужской"' . (($row['gender'] ?? '') == 'мужской' ? ' selected' : '') . '>мужской</option>
                    <option value="женский"' . (($row['gender'] ?? '') == 'женский' ? ' selected' : '') . '>женский</option>
                </select>
            </div>
            <div class="add">
                <label>Дата рождения</label>
                <input type="date" name="date" value="' . htmlspecialchars($row['date'] ?? '') . '">
            </div>
            <div class="add">
                <label class="required">Телефон</label>
                <input type="text" name="phone" placeholder="Телефон" value="' . htmlspecialchars($row['phone'] ?? '') . '" class="' . (isset($errors['phone']) ? 'error-input' : '') . '">';
    if (isset($errors['phone'])) $html .= '<span class="field-error">' . $errors['phone'] . '</span>';
    $html .= '</div>
            <div class="add">
                <label>Адрес</label>
                <input type="text" name="location" placeholder="Адрес" value="' . htmlspecialchars($row['location'] ?? '') . '">
            </div>
            <div class="add">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" value="' . htmlspecialchars($row['email'] ?? '') . '">
            </div>
            <div class="add">
                <label>Комментарий</label>
                <textarea name="comment" placeholder="Краткий комментарий">' . htmlspecialchars($row['comment'] ?? '') . '</textarea>
            </div>
            <button type="submit" value="' . $button . '" name="button" class="form-btn">' . $button . '</button>
        </div>
    </form>';

    return $html;
}