const mix = require('laravel-mix')

mix.webpackConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js/')
    }
  }
})

mix.copy('./node_modules/@fortawesome/fontawesome-free/css/all.min.css', 'public/fonts/font-awesome.css');
mix.copy('./node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');

mix.js('resources/js/index.js', 'public/js')
  .js('resources/js/device.js', 'public/js')

mix.sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [
      require('tailwindcss')('tailwind.config.js')
    ]
  })

if (mix.inProduction()) {
  mix.version()
} else {
  mix.sourceMaps()
}

mix.browserSync({
  proxy: 'localhost:8000',
  open: false,
})
