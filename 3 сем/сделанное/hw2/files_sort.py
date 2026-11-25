import os
import sys


def sort_files(path):
    files = [name for name in os.listdir(path)
             if os.path.isfile(os.path.join(path, name))]
    # сначала группируем по расширению, внутри группы - по имени
    return sorted(files, key=lambda name: (os.path.splitext(name)[1], name))


if __name__ == '__main__':
    if len(sys.argv) < 2:
        print('Укажите путь до директории')
    else:
        for name in sort_files(sys.argv[1]):
            print(name)
