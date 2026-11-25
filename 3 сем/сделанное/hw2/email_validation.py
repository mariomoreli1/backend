import re


def fun(s):
    # username@websitename.extension
    # имя: латиница, цифры, - и _; сайт: латиница и цифры; расширение: 1-3 латинские буквы
    return re.fullmatch(r'[A-Za-z0-9_-]+@[A-Za-z0-9]+\.[A-Za-z]{1,3}', s) is not None


def filter_mail(emails):
    return list(filter(fun, emails))


if __name__ == '__main__':
    n = int(input())
    emails = []
    for _ in range(n):
        emails.append(input())

    filtered_emails = filter_mail(emails)
    filtered_emails.sort()
    print(filtered_emails)
