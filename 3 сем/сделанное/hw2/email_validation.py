import re

# имя@сайт.домен, где имя начинается с буквы и состоит из букв, цифр, _ и -,
# сайт -- только буквы и цифры, домен -- от 1 до 3 букв
PATTERN = re.compile(r'^[a-zA-Z][a-zA-Z0-9_-]*@[a-zA-Z0-9]+\.[a-zA-Z]{1,3}$')


def fun(s):
    return bool(PATTERN.match(s))


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
