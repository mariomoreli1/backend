VOWELS = 'AEIOU'


def minion_game(string):
    kevin = 0
    stuart = 0

    for i, letter in enumerate(string):
        # из позиции i начинается ровно len(string) - i подстрок
        if letter in VOWELS:
            kevin += len(string) - i
        else:
            stuart += len(string) - i

    if kevin > stuart:
        print('Кевин', kevin)
    elif stuart > kevin:
        print('Стюарт', stuart)
    else:
        print('Ничья')


if __name__ == '__main__':
    minion_game(input().strip().upper())
