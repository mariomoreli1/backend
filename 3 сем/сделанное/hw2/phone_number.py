def wrapper(f):
    def fun(l):
        # приводим номера к виду +91 xxxxx xxxxx и передаём дальше на сортировку
        return f(['+91 ' + number[-10:-5] + ' ' + number[-5:] for number in l])
    return fun


@wrapper
def sort_phone(l):
    return sorted(l)


if __name__ == '__main__':
    l = [input() for _ in range(int(input()))]
    print(*sort_phone(l), sep='\n')
