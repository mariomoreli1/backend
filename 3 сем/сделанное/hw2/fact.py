def fact_it(n):
    """Факториал, вычисленный итеративно (циклом)."""
    result = 1
    for i in range(2, n + 1):
        result *= i
    return result


def fact_rec(n):
    """Факториал, вычисленный рекурсивно."""
    if n <= 1:
        return 1
    return n * fact_rec(n - 1)


if __name__ == '__main__':
    print(fact_it(int(input())))
