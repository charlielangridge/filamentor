const fs = require('fs')

const presetPath = [
    './vendor/filament/support/tailwind.config.preset',
    './vendor/filament/filament/tailwind.config.preset',
].find((path) => fs.existsSync(path))

module.exports = {
    presets: presetPath ? [require(presetPath)] : [],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    safelist: [
        ...Array.from({ length: 12 }, (_, i) => `grid-cols-${i + 1}`),
    ],
}
