import datetime
import functools


def function_logger(path):
    def decorator(func):
        @functools.wraps(func)
        def wrapper(*args, **kwargs):
            start = datetime.datetime.now()
            result = func(*args, **kwargs)
            end = datetime.datetime.now()

            lines = [func.__name__, str(start)]
            if args:
                lines.append(str(args))
            if kwargs:
                lines.append(str(kwargs))
            lines.append('-' if result is None else str(result))
            lines.append(str(end))
            lines.append(str(end - start))

            # режим 'a': файла нет - создастся, есть - допишем в конец
            with open(path, 'a', encoding='utf-8') as f:
                f.write('\n'.join(lines) + '\n')
            return result
        return wrapper
    return decorator


if __name__ == '__main__':
    @function_logger('test.log')
    def greeting_format(name):
        return f'Hello, {name}!'

    greeting_format('John')
