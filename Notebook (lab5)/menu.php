<?php
function getMenu($activeAction, $activeSort = 'default') {
    $actions = [
        'view'   => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];

    $html = '';
    foreach ($actions as $key => $label) {
        $class = ($key === $activeAction) ? 'select' : '';
        $html .= '<a href="index.php?action=' . $key . '" class="' . $class . '">' . $label . '</a>';
    }

    // Подменю сортировки — только при активном "Просмотр"
    if ($activeAction === 'view') {
        $html .= '</header><div class="submenu">';
        $sorts = [
            'default'   => 'По порядку',
            'surname'   => 'По фамилии',
            'birthdate' => 'По дате рождения'
        ];
        foreach ($sorts as $key => $label) {
            $class = ($key === $activeSort) ? 'select' : '';
            $html .= '<a href="index.php?action=view&sort=' . $key . '" class="' . $class . '">' . $label . '</a>';
        }
        $html .= '</div><header style="display:none;">';
    }

    return $html;
}