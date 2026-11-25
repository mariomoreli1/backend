import os
import sys


def search_file(filename, start_dir=None):
    # ищем относительно папки, где лежит сама программа
    if start_dir is None:
        start_dir = os.path.dirname(os.path.abspath(__file__))
    for root, dirs, files in os.walk(start_dir):
        if filename in files:
            return os.path.join(root, filename)
    return None


def first_lines(path, count=5):
    lines = []
    with open(path, encoding='utf-8') as f:
        for line in f:
            if len(lines) == count:
                break
            lines.append(line.rstrip('\n'))
    return lines


def find_and_show(filename, start_dir=None):
    path = search_file(filename, start_dir)
    if path is None:
        return f'Файл {filename} не найден'
    return '\n'.join(first_lines(path))


if __name__ == '__main__':
    if len(sys.argv) < 2:
        print('Укажите имя файла')
    else:
        print(find_and_show(sys.argv[1]))
