import subprocess
import pytest

# Для Windows
# INTERPRETER = 'python'
# Для MAC
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
    out = run_script(filename, input_data)
    return out.split('\n') if out else []


from fact import fact_it, fact_rec
from process_list import process_list
from email_validation import fun as is_valid_email, filter_mail
from fibonacci import cube, fibonacci

test_data = {
    'fact': [
        (0, 1),
        (1, 1),
        (5, 120),
        (10, 3628800),
    ],
    'process_list': [
        ([1, 2, 3, 4], [1, 4, 27, 16]),
        ([], []),
        ([0], [0]),
        ([-3, -2], [-27, 4]),
    ],
    'email': [
        ('brian-23@hackerrank.com', True),
        ('britts_54@hackerrank.com', True),
        ('lara@hackerrank.com', True),
        ('1lara@hackerrank.com', False),
        ('lara@hackerrank.commm', False),
        ('lara.hackerrank.com', False),
        ('lara@@hackerrank.com', False),
    ],
    'fibonacci': [
        (0, []),
        (1, [0]),
        (5, [0, 1, 1, 2, 3]),
        (8, [0, 1, 1, 2, 3, 5, 8, 13]),
    ],
    'complex_numbers': [
        (['2 1', '5 6'],
         ['7.00+7.00i', '-3.00-5.00i', '4.00+17.00i',
          '0.26-0.11i', '2.24+0.00i', '7.81+0.00i']),
        (['0 0', '1 1'],
         ['1.00+1.00i', '-1.00-1.00i', '0.00+0.00i',
          '0.00+0.00i', '0.00+0.00i', '1.41+0.00i']),
    ],
    'phone_number': [
        (['3', '07895462130', '919875641230', '9195969878'],
         ['+91 78954 62130', '+91 91959 69878', '+91 98756 41230']),
        (['1', '9876543210'], ['+91 98765 43210']),
    ],
    'people_sort': [
        (['3', 'Mike Thomson 20 M', 'Robert Bustle 32 M', 'Andria Bustle 30 F'],
         ['Mr. Mike Thomson', 'Ms. Andria Bustle', 'Mr. Robert Bustle']),
        (['2', 'Anna Ivanova 40 F', 'Petr Petrov 18 M'],
         ['Mr. Petr Petrov', 'Ms. Anna Ivanova']),
    ],
}


@pytest.mark.parametrize("input_data, expected", test_data['fact'])
def test_fact_it(input_data, expected):
    assert fact_it(input_data) == expected


@pytest.mark.parametrize("input_data, expected", test_data['fact'])
def test_fact_rec(input_data, expected):
    assert fact_rec(input_data) == expected


@pytest.mark.parametrize("input_data, expected", test_data['process_list'])
def test_process_list(input_data, expected):
    assert process_list(input_data) == expected


@pytest.mark.parametrize("input_data, expected", test_data['email'])
def test_email_validation(input_data, expected):
    assert is_valid_email(input_data) is expected


def test_filter_mail():
    emails = ['lara@hackerrank.com', 'bad@@mail.com', '1bad@mail.com']
    assert filter_mail(emails) == ['lara@hackerrank.com']


@pytest.mark.parametrize("input_data, expected", test_data['fibonacci'])
def test_fibonacci(input_data, expected):
    assert fibonacci(input_data) == expected


@pytest.mark.parametrize("value, expected", [(0, 0), (2, 8), (3, 27)])
def test_cube(value, expected):
    assert cube(value) == expected


@pytest.mark.parametrize("input_data, expected", test_data['complex_numbers'])
def test_complex_numbers(input_data, expected):
    assert run_lines('complex_numbers.py', input_data) == expected


@pytest.mark.parametrize("input_data, expected", test_data['phone_number'])
def test_phone_number(input_data, expected):
    assert run_lines('phone_number.py', input_data) == expected


@pytest.mark.parametrize("input_data, expected", test_data['people_sort'])
def test_people_sort(input_data, expected):
    assert run_lines('people_sort.py', input_data) == expected


def test_email_script():
    data = ['3', 'lara@hackerrank.com', 'brian-23@hackerrank.com', 'bad@@mail.com']
    assert run_script('email_validation.py', data) == \
        "['brian-23@hackerrank.com', 'lara@hackerrank.com']"


def test_fibonacci_script():
    assert run_script('fibonacci.py', ['5']) == '[0, 1, 1, 8, 27]'
