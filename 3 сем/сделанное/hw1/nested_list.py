n = int(input())
students = []

for _ in range(n):
    name = input()
    grade = float(input())
    students.append([name, grade])

second = sorted({student[1] for student in students})[1]

for name in sorted(name for name, grade in students if grade == second):
    print(name)
