:construction: **Not ready for production.** :construction:

<p align="center">
<a href="https://github.com/ttrig/kaffapp/actions"><img src="https://github.com/ttrig/kaffapp/workflows/build/badge.svg" alt="Build Status"></a>
<a href="https://codecov.io/gh/ttrig/kaffapp"><img src="https://img.shields.io/codecov/c/github/ttrig/kaffapp/master.svg" alt="Codecov"></a>
<a href="https://github.com/ttrig/kaffapp/blob/master/LICENSE.md"><img src="https://img.shields.io/github/license/ttrig/kaffapp.svg" alt="License"></a>
</p>

# Kaffapp

Lab project using a force sensitive resistor (FSR) to see coffee maker status.

![Screenshot](https://raw.githubusercontent.com/ttrig/kaffapp/master/screenshots/1.png)

## Quickstart

### Dashboard

```shell
cp .env.example .env
touch database/database.sqlite

composer install

npm install
npm run watch

php artisan db:seed
php artisan serve
```

### Microcontroller

`./<todo>`

#### Raspberry

#### Arduino

## Contributing

1. Fork the Project
2. Create your Feature Branch (`git checkout -b amazing-feature`)
3. Commit your Changes (`git commit -m 'Add amazing feature`)
4. Push to the Branch (`git push origin amazing-feature`)
5. Open a Pull Request

## License

Distributed under the [MIT license](./LICENSE.md).
