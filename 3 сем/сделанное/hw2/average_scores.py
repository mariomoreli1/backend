def compute_average_scores(scores):
    # zip(*scores) собирает оценки одного студента по всем предметам
    return tuple(sum(student) / len(student) for student in zip(*scores))


if __name__ == '__main__':
    n, x = map(int, input().split())
    scores = [tuple(map(float, input().split())) for _ in range(x)]
    for avg in compute_average_scores(scores):
        print(f'{avg:.1f}')
