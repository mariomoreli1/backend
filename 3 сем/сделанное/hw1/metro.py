n = int(input())
passengers = []

for _ in range(n):
    a, b = (int(x) for x in input().split())
    passengers.append((a, b))

t = int(input())

print(sum(1 for a, b in passengers if a <= t <= b))
