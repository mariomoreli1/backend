import math
import os
import subprocess
import sys

import pytest

from fact import fact_rec, fact_it
from show_employee import show_employee
from sum_and_sub import sum_and_sub
from process_list import process_list, process_list_gen
from my_sum import my_sum
from my_sum_argv import sum_argv
from files_sort import sort_files
from file_search import search_file, first_lines, find_and_show
from email_validation import fun, filter_mail
from fibonacci import fibonacci, cube
from average_scores import compute_average_scores
from plane_angle import Point, plane_angle
from phone_number import sort_phone
from people_sort import name_format
from complex_numbers import Complex
from circle_square_mk import circle_square_mk
from log_decorator import function_logger


# тот же интерпретатор, которым запущен pytest (работает и на Windows, и на Mac)
INTERPRETER = sys.executable
HERE = os.path.dirname(os.path.abspath(__file__))


def run_script(filename, input_data=None, args=None):
    proc = subprocess.run(
        [INTERPRETER, os.path.join(HERE, filename)] + (args or []),
        input='\n'.join(input_data if input_data else []),
        capture_output=True,
        text=True,
        check=False
    )
    return proc.stdout.strip()


test_data = {
    'fact': [
        (1, 1),
        (2, 2),
        (5, 120),
        (10, 3628800),
        (20, 2432902008176640000),
    ],
    'show_employee': [
        (('Иванов Иван Иванович', 30000), 'Иванов Иван Иванович: 30000 ₽'),
        (('Петров Пётр', 0), 'Петров Пётр: 0 ₽'),
        (('Сидоров', 123456), 'Сидоров: 123456 ₽'),
    ],
    'sum_and_sub': [
        ((5, 3), (8, 2)),
        ((3, 5), (8, -2)),
        ((-1.5, -2.5), (-4.0, 1.0)),
        ((0, 0), (0, 0)),
    ],
    'process_list': [
        ([1], [1]),
        ([2], [4]),
        ([1, 2, 3, 4], [1, 4, 27, 16]),
        ([-2, -3, 0], [4, -27, 0]),
    ],
    'my_sum': [
        ((), 0),
        ((5,), 5),
        ((1, 2, 3, 4, 5), 15),
        ((-1, 1, -2, 2), 0),
    ],
    'my_sum_argv': [
        (['1', '2', '3', '4', '5'], '15'),
        (['1.5', '2.5', '0.25'], '4.25'),
        (['-10', '3'], '-7'),
        ([], '0'),
    ],
    'email': [
        ('lara@mospolytech.ru', True),
        ('brian-23@mospolytech.ru', True),
        ('britts_54@mospolytech.ru', True),
        ('a@b.c', True),
        ('user@site.info', False),       # расширение длиннее 3
        ('user@site-name.ru', False),    # тире в названии сайта
        ('us.er@site.ru', False),        # точка в имени
        ('usersite.ru', False),          # нет @
        ('user@site', False),            # нет расширения
        ('user@site.r1', False),         # цифра в расширении
        ('@site.ru', False),             # пустое имя
        ('юзер@site.ru', False),         # не латиница
    ],
    'fibonacci': [
        (1, [0]),
        (2, [0, 1]),
        (5, [0, 1, 1, 2, 3]),
        (10, [0, 1, 1, 2, 3, 5, 8, 13, 21, 34]),
    ],
    'average': [
        ([(89, 90, 78, 93, 80), (90, 91, 85, 88, 86), (91, 92, 83, 89, 90.5)],
         (90.0, 91.0, 82.0, 90.0, 85.5)),
        ([(100,)], (100.0,)),
        ([(0, 100), (100, 0)], (50.0, 50.0)),
    ],
    'phone': [
        (['07895462130', '89875641230', '9195969878'],
         ['+7 (789) 546-21-30', '+7 (919) 596-98-78', '+7 (987) 564-12-30']),
        (['+79161234567'], ['+7 (916) 123-45-67']),
        (['89990000000', '+79000000000', '09500000000'],
         ['+7 (900) 000-00-00', '+7 (950) 000-00-00', '+7 (999) 000-00-00']),
    ],
    'people': [
        ([['Mike', 'Thomson', '20', 'M'], ['Robert', 'Bustle', '32', 'M'], ['Andria', 'Bustle', '30', 'F']],
         ['Mr. Mike Thomson', 'Ms. Andria Bustle', 'Mr. Robert Bustle']),
        ([['Mary', 'George', '25', 'F']], ['Ms. Mary George']),
        # одинаковый возраст - порядок ввода
        ([['B', 'B', '30', 'M'], ['A', 'A', '30', 'F'], ['C', 'C', '5', 'M']],
         ['Mr. C C', 'Mr. B B', 'Ms. A A']),
        # возраст сравнивается как число, а не как строка ('9' < '10')
        ([['Old', 'Man', '10', 'M'], ['Kid', 'Boy', '9', 'M']], ['Mr. Kid Boy', 'Mr. Old Man']),
    ],
    'complex_script': [
        (['2 1', '5 6'],
         ['7.00+7.00i', '-3.00-5.00i', '4.00+17.00i', '0.26-0.11i', '2.24+0.00i', '7.81+0.00i']),
        (['0 1', '0 1'],
         ['0.00+2.00i', '0.00+0.00i', '-1.00+0.00i', '1.00+0.00i', '1.00+0.00i', '1.00+0.00i']),
    ],
    'complex_str': [
        ((1, 2), '1.00+2.00i'),
        ((1, -2), '1.00-2.00i'),
        ((3, 0), '3.00+0.00i'),
        ((0, 4), '0.00+4.00i'),
        ((0, -4), '0.00-4.00i'),
    ],
}


# ---------- 1. fact
@pytest.mark.parametrize("n, expected", test_data['fact'])
def test_fact_it(n, expected):
    assert fact_it(n) == expected


@pytest.mark.parametrize("n, expected", test_data['fact'])
def test_fact_rec(n, expected):
    assert fact_rec(n) == expected


def test_fact_big_same():
    assert fact_rec(3000) == fact_it(3000)


# ---------- 2. show_employee
@pytest.mark.parametrize("args, expected", test_data['show_employee'])
def test_show_employee(args, expected):
    assert show_employee(*args) == expected


def test_show_employee_default():
    assert show_employee('Иванов Иван Иванович') == 'Иванов Иван Иванович: 100000 ₽'


# ---------- 3. sum_and_sub
@pytest.mark.parametrize("args, expected", test_data['sum_and_sub'])
def test_sum_and_sub(args, expected):
    assert sum_and_sub(*args) == pytest.approx(expected)


# ---------- 4. process_list
@pytest.mark.parametrize("arr, expected", test_data['process_list'])
def test_process_list(arr, expected):
    assert process_list(arr) == expected


@pytest.mark.parametrize("arr, expected", test_data['process_list'])
def test_process_list_gen(arr, expected):
    assert list(process_list_gen(arr)) == expected


def test_process_list_gen_is_generator():
    gen = process_list_gen([1, 2])
    assert next(gen) == 1
    assert next(gen) == 4


# ---------- 5. my_sum
@pytest.mark.parametrize("args, expected", test_data['my_sum'])
def test_my_sum(args, expected):
    assert my_sum(*args) == expected


def test_my_sum_float():
    assert my_sum(0.1, 0.2) == pytest.approx(0.3)


# ---------- 6. my_sum_argv
@pytest.mark.parametrize("args, expected", test_data['my_sum_argv'])
def test_my_sum_argv_script(args, expected):
    assert run_script('my_sum_argv.py', args=args) == expected


def test_sum_argv_function():
    assert sum_argv(['1', '2', '3', '4', '5']) == 15


# ---------- 7. files_sort
def test_files_sort_example(tmp_path):
    for name in ['c.txt', 'a.py', 'b.txt', 'c.py', 'a.txt', 'b.py']:
        (tmp_path / name).write_text('')
    assert sort_files(tmp_path) == ['a.py', 'b.py', 'c.py', 'a.txt', 'b.txt', 'c.txt']


def test_files_sort_skip_dirs(tmp_path):
    (tmp_path / 'file.txt').write_text('')
    (tmp_path / 'folder').mkdir()
    (tmp_path / 'folder.py').mkdir()   # папка с "расширением" тоже не выводится
    assert sort_files(tmp_path) == ['file.txt']


def test_files_sort_empty(tmp_path):
    assert sort_files(tmp_path) == []


def test_files_sort_script(tmp_path):
    for name in ['b.md', 'a.md', 'z.c']:
        (tmp_path / name).write_text('')
    assert run_script('files_sort.py', args=[str(tmp_path)]).split('\n') == ['z.c', 'a.md', 'b.md']


# ---------- 8. file_search
def test_file_search_nested(tmp_path):
    deep = tmp_path / 'a' / 'b'
    deep.mkdir(parents=True)
    (deep / 'target.txt').write_text('\n'.join(str(i) for i in range(1, 11)))
    path = search_file('target.txt', tmp_path)
    assert path == str(deep / 'target.txt')
    assert first_lines(path) == ['1', '2', '3', '4', '5']


def test_file_search_short_file(tmp_path):
    (tmp_path / 'short.txt').write_text('one\ntwo')
    assert find_and_show('short.txt', tmp_path) == 'one\ntwo'


def test_file_search_not_found(tmp_path):
    assert find_and_show('nope.txt', tmp_path) == 'Файл nope.txt не найден'


def test_file_search_script_found():
    # ищем сам файл с программой: он точно лежит рядом
    out = run_script('file_search.py', args=['file_search.py'])
    assert out.split('\n') == ['import os', 'import sys', '', '', 'def search_file(filename, start_dir=None):']


def test_file_search_script_not_found():
    assert run_script('file_search.py', args=['no_such_file.xyz']) == 'Файл no_such_file.xyz не найден'


# ---------- 9. email_validation
@pytest.mark.parametrize("email, expected", test_data['email'])
def test_email_fun(email, expected):
    assert fun(email) is expected


def test_email_script():
    data = ['3', 'lara@mospolytech.ru', 'brian-23@mospolytech.ru', 'britts_54@mospolytech.ru']
    assert run_script('email_validation.py', data) == \
        "['brian-23@mospolytech.ru', 'britts_54@mospolytech.ru', 'lara@mospolytech.ru']"


def test_filter_mail_drops_bad():
    assert filter_mail(['good@site.ru', 'bad@site.info']) == ['good@site.ru']


# ---------- 10. fibonacci
@pytest.mark.parametrize("n, expected", test_data['fibonacci'])
def test_fibonacci(n, expected):
    assert fibonacci(n) == expected


def test_cube():
    assert cube(3) == 27


@pytest.mark.parametrize("n, expected", [('5', '[0, 1, 1, 8, 27]'), ('1', '[0]')])
def test_fibonacci_script(n, expected):
    assert run_script('fibonacci.py', [n]) == expected


# ---------- 11. average_scores
@pytest.mark.parametrize("scores, expected", test_data['average'])
def test_average(scores, expected):
    assert compute_average_scores(scores) == pytest.approx(expected)


def test_average_script():
    data = ['5 3', '89 90 78 93 80', '90 91 85 88 86', '91 92 83 89 90.5']
    assert run_script('average_scores.py', data).split('\n') == ['90.0', '91.0', '82.0', '90.0', '85.5']


# ---------- 12. plane_angle
def test_point_sub():
    p = Point(5, 7, 9) - Point(1, 2, 3)
    assert (p.x, p.y, p.z) == (4, 5, 6)


def test_point_dot():
    assert Point(1, 2, 3).dot(Point(4, 5, 6)) == 32


def test_point_cross():
    p = Point(1, 0, 0).cross(Point(0, 1, 0))
    assert (p.x, p.y, p.z) == (0, 0, 1)


def test_plane_angle_same_plane():
    # все точки в одной плоскости z = 0
    assert plane_angle(Point(0, 0, 0), Point(1, 0, 0), Point(1, 1, 0), Point(0, 1, 0)) == pytest.approx(0)


def test_plane_angle_right():
    assert plane_angle(Point(0, 1, 0), Point(0, 0, 0), Point(1, 0, 0), Point(1, 0, 1)) == pytest.approx(90)


def test_plane_angle_script():
    data = ['0 4 5', '1 7 6', '0 5 9', '1 7 2']
    assert run_script('plane_angle.py', data) == '8.19'


# ---------- 13. phone_number
@pytest.mark.parametrize("phones, expected", test_data['phone'])
def test_phone(phones, expected):
    assert sort_phone(phones) == expected


def test_phone_script():
    data = ['3', '07895462130', '89875641230', '9195969878']
    assert run_script('phone_number.py', data).split('\n') == \
        ['+7 (789) 546-21-30', '+7 (919) 596-98-78', '+7 (987) 564-12-30']


# ---------- 14. people_sort
@pytest.mark.parametrize("people, expected", test_data['people'])
def test_people(people, expected):
    assert name_format(people) == expected


# ---------- 15. complex_numbers
@pytest.mark.parametrize("input_data, expected", test_data['complex_script'])
def test_complex_script(input_data, expected):
    assert run_script('complex_numbers.py', input_data).split('\n') == expected


@pytest.mark.parametrize("args, expected", test_data['complex_str'])
def test_complex_str(args, expected):
    assert str(Complex(*args)) == expected


def test_complex_mod():
    assert str(Complex(3, 4).mod()) == '5.00+0.00i'


# ---------- 16. circle_square_mk
@pytest.mark.parametrize("r", [1, 2, 10])
def test_circle_mk_close(r):
    # при 200000 точек ошибка порядка 0.1%, берём с запасом 2%
    assert circle_square_mk(r, 200000) == pytest.approx(math.pi * r ** 2, rel=0.02)


def test_circle_mk_bounds():
    s = circle_square_mk(1, 100)
    assert 0 <= s <= 4


# ---------- 17. log_decorator
def read_log(path):
    return path.read_text(encoding='utf-8').split('\n')


def test_logger_positional(tmp_path):
    log = tmp_path / 'test.log'

    @function_logger(log)
    def greeting_format(name):
        return f'Hello, {name}!'

    assert greeting_format('John') == 'Hello, John!'
    lines = read_log(log)
    assert lines[0] == 'greeting_format'
    assert lines[2] == "('John',)"
    assert lines[3] == 'Hello, John!'
    assert lines[6] == ''   # 6 строк на вызов и перевод строки в конце


def test_logger_kwargs_and_none(tmp_path):
    log = tmp_path / 'test.log'

    @function_logger(log)
    def nothing(a, b=1):
        pass

    nothing(5, b=2)
    lines = read_log(log)
    assert lines[2] == '(5,)'
    assert lines[3] == "{'b': 2}"
    assert lines[4] == '-'


def test_logger_no_args_and_append(tmp_path):
    log = tmp_path / 'test.log'

    @function_logger(log)
    def answer():
        return 42

    answer()
    answer()
    lines = read_log(log)
    # без аргументов - 5 строк на вызов, второй вызов дописался в конец
    assert lines[0] == 'answer' and lines[2] == '42'
    assert lines[5] == 'answer' and lines[7] == '42'


def test_logger_time_format(tmp_path):
    from datetime import datetime
    log = tmp_path / 'test.log'

    @function_logger(log)
    def f():
        return 1

    f()
    lines = read_log(log)
    start = datetime.fromisoformat(lines[1])
    end = datetime.fromisoformat(lines[3])
    assert start <= end
    assert lines[4].startswith('0:00:00')
