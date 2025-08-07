# php-string-formatter

A simple and configurable string formatting pipeline for PHP.

Define formatting rules using a compact, readable DSL like:

```
padLeft:10:0;replace:_:space;padAfterFirst:11:0
```

This library lets you manipulate strings in a declarative and reusable way — ideal for formatting ticket numbers, codes, IDs, or any value that needs structured transformation.

---

## 🚀 Installation

```bash
composer require ferryhopper/php-string-formatter
```

---

## 🧪 Usage

```php
use StringFormatter\StringFormatter;

$formatted = StringFormatter::apply('K563793', 'remove:space;replace:K:A;padAfterFirst:11:0'');
// Returns: "K 00000563793"
```

---

## 🛠 Supported Formatters

| Formatter                  | Description                                                          |
|----------------------------|----------------------------------------------------------------------|
| `padLeft:length:char`      | Left-pads the string to `length` using `char`.                       |
| `padRight:length:char`     | Right-pads the string to `length` using `char`.                      |
| `replace:search:replace`   | Replaces all occurrences of `search` with `replace`.                |
| `remove:target`            | Removes all occurrences of `target`.                                |
| `padAfterFirst:length:char`| Pads the part after the first character to `length` using `char`.    |

---

## 🔤 Special Keywords

- Use `"space"` instead of a literal space character.
  - `replace:_:space` → replaces `_` with a space
  - `remove:space` → removes all spaces

---

## 🧪 Testing

```bash
vendor/bin/phpunit
```

---

## 📦 Roadmap Ideas

- Custom formatter registration
- Support for named pipelines
- Optional error handling modes (fail-fast vs silent)

---

## 👨‍💻 Authors

Maintained by the [Ferryhopper](https://ferryhopper.com) engineering team.  
Initial development by [@vlahanas](https://github.com/vlahanas).

---

## 📝 License

MIT — see [LICENSE](LICENSE) for details.
