<?php
function addContact($pdo) {
    $message = '';
    $errors = [];
    $formData = [
        'surname' => '', 'name' => '', 'lastname' => '', 'gender' => 'мужской',
        'date' => '', 'phone' => '', 'location' => '', 'email' => '', 'comment' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button']) && $_POST['button'] === 'Добавить') {
        $formData = [
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

        if (empty($formData['surname'])) {
            $errors['surname'] = 'Поле обязательно для заполнения';
        }
        if (empty($formData['name'])) {
            $errors['name'] = 'Поле обязательно для заполнения';
        }
        if (empty($formData['phone'])) {
            $errors['phone'] = 'Поле обязательно для заполнения';
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("INSERT INTO contacts (surname, name, lastname, gender, date, phone, location, email, comment) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$formData['surname'], $formData['name'], $formData['lastname'], $formData['gender'], $formData['date'], $formData['phone'], $formData['location'], $formData['email'], $formData['comment']]);
            $message = '<p class="success">Запись добавлена</p>';
            $formData = ['surname' => '', 'name' => '', 'lastname' => '', 'gender' => 'мужской', 'date' => '', 'phone' => '', 'location' => '', 'email' => '', 'comment' => ''];
        } else {
            $message = '<p class="error">Ошибка: не все обязательные поля заполнены</p>';
        }
    }

    $button = 'Добавить';
    $html = $message . '
    <form name="form_add" method="post">
        <div class="column">
            <div class="add">
                <label class="required">Фамилия</label>
                <input type="text" name="surname" placeholder="Фамилия" value="' . htmlspecialchars($formData['surname']) . '" class="' . (isset($errors['surname']) ? 'error-input' : '') . '">';
    if (isset($errors['surname'])) $html .= '<span class="field-error">' . $errors['surname'] . '</span>';
    $html .= '</div>
            <div class="add">
                <label class="required">Имя</label>
                <input type="text" name="name" placeholder="Имя" value="' . htmlspecialchars($formData['name']) . '" class="' . (isset($errors['name']) ? 'error-input' : '') . '">';
    if (isset($errors['name'])) $html .= '<span class="field-error">' . $errors['name'] . '</span>';
    $html .= '</div>
            <div class="add">
                <label>Отчество</label>
                <input type="text" name="lastname" placeholder="Отчество" value="' . htmlspecialchars($formData['lastname']) . '">
            </div>
            <div class="add">
                <label>Пол</label>
                <select name="gender">
                    <option value="мужской"' . ($formData['gender'] == 'мужской' ? ' selected' : '') . '>мужской</option>
                    <option value="женский"' . ($formData['gender'] == 'женский' ? ' selected' : '') . '>женский</option>
                </select>
            </div>
            <div class="add">
                <label>Дата рождения</label>
                <input type="date" name="date" value="' . htmlspecialchars($formData['date']) . '">
            </div>
            <div class="add">
                <label class="required">Телефон</label>
                <input type="text" name="phone" placeholder="Телефон" value="' . htmlspecialchars($formData['phone']) . '" class="' . (isset($errors['phone']) ? 'error-input' : '') . '">';
    if (isset($errors['phone'])) $html .= '<span class="field-error">' . $errors['phone'] . '</span>';
    $html .= '</div>
            <div class="add">
                <label>Адрес</label>
                <input type="text" name="location" placeholder="Адрес" value="' . htmlspecialchars($formData['location']) . '">
            </div>
            <div class="add">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" value="' . htmlspecialchars($formData['email']) . '">
            </div>
            <div class="add">
                <label>Комментарий</label>
                <textarea name="comment" placeholder="Краткий комментарий">' . htmlspecialchars($formData['comment']) . '</textarea>
            </div>
            <button type="submit" value="' . $button . '" name="button" class="form-btn">' . $button . '</button>
        </div>
    </form>';

    return $html;
}