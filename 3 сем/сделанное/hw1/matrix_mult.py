def read_matrix(n):
    return [[int(x) for x in input().split()] for _ in range(n)]


def multiply(a, b):
    n = len(a)
    result = [[0] * n for _ in range(n)]

    for i in range(n):
        for j in range(n):
            total = 0
            for k in range(n):
                total += a[i][k] * b[k][j]
            result[i][j] = total

    return result


if __name__ == '__main__':
    size = int(input())
    matrix_a = read_matrix(size)
    matrix_b = read_matrix(size)

    for row in multiply(matrix_a, matrix_b):
        print(*row)
