def sum_and_sub(a, b):
    return a + b, a - b


if __name__ == '__main__':
    a, b = map(float, input().split())
    print(*sum_and_sub(a, b))
