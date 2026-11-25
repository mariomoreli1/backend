def my_sum(*args):
    total = 0
    for x in args:
        total += x
    return total


if __name__ == '__main__':
    print(my_sum(1, 2, 3, 4, 5))
