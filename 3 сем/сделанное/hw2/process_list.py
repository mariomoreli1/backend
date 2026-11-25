def process_list(arr):
    # то же самое, что цикл из задания, но через list comprehension
    return [i ** 2 if i % 2 == 0 else i ** 3 for i in arr]


def process_list_gen(arr):
    # генератор: отдаёт значения по одному, список целиком не хранит
    for i in arr:
        if i % 2 == 0:
            yield i ** 2
        else:
            yield i ** 3


# Сравнение скорости (timeit, список из 1000 чисел):
#   list comprehension      0.000176 c
#   генератор + list(...)   0.000183 c
# Вывод: list comprehension немного быстрее (~4%), если нужен весь список сразу.
# Генератор выигрывает по памяти: значения считаются по одному, когда их запрашивают,
# поэтому он удобнее, если результат нужно просто перебрать один раз.


if __name__ == '__main__':
    import timeit

    arr = list(range(1, 1001))
    t_list = timeit.timeit(lambda: process_list(arr), number=1000) / 1000
    t_gen = timeit.timeit(lambda: list(process_list_gen(arr)), number=1000) / 1000
    print(f'list comprehension: {t_list:.7f} c')
    print(f'генератор (list(...)): {t_gen:.7f} c')
