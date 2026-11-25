import sys

from my_sum import my_sum


def sum_argv(args):
    numbers = [float(x) for x in args]
    result = my_sum(*numbers)
    # чтобы 1 2 3 4 5 давало 15, а не 15.0
    if result == int(result):
        return int(result)
    return result


if __name__ == '__main__':
    print(sum_argv(sys.argv[1:]))
