import os
import re

FILENAME = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'example.txt')

with open(FILENAME, encoding='utf-8') as f:
    text = f.read()

# слово -- только буквы, знаки препинания и спецсимволы отбрасываем
words = re.findall(r'[^\W\d_]+', text, flags=re.UNICODE)

if words:
    max_length = max(len(word) for word in words)

    printed = set()
    for word in words:
        if len(word) == max_length and word.lower() not in printed:
            printed.add(word.lower())
            print(word)
