import random


def circle_square_mk(r, n):
    # кидаем n точек в квадрат [-r, r] x [-r, r] и считаем, сколько попало в круг
    inside = 0
    for _ in range(n):
        x = random.uniform(-r, r)
        y = random.uniform(-r, r)
        if x * x + y * y <= r * r:
            inside += 1
    return (2 * r) ** 2 * inside / n


# Погрешность (r = 1, точное значение pi = 3.14159..., среднее по 20 запускам):
#   n = 100       ~5 %
#   n = 1000      ~1.3 %
#   n = 10000     ~0.5 %
#   n = 100000    ~0.1 %
#   n = 1000000   ~0.04 %
# Вывод: погрешность падает примерно как 1/sqrt(n) - чтобы уменьшить её в 10 раз,
# нужно в 100 раз больше экспериментов.


if __name__ == '__main__':
    import math

    r = 1
    exact = math.pi * r ** 2
    for n in (100, 1000, 10000, 100000, 1000000):
        errors = [abs(circle_square_mk(r, n) - exact) / exact * 100 for _ in range(20)]
        print(f'n = {n}: средняя погрешность {sum(errors) / len(errors):.3f} %')
