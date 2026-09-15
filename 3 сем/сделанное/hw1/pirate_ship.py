def fmt(value):
    """Целые значения печатаем без дробной части, дробные -- с двумя знаками."""
    value = round(value + 0.0, 2)
    if value == int(value):
        return str(int(value))
    return '%.2f' % value


n, m = (int(x) for x in input().split())

items = []
for _ in range(m):
    name, weight, price = input().split()
    items.append([name, int(weight), int(price)])

# жадный алгоритм: сначала берём то, что дороже за килограмм
items.sort(key=lambda item: item[2] / item[1], reverse=True)

capacity = n
taken = []
for name, weight, price in items:
    if capacity <= 0:
        break
    part = min(weight, capacity)
    taken.append((name, part, price * part / weight))
    capacity -= part

taken.sort(key=lambda item: item[2], reverse=True)

for name, weight, price in taken:
    print(name, fmt(weight), fmt(price))
