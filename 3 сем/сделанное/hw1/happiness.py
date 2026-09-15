n, m = (int(x) for x in input().split())
numbers = [int(x) for x in input().split()]
a = set(int(x) for x in input().split())
b = set(int(x) for x in input().split())

happiness = 0
for number in numbers:
    if number in a:
        happiness += 1
    elif number in b:
        happiness -= 1

print(happiness)
