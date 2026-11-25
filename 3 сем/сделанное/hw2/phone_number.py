import re


def wrapper(f):
    def fun(l):
        result = []
        for phone in l:
            # оставляем только цифры, последние 10 - сам номер (префикс 8, +7, 0 отбрасываем)
            digits = re.sub(r'\D', '', phone)[-10:]
            result.append(f'+7 ({digits[:3]}) {digits[3:6]}-{digits[6:8]}-{digits[8:]}')
        return f(result)
    return fun


@wrapper
def sort_phone(l):
    return sorted(l)


if __name__ == '__main__':
    l = [input() for _ in range(int(input()))]
    print(*sort_phone(l), sep='\n')
