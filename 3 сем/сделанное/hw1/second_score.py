input()
scores = [int(x) for x in input().split()]

print(sorted(set(scores))[-2])
