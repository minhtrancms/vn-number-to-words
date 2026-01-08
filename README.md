# VN Number to Words

[![Latest Stable Version](https://poser.pugx.org/nhatminh/vn-number-to-words/v)](https://packagist.org/packages/nhatminh/vn-number-to-words)
[![License](https://poser.pugx.org/nhatminh/vn-number-to-words/license)](https://packagist.org/packages/nhatminh/vn-number-to-words)

Chuyển đổi số thành chữ tiếng Việt / Convert numbers to Vietnamese words.

## ✨ Features

- ✅ Số nguyên (integers)
- ✅ Số âm (negative numbers)
- ✅ Số thập phân (decimal numbers)
- ✅ Số lớn đến hàng nghìn tỷ
- ✅ Hỗ trợ format tiền tệ
- ✅ Xử lý đúng các trường hợp đặc biệt: "mười một", "hai mươi mốt", "linh", "lăm", "tư"

## 📦 Installation

```bash
composer require nhatminh/vn-number-to-words
```

## 🚀 Usage

### Basic Usage

```php
<?php

require_once 'vendor/autoload.php';

use NhatMinh\VnNumberToWords\NumberToWords;

// Basic conversion
echo NumberToWords::convert(123);
// Output: một trăm hai mươi ba

echo NumberToWords::convert(1234567);
// Output: một triệu hai trăm ba mươi bốn nghìn năm trăm sáu mươi bảy

// Negative numbers
echo NumberToWords::convert(-100);
// Output: âm một trăm

// Decimal numbers
echo NumberToWords::convert(123.45);
// Output: một trăm hai mươi ba phẩy bốn năm
```

### With Currency

```php
echo NumberToWords::convertWithCurrency(1500000);
// Output: một triệu năm trăm nghìn đồng

echo NumberToWords::convertWithCurrency(1500000, 'VND');
// Output: một triệu năm trăm nghìn VND
```

## 📋 Examples

| Number | Vietnamese |
|--------|------------|
| `0` | không |
| `1` | một |
| `10` | mười |
| `11` | mười một |
| `21` | hai mươi mốt |
| `24` | hai mươi tư |
| `25` | hai mươi lăm |
| `100` | một trăm |
| `105` | một trăm linh năm |
| `110` | một trăm mười |
| `1000` | một nghìn |
| `1000000` | một triệu |
| `1000000000` | một tỷ |

## 🧪 Testing

```bash
composer test
```

## 📄 License

MIT License. See [LICENSE](LICENSE) file.

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 👨‍💻 Author

- **Nhat Minh**
