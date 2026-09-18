import subprocess
import pytest


INTERPRETER = 'python3'


def run_script(filename, input_data=None):
    proc = subprocess.run(
        [INTERPRETER, filename],
        input='\n'.join(input_data if input_data else []),
        capture_output=True,
        text=True,
        check=False
    )
    return proc.stdout.strip()


def run_lines(filename, input_data=None):
    """Тот же запуск, но результат разбит на список строк."""
    out = run_script(filename, input_data)
    return out.split('\n') if out else []


test_data = {
    'python_if_else': [
        ('1', 'Weird'),
        ('2', 'Not Weird'),
        ('3', 'Weird'),
        ('4', 'Not Weird'),
        ('5', 'Weird'),
        ('6', 'Weird'),
        ('20', 'Weird'),
        ('22', 'Not Weird'),
        ('99', 'Weird'),
        ('100', 'Not Weird'),
    ],
    'arithmetic_operators': [
        (['1', '2'], ['3', '-1', '2']),
        (['10', '5'], ['15', '5', '50']),
        (['3', '5'], ['8', '-2', '15']),
        (['1', '1'], ['2', '0', '1']),
        (['10000000000', '10000000000'], ['20000000000', '0', '100000000000000000000']),
    ],
    'division': [
        (['3', '5'], ['0', '0.6']),
        (['10', '2'], ['5', '5.0']),
        (['7', '7'], ['1', '1.0']),
        (['-7', '2'], ['-4', '-3.5']),
        (['5', '0'], ['Деление на ноль невозможно']),
    ],
    'loops': [
        ('1', ['0']),
        ('3', ['0', '1', '4']),
        ('5', ['0', '1', '4', '9', '16']),
    ],
    'print_function': [
        ('1', '1'),
        ('3', '123'),
        ('5', '12345'),
        ('10', '12345678910'),
    ],
    'second_score': [
        (['5', '2 3 6 6 5'], '5'),
        (['2', '1 2'], '1'),
        (['5', '5 5 5 4 4'], '4'),
        (['4', '-1 -2 -3 -4'], '-2'),
        (['6', '10 10 9 9 8 8'], '9'),
    ],
    'nested_list': [
        (['3', 'chi', '20.0', 'beta', '50.0', 'alpha', '50.0'], ['alpha', 'beta']),
        (['5', 'Гарри', '37.21', 'Берри', '37.21', 'Тина', '37.2',
          'Акрити', '41', 'Харш', '39'], ['Берри', 'Гарри']),
        (['2', 'Ivan', '10', 'Petr', '20'], ['Petr']),
    ],
    'lists': [
        (['4', 'append 1', 'append 2', 'insert 1 3', 'print'], ['[1, 3, 2]']),
        (['12', 'insert 0 5', 'insert 1 10', 'insert 0 6', 'print', 'remove 6',
          'append 9', 'append 1', 'sort', 'print', 'pop', 'reverse', 'print'],
         ['[6, 5, 10]', '[1, 5, 9, 10]', '[9, 5, 1]']),
        (['3', 'append 7', 'append 3', 'print'], ['[7, 3]']),
        (['5', 'append 2', 'append 1', 'sort', 'reverse', 'print'], ['[2, 1]']),
    ],
    'swap_case': [
        ('Www.MosPolytech.ru', 'wWW.mOSpOLYTECH.RU'),
        ('Pythonist 2', 'pYTHONIST 2'),
        ('HELLO', 'hello'),
        ('hello', 'HELLO'),
        ('123 !?', '123 !?'),
    ],
    'split_and_join': [
        ('this is a string', 'this-is-a-string'),
        ('word', 'word'),
        ('a b', 'a-b'),
        ('раз два три', 'раз-два-три'),
    ],
    'anagram': [
        (['abc', 'cba'], 'YES'),
        (['abc', 'abd'], 'NO'),
        (['aabb', 'bbaa'], 'YES'),
        (['abc', 'abcd'], 'NO'),
        (['a', 'a'], 'YES'),
    ],
    'metro': [
        (['3', '1 5', '2 8', '10 20', '4'], '2'),
        (['3', '1 5', '2 8', '10 20', '5'], '2'),
        (['3', '1 5', '2 8', '10 20', '9'], '0'),
        (['3', '1 5', '2 8', '10 20', '10'], '1'),
        (['1', '1 100', '50'], '1'),
    ],
    'minion_game': [
        ('BANANA', 'Стюарт 12'),
        ('A', 'Кевин 1'),
        ('B', 'Стюарт 1'),
        ('ABB', 'Ничья'),
        ('BAANANAS', 'Кевин 19'),
    ],
    'is_leap': [
        ('1990', 'False'),
        ('2000', 'True'),
        ('1900', 'False'),
        ('2016', 'True'),
        ('2100', 'False'),
        ('2400', 'True'),
        ('2023', 'False'),
    ],
    'happiness': [
        (['3 2', '1 5 3', '3 1', '5 7'], '1'),
        (['3 2', '1 1 1', '1 2', '3 4'], '3'),
        (['3 2', '7 8 9', '1 2', '3 4'], '0'),
        (['2 1', '4 4', '1', '4'], '-2'),
    ],
    'pirate_ship': [
        (['10 3', 'золото 5 100', 'серебро 10 50', 'медь 4 40'],
         ['золото 5 100', 'медь 4 40', 'серебро 1 5']),
        (['3 1', 'золото 5 100'], ['золото 3 60']),
        (['2 1', 'руда 3 10'], ['руда 2 6.67']),
        (['100 2', 'ром 10 30', 'ткань 20 40'], ['ткань 20 40', 'ром 10 30']),
    ],
    'matrix_mult': [
        (['2', '1 2', '3 4', '5 6', '7 8'], ['19 22', '43 50']),
        (['2', '1 0', '0 1', '5 6', '7 8'], ['5 6', '7 8']),
        (['2', '0 0', '0 0', '1 2', '3 4'], ['0 0', '0 0']),
        (['3', '1 2 3', '4 5 6', '7 8 9',
          '1 0 0', '0 1 0', '0 0 1'], ['1 2 3', '4 5 6', '7 8 9']),
    ],
}


# 1) Hello, World!
def test_hello_world():
    assert run_script('hello_world.py') == 'Hello, world!'


def test_hello():
    assert run_script('hello.py') == 'Hello, World!'


# 2) Python If-Else
@pytest.mark.parametrize("input_data, expected", test_data['python_if_else'])
def test_python_if_else(input_data, expected):
    assert run_script('python_if_else.py', [input_data]) == expected


# 3) Арифметические операторы
@pytest.mark.parametrize("input_data, expected", test_data['arithmetic_operators'])
def test_arithmetic_operators(input_data, expected):
    assert run_lines('arithmetic_operators.py', input_data) == expected


# 4) Деление
@pytest.mark.parametrize("input_data, expected", test_data['division'])
def test_division(input_data, expected):
    assert run_lines('division.py', input_data) == expected


# 5) Циклы
@pytest.mark.parametrize("input_data, expected", test_data['loops'])
def test_loops(input_data, expected):
    assert run_lines('loops.py', [input_data]) == expected


# 6) Функция вывода
@pytest.mark.parametrize("input_data, expected", test_data['print_function'])
def test_print_function(input_data, expected):
    assert run_script('print_function.py', [input_data]) == expected


# 7) Второе место
@pytest.mark.parametrize("input_data, expected", test_data['second_score'])
def test_second_score(input_data, expected):
    assert run_script('second_score.py', input_data) == expected


# 8) Вложенные списки
@pytest.mark.parametrize("input_data, expected", test_data['nested_list'])
def test_nested_list(input_data, expected):
    assert run_lines('nested_list.py', input_data) == expected


# 9) Списки
@pytest.mark.parametrize("input_data, expected", test_data['lists'])
def test_lists(input_data, expected):
    assert run_lines('lists.py', input_data) == expected


# 10) Обмен регистра
@pytest.mark.parametrize("input_data, expected", test_data['swap_case'])
def test_swap_case(input_data, expected):
    assert run_script('swap_case.py', [input_data]) == expected


# 11) Разделение и объединение строк
@pytest.mark.parametrize("input_data, expected", test_data['split_and_join'])
def test_split_and_join(input_data, expected):
    assert run_script('split_and_join.py', [input_data]) == expected


# 12) Слово максимальной длины
def test_max_word():
    assert run_script('max_word.py') == 'сосредоточенности'


def test_max_word_single_line():
    assert len(run_lines('max_word.py')) == 1


# 13) Агрегирование данных
def test_price_sum():
    assert run_script('price_sum.py') == '6842.84 5891.06 6810.90'


def test_price_sum_format():
    assert all(len(value.split('.')[1]) == 2
               for value in run_script('price_sum.py').split())


# 14) Анаграммы
@pytest.mark.parametrize("input_data, expected", test_data['anagram'])
def test_anagram(input_data, expected):
    assert run_script('anagram.py', input_data) == expected


# 15) Пассажиры в метро
@pytest.mark.parametrize("input_data, expected", test_data['metro'])
def test_metro(input_data, expected):
    assert run_script('metro.py', input_data) == expected


# 16) Игра миньонов
@pytest.mark.parametrize("input_data, expected", test_data['minion_game'])
def test_minion_game(input_data, expected):
    assert run_script('minion_game.py', [input_data]) == expected


# 17) Високосный год
@pytest.mark.parametrize("input_data, expected", test_data['is_leap'])
def test_is_leap(input_data, expected):
    assert run_script('is_leap.py', [input_data]) == expected


# 18) Предпочтения
@pytest.mark.parametrize("input_data, expected", test_data['happiness'])
def test_happiness(input_data, expected):
    assert run_script('happiness.py', input_data) == expected


# 19) Пиратский корабль
@pytest.mark.parametrize("input_data, expected", test_data['pirate_ship'])
def test_pirate_ship(input_data, expected):
    assert run_lines('pirate_ship.py', input_data) == expected


# 20) Произведение матриц
@pytest.mark.parametrize("input_data, expected", test_data['matrix_mult'])
def test_matrix_mult(input_data, expected):
    assert run_lines('matrix_mult.py', input_data) == expected
