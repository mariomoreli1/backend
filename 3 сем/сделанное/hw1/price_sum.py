import csv
import os

FILENAME = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'products.csv')

totals = [0.0, 0.0, 0.0]

with open(FILENAME, encoding='utf-8') as f:
    reader = csv.reader(f)
    next(reader)  # пропускаем строку с заголовками
    for row in reader:
        if not row:
            continue
        for i in range(3):
            totals[i] += float(row[i + 1])

print(' '.join('%.2f' % total for total in totals))
