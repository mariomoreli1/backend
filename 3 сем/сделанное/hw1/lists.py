n = int(input())
arr = []

for _ in range(n):
    parts = input().split()
    command = parts[0]
    args = [int(x) for x in parts[1:]]

    if command == 'print':
        print(arr)
    else:
        getattr(arr, command)(*args)
